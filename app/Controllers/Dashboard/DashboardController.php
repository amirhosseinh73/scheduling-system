<?php

namespace App\Controllers\Dashboard;

use App\Controllers\ParentController;
use App\Controllers\TokenController;
use App\Libraries\Alert;
use App\Libraries\TextLibrary;

class DashboardController extends ParentController {
    public function index() {

        $user_info = TokenController::UserData( LOGIN_TOKEN_COOKIE_NAME );
        
        $data_page = array(
            "title_head"        => TextLibrary::title( "dashboard" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "page_name"         => "index",
            "user_info"         => $user_info,
        );

        return $this->renderPageDashboard( "index", $data_page );
    }

    /**
     * Summary.
     * logout user.
     * @method POST|GET
     * @return string success
     */
    public function logout() {
        TokenController::Unset( LOGIN_TOKEN_COOKIE_NAME );
        if ( $this->request->getMethod( TRUE ) !== "GET" )
            return Alert::Success( 200 );
        else
            return redirect()->to( base_url( "/login" ) );
    }
}