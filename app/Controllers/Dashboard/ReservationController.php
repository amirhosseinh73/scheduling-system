<?php

namespace App\Controllers\Dashboard;

use App\Controllers\ParentController;
use App\Libraries\Alert;
use App\Libraries\TextLibrary;
use App\Models\BookingModel;
use App\Models\PaymentRequestModel;
use App\Models\PaymentTrackModel;
use App\Models\ReservationModel;
use App\Models\UserModel;

class ReservationController extends ParentController {
    public function index() {
        $user_info = get_user_info();

        $data_page = array(
            "title_head"        => TextLibrary::title( "reservation" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "page_name"         => "reservation_index",
            "user_info"         => $user_info,
        );

        return $this->renderPageDashboard( "reservation-index", $data_page );
    }

    public function submit()
    {
        $user_info = get_user_info();

        $booking_ID = $this->request->getPost( "ID" );

        if ( ! exists( $booking_ID ) ) return Alert::Error( -1 );

        $booking_model         = new BookingModel();
        $payment_request_model = new PaymentRequestModel();

        $select_booking = $booking_model
            ->where( "ID", $booking_ID )
            ->first();

        if ( ! exists( $select_booking ) ) return Alert::Error( -1 );

        require APPPATH . "/Libraries/ZibalFunctions.php";

        $zibal_parameters = array(
            "merchant"      => ZIBAL_MERCHANT_KEY,
            "callbackUrl"   => ZIBAL_CALLBACK_URL,
            "amount"        => $select_booking->price * 10, // to rial
            "orderId"       => time(),
        );

        $zibal_response = postToZibal( 'request', $zibal_parameters );

        if ( intval( $zibal_response->result ) !== 100) return Alert::Error( 100, resultCodes( $zibal_response->result ) );

        $data_insert = array(
            "user_ID"      => $user_info->ID,
            "amount"       => $zibal_parameters[ "amount" ] / 10,// toman
            "order_ID"     => $zibal_parameters[ "orderId" ],
            "time"         => date( "Y-m-d H:i:s" ),
            "booking_ID"   => $select_booking->ID,
            "booking_turn" => $select_booking->number_reserved++,
        );
        
        try {
            $payment_request_model->insert( $data_insert );
        } catch( \Exception $e ) {
            return Alert::Error( 100, $e );
        }
        
        return Alert::Success( 204, array(), ZIBAL_GATEWAY_URL( $zibal_response->trackId ) );
    }

    public function callbackPayment() {
        if ( ! $this->validate( [ "success" => "required|min_length[1]" ] ) ) return redirect()->to( base_url( "dashboard?error=115" ) );
        
        $success = $this->request->getGet('success');
        if ( $success != 1 ) return redirect()->to( base_url( "dashboard/reserve?error=115" ) );

        require APPPATH . "/Libraries/ZibalFunctions.php";

        $trackId = $this->request->getGet('trackId');
        $orderId = $this->request->getGet('orderId');

        $zibal_parameters = array(
            "merchant" => ZIBAL_MERCHANT_KEY,
            "trackId" => $trackId
        );

        $payment_request_model = new PaymentRequestModel();
        $payment_track_model   = new PaymentTrackModel();
        $booking_model         = new BookingModel();
        $reservation_model     = new ReservationModel();
        $user_model            = new UserModel();

        $select_request = $payment_request_model
            ->where( "order_ID", $orderId )
            ->first();
        if ( ! exists( $select_request ) ) return redirect()->to( base_url( "dashboard/reserve?error=115" ) );

        $select_booking = $booking_model
            ->where( "ID", $select_request->booking_ID )
            ->first();

        if ( ! exists( $select_booking ) ) return redirect()->to( base_url( "dashboard/reserve?error=115" ) );

        $data_insert_payment = array(
            "user_ID"               => $select_request->user_ID,
            "payment_request_ID"    => $select_request->ID,
            "amount"                => $select_request->amount, //toman
            "order_ID"              => $orderId,
            "track_ID"              => $trackId,
            "time"                  => date( "Y-m-d H:i:s" ),
            "booking_ID"            => $select_request->booking_ID,
            "booking_turn"          => $select_request->booking_turn,
        );

        $data_update_booking = array(
            "number_reserved" => intval( $select_booking->number_reserved ) + 1,
        );

        $data_insert_reservation = array(
            "user_ID"    => $select_request->user_ID,
            "booking_ID" => $select_request->booking_ID,
            "number"     => intval( $select_booking->number_reserved ) + 1,
        );

        try {
            $payment_track_model->insert( $data_insert_payment );

            $reservation_model->insert( $data_insert_reservation );

            $booking_model->update( $select_request->booking_ID, $data_update_booking );
        } catch( \Exception $e ) {
            return redirect()->to( base_url( "dashboard/reserve?error=115" ) );
        }

        $zibal_response = postToZibal( 'verify', $zibal_parameters );
        if ( $zibal_response->result != 100 ) return redirect()->to( base_url( "dashboard/reserve?error=115" ) );

        $select_user = $user_model
            ->where( "ID", $select_request->user_ID )
            ->CustomFirst();
        if ( exists( $select_user ) ) {
            $user_fullname = gender_text( $select_user ) . $select_user->firstname . " " . $select_user->lastname;
            $turn_date = gregorianDatetimeToJalali( $select_booking->date )->date;
            $turn_time = $this->calcTurnTime( $select_booking->start, $select_booking->number_reserved, $select_booking->time );
            $turn_text = sprintf( TextLibrary::description( "turn_sms" ), $turn_date, $turn_time );
            $sms_result = sms_ir_ultra_fast_send_service( $select_user->username, "Text", $turn_text, "UserName", $user_fullname );
        }

        return redirect()->to( base_url( "/dashboard/reserve/turns" ) );
    }

    public function showTurns() {
        $user_info = get_user_info();

        $data_page = array(
            "title_head"        => TextLibrary::title( "reservation_turns" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "page_name"         => "reservation_turns",
            "user_info"         => $user_info,
        );

        return $this->renderPageDashboard( "reservation-turns", $data_page );
    }

    public function turnsData() {
        $user_info = get_user_info();

        $reservation_model = new ReservationModel();
        $booking_model     = new BookingModel();
        $user_model        = new UserModel();

        $select_turns = $reservation_model
            ->select( array(
                "$reservation_model->table.ID",
                "$reservation_model->table.created_at",
                "$reservation_model->table.number as number_reserved",
                "$booking_model->table.ID as booking_ID",
                "$booking_model->table.date",
                "$booking_model->table.start",
                "$booking_model->table.time",
                "$booking_model->table.price",
                "$booking_model->table.kind_text",
                "$booking_model->table.type",
                "$user_model->table.firstname",
                "$user_model->table.lastname",
            ) )
            ->join( "$booking_model->table", "$booking_model->table.ID = $reservation_model->table.booking_ID", "inner" )
            ->join( "$user_model->table", "$user_model->table.ID = $booking_model->table.user_ID", "inner" )
            ->where( "$reservation_model->table.user_ID", $user_info->ID )
            ->orderBy( "$reservation_model->table.created_at", "DESC" )
            ->findAll();

        $data_return = array();
        for ( $i = 0; $i < count( $select_turns ); $i++ ) :
            $turn = $select_turns[ $i ];

            array_push(
                $data_return,
                array(
                    "ID"                => $turn->ID,
                    "booking_ID"        => $turn->booking_ID,
                    "created_at"        => gregorianDatetimeToJalali( $turn->created_at )->date,
                    "doctor_fullname"   => $turn->firstname . " " . $turn->lastname,
                    "kind_text"         => $turn->kind_text,
                    "type"              => !!$turn->type ? "تلفنی" : "حضوری",
                    "date"              => gregorianDatetimeToJalali( $turn->date )->date,
                    "time"              => $this->calcTurnTime( $turn->start, $turn->number_reserved, $turn->time ),
                    "price"             => $turn->price,
                )
            );
        endfor;

        return Alert::Success( 200, $data_return );
    }
}