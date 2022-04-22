<?php

namespace App\Controllers\Dashboard;

use App\Controllers\ParentController;
use App\Libraries\Alert;
use App\Libraries\TextLibrary;
use App\Models\BookingModel;
use App\Models\ReservationModel;
use App\Models\UserModel;

class BookingController extends ParentController {
    public function index() {
        $user_info = get_user_info();

        $data_page = array(
            "title_head"        => TextLibrary::title( "booking" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "page_name"         => "booking_index",
            "user_info"         => $user_info,
        );

        return $this->renderPageDashboard( "booking-index", $data_page );
    }

    private function getBookingData( $user_info ) {
        $booking_model = new BookingModel();

        $select_booking = $booking_model
            ->where( "user_ID", $user_info->ID )
            ->findAll();

        return $select_booking;
    }

    public function submit() {
        $user_info = get_user_info();

        if ( ! exists( $user_info ) ) return Alert::Error( -1 );

        $type           = !!$this->request->getPost( "type" );
        $date           = $this->request->getPost( "date" );
        $start          = $this->request->getPost( "start" );
        $end            = $this->request->getPost( "end" );
        $time_each      = $this->request->getPost( "time_each" );
        $total_number   = $this->request->getPost( "total_number" );
        $kind_advise    = $this->request->getPost( "kind_advise" );
        $price          = $this->request->getPost( "price" );
        
        // if ( ! exists( $type ) )         return Alert::Error( 112 );
        if ( ! exists( $date ) )         return Alert::Error( 113 );
        if ( ! exists( $start ) )        return Alert::Error( 114 );
        if ( ! exists( $end ) )          return Alert::Error( 114 );
        if ( ! exists( $time_each ) )    return Alert::Error( 115 );
        if ( ! exists( $total_number ) ) return Alert::Error( 115 );
        if ( ! exists( $kind_advise ) )  return Alert::Error( 116 );
        if ( ! exists( $price ) )        return Alert::Error( 117 );

        $data = array(
            "user_ID"   => $user_info->ID,
            "type"      => $type,
            "date"      => $date,
            "start"     => $start,
            "end"       => $end,
            "time"      => $time_each,
            "number_reserve" => $total_number,
            "kind_text" => $kind_advise,
            "price"     => $price,
        );

        $booking_model = new BookingModel();

        try {
             $return_ID = $booking_model->insert( $data );

             if ( ! $return_ID ) return Alert::Error( 100 );
        } catch( \Exception $e ) {
            return Alert::Error( 100, $e );
        }

        $data[ "ID" ] = $return_ID;

        return Alert::Success( 202, $data );
    }

    public function getReservationData( $booking_ID = NULL ) {

        if ( ! $this->callFunction ) $booking_ID = $this->request->getGet( "booking_ID" );
        
        $data_return = array();
        if ( ! exists( $booking_ID ) ) {
            if ( $this->callFunction ) return $data_return;
            else return Alert::Error( -1 );
        }

        $reservation_model = new ReservationModel();
        $select_booking = $reservation_model
            ->where( "booking_ID", $booking_ID )
            ->findAll();

        $data_return = $select_booking;

        return $data_return;

    }

    public function getBookingPatientData() {
        $booking_model = new BookingModel();

        $data_return = array();
        $select_booking = $booking_model
            ->where( "date >=", date( "Y-m-d" ) )
            ->orderBy( "date", "DESC" )
            ->findAll();

        $user_IDs = array_column( $select_booking, "user_ID" );

        if ( ! exists( $select_booking ) ) return Alert::Success( 200, $data_return );
        
        $user_model = new UserModel();
        $select_user_data = $user_model
            ->select( array(
                "ID",
                "username",
                "firstname",
                "lastname",
                "email",
                "gender",
                "image",
                "status",
                "type_user",
                "is_admin",
            ) )
            ->whereIn( "ID", $user_IDs )
            ->customFindAll();
        
        foreach( $select_user_data as $idx => $doctor ) :
            $select_user_data[ $idx ] = handle_user_info( $doctor );
        endforeach;

        for ( $i = 0; $i < count( $select_booking ); $i++ ) :
            $booking = $select_booking[ $i ];
            $booking->doctor_info = array_values( array_filter( $select_user_data, function( $key ) use( $booking ) {
                return $key->ID === $booking->user_ID;
            } ) )[ 0 ];

            array_push(
                $data_return,
                $booking
            );
        endfor;

        return Alert::Success( 200, $data_return );
    }

    public function showTurns() {
        $user_info = get_user_info();

        $data_page = array(
            "title_head"        => TextLibrary::title( "booking_turns" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "page_name"         => "booking_turns",
            "user_info"         => $user_info,
        );

        return $this->renderPageDashboard( "booking-turns", $data_page );
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
                "$user_model->table.username",
            ) )
            ->join( "$booking_model->table", "$booking_model->table.ID = $reservation_model->table.booking_ID", "inner" )
            ->join( "$user_model->table", "$user_model->table.ID = $reservation_model->table.user_ID", "inner" )
            ->where( "$booking_model->table.user_ID", $user_info->ID )
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
                    "patient_fullname"  => $turn->firstname . " " . $turn->lastname,
                    "patient_mobile"    => $turn->username,
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