<?php

namespace App\Controllers;

use App\Libraries\Alert;

class ParentAdminController extends BaseController {
    protected $helpers = array(
        "public",
        "admin"
    );

    /**
     * Summary.
     * Check login by token
     * @var $incomming_token as token
     * @return string|object die and return json | $user_info
     */
    protected function CheckLogin() {

        $user_info = TokenController::UserData( LOGIN_TOKEN_COOKIE_NAME ); // use for web

        if ( ! $user_info || ! exists( $user_info->ID ) ) return Alert::Error( 101 );

        if ( ! exists( $user_info->image ) ) $user_info->image = "profile.png";

        return $user_info;
    }

    /**
     * Summary.
     * if set TRUE, return data in methods
     * if FLSE return Alert and die with data
     * @var bool $CallFunction
     */
    protected $CallFunction = FALSE;

}