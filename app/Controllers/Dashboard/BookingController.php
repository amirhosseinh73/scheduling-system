<?php

namespace App\Controllers\Dashboard;

use App\Controllers\ParentController;
use App\Controllers\TokenController;
use App\Libraries\Alert;
use App\Libraries\TextLibrary;
use App\Models\BookingTimeModel;
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
        $booking_model = new BookingTimeModel();

        $select_booking = $booking_model
            ->where( "user_ID", $user_info->ID )
            ->findAll();

        return $select_booking;
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