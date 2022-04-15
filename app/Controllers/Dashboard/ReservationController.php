<?php

namespace App\Controllers\Dashboard;

use App\Controllers\ParentController;
use App\Controllers\TokenController;
use App\Libraries\TextLibrary;
use App\Models\BookingModel;
use App\Models\UserModel;

class ReservationController extends ParentController {
    public function index() {
        $user_info = TokenController::UserData( LOGIN_TOKEN_COOKIE_NAME );

        $user_info = handle_user_info( $user_info );

        $data_page = array(
            "title_head"        => TextLibrary::title( "reservation" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "page_name"         => "reservation_index",
            "user_info"         => $user_info,
            "booking_data"      => $this->getBookingData(),
        );

        return $this->renderPageDashboard( "reservation-index", $data_page );
    }

    private function getBookingData() {
        $booking_model = new BookingModel();

        $select_booking = $booking_model
            ->where( "date >=", date( "Y-m-d" ) )
            ->findAll();

        $user_IDs = array_column( $select_booking, "user_ID" );

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

        $data_return = array();
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

        return $select_booking;
    }
}