<?php

namespace App\Controllers\Dashboard;

use App\Controllers\ParentController;
use App\Libraries\Alert;
use App\Libraries\TextLibrary;
use App\Models\UserModel;

class LoginController extends ParentController {

    public function index() {
        $data_page = array(
            "title_head"        => TextLibrary::title( "login" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "page_name"         => "login",
        );

        return $this->renderPageSite( "login", $data_page );
    }

    public function submit() {

        $username       = $this->request->getPost( "username" );
        $password       = $this->request->getPost( "password" );
        $remember_me    = $this->request->getPost( "remember_me" );

        $is_admin_request = $this->request->getPost( "admin" );

        if ( strlen( $username ) !== 11 || $username[ 0 ] != 0 || $username[ 1 ] != 9 ) return Alert::Error( 103 );

        if ( ! exists( $password ) || ! validate_password( $password ) ) return Alert::Error( 104 );

        $login_time  = ( ( exists( $remember_me ) && $remember_me === "true" ) ? MONTH : DAY );

        $user_model = new UserModel();

        //check exist user
        $select_exist_user = $user_model->where( "username", $username );
        if ( exists( $is_admin_request ) && $is_admin_request === "true" )
            $select_exist_user = $select_exist_user->where( "is_admin", TRUE );

        $select_exist_user = $select_exist_user->first();

        if ( ! exists( $select_exist_user ) ) return Alert::Error( 115 );

        if ( ! $select_exist_user->status ) return Alert::Error( 114 );

        if ( ! password_verify( $password, $select_exist_user->password ) ) return Alert::Error( 116 );

        $user_data = TokenController::Insert( LOGIN_TOKEN_COOKIE_NAME, $email, $login_time );

        if ( ! $user_data ) return Alert::Error( 100 );

        $user_data["image"]    = base_url( IMAGE_DIR_PROFILE . $user_data["image"] );
        $user_data["status"]   = !!$user_data["status"];
        $user_data["is_admin"] = !!$user_data["is_admin"];
        $user_data["gender"]   = !!$user_data["gender"] ? "male" : "female";

        //return token and base64 of user_data
        $user_data["token"]    = $user_data["token"] . "." . base64_encode( json_encode_unicode($user_data) );

        return Alert::Success( 200, $user_data, base_url( "admin/dashboard" ) );

        $session = session();
        if ( exists( $select_user ) ) {
            $data_insert[ "ID" ] = $select_user->ID;

            $data_update = array(
                "verify_code_mobile" => $data_insert[ "verify_code_mobile" ],
            );
            $user_model->update( $select_user->ID, $data_update );

            if ( exists( $select_user->mobile_verified_at ) ) return Alert::Info( 301, $data_insert, base_url( "/login" ) );

            $session->set( KEY_CHECK_RESPONSE, "KEY_CHECK_RESPONSE" );
            $session->set( KEY_VALUE_SESSION, $mobile );
            return Alert::Info( 302, $data_insert, base_url( "/register/verify" ) );
        }

        try {

            $return_ID = $user_model->insert( $data_insert );

            if ( ! exists( $return_ID ) ) return Alert::Error( 100 );
            
        } catch( \Exception $e ) {
            return Alert::Error( -1 );
        }

        $data_insert[ "ID" ] = $return_ID;

        $session->set( KEY_CHECK_RESPONSE, "KEY_CHECK_RESPONSE" );
        $session->set( KEY_VALUE_SESSION, $mobile );
        return Alert::Success( 200, $data_insert, base_url( "/register/verify" ) );

    }

}