<?php

namespace App\Controllers\Dashboard;

use App\Controllers\ParentController;
use App\Controllers\TokenController;
use App\Libraries\Alert;
use App\Libraries\TextLibrary;
use App\Models\BookingModel;
use App\Models\ReservationModel;

class BookingController extends ParentController {
    public function index() {
        $user_info = TokenController::UserData( LOGIN_TOKEN_COOKIE_NAME );

        $user_info = handle_user_info( $user_info );

        $data_page = array(
            "title_head"        => TextLibrary::title( "booking" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "page_name"         => "booking_index",
            "user_info"         => $user_info,
            "booking_data"      => $this->getBookingData( $user_info ),
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
        $user_info      = TokenController::UserData( LOGIN_TOKEN_COOKIE_NAME );

        if ( ! exists( $user_info ) ) return Alert::Error( -1 );

        $type           = !!$this->request->getPost( "type" );
        $date           = $this->request->getPost( "date" );
        $start          = $this->request->getPost( "start" );
        $end            = $this->request->getPost( "end" );
        $time_each      = $this->request->getPost( "time_each" );
        $total_number   = $this->request->getPost( "total_number" );
        
        // if ( ! exists( $type ) )         return Alert::Error( 112 );
        if ( ! exists( $date ) )         return Alert::Error( 113 );
        if ( ! exists( $start ) )        return Alert::Error( 114 );
        if ( ! exists( $end ) )          return Alert::Error( 114 );
        if ( ! exists( $time_each ) )    return Alert::Error( 115 );
        if ( ! exists( $total_number ) ) return Alert::Error( 115 );

        $data = array(
            "user_ID"   => $user_info->ID,
            "type"      => $type,
            "date"      => $date,
            "start"     => $start,
            "end"       => $end,
            "time"      => $time_each,
            "number_reserve" => $total_number,
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
}