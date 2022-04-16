<?php

namespace App\Controllers\Dashboard;

use App\Controllers\ParentController;
use App\Controllers\TokenController;
use App\Libraries\TextLibrary;

class ReservationController extends ParentController {
    public function index() {
        $user_info = TokenController::UserData( LOGIN_TOKEN_COOKIE_NAME );

        $user_info = handle_user_info( $user_info );

        $data_page = array(
            "title_head"        => TextLibrary::title( "reservation" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "page_name"         => "reservation_index",
            "user_info"         => $user_info,
        );

        return $this->renderPageDashboard( "reservation-index", $data_page );
    }
}