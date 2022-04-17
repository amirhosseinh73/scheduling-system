<?php

namespace App\Controllers\Dashboard;

use App\Controllers\ParentController;
use App\Controllers\TokenController;
use App\Libraries\Alert;
use App\Libraries\TextLibrary;
use App\Models\UserModel;

class RegisterController extends ParentController {

    private function selectUserByUsername( $username ) {
        $user_model = new UserModel();
        $select_user = $user_model
            ->where( "username", $username )
            ->first();

        return $select_user;
    }

    public function index() {
        $data_page = array(
            "title_head"        => TextLibrary::title( "register" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "page_name"         => "register",
        );

        return $this->renderPageDashboard( "register", $data_page, "header", "footer" );
    }

    public function submit() {

        $firstname  = $this->request->getPost( "firstname" );
        $lastname   = $this->request->getPost( "lastname" );
        $mobile     = $this->request->getPost( "mobile" );
        $type_user  = $this->request->getPost( "type_user" );

        if ( strlen( $firstname ) < 2 ) return Alert::Error( 101 );

        if ( strlen( $lastname ) < 2 ) return Alert::Error( 102 );

        if ( strlen( $mobile ) !== 11 || $mobile[ 0 ] != 0 || $mobile[ 1 ] != 9 ) return Alert::Error( 103 );

        if ( $type_user == 0 ) return Alert::Error( 106 );

        $select_user = $this->selectUserByUsername( $mobile );
        $user_model = new UserModel();

        $data_insert = array(
            "username"  => $mobile,
            "firstname" => $firstname,
            "lastname"  => $lastname,
            "mobile"    => $mobile,
            "type_user" => $type_user == 2 ? TRUE : FALSE,
            "verify_code_mobile" => custom_random_string( 6, TRUE ),
        );

        $session = session();
        if ( exists( $select_user ) ) {
            $data_insert[ "ID" ] = $select_user->ID;

            if ( exists( $select_user->mobile_verified_at ) ) return Alert::Info( 301, $data_insert, base_url( "/login" ) );

            $sms_result = sms_ir_ultra_fast_send_service( $mobile, "VerificationCode", $data_insert[ "verify_code_mobile" ] );
            $data_insert[ "sms_result" ] = $sms_result;
            $data_update = array(
                "verify_code_mobile" => $data_insert[ "verify_code_mobile" ],
            );
            $user_model->update( $select_user->ID, $data_update );
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

        $sms_result = sms_ir_ultra_fast_send_service( $mobile, "VerificationCode", $data_insert[ "verify_code_mobile" ] );
        $data_insert[ "sms_result" ] = $sms_result;

        $session->set( KEY_CHECK_RESPONSE, "KEY_CHECK_RESPONSE" );
        $session->set( KEY_VALUE_SESSION, $mobile );
        return Alert::Success( 200, $data_insert, base_url( "/register/verify" ) );

    }

    public function verify() {
        $data_page = array(
            "title_head"        => TextLibrary::title( "verify" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "page_name"         => "register",
        );

        return $this->renderPageDashboard( "verify", $data_page, "header", "footer" );
    }

    public function verifySubmit() {
        $verify_code = intval( $this->request->getPost( "verify_code" ) );
        $password = $this->request->getPost( "password" );
        $confirm_password = $this->request->getPost( "confirm_password" );

        if ( strlen( $verify_code ) !== 6 || ! is_numeric( $verify_code ) ) return Alert::Error( 107 );

        if ( ! exists( $password ) || ! validate_password( $password ) ) return Alert::Error( 104 );

        if ( $password !== $confirm_password ) return Alert::Error( 105 );

        $session = session();
        $mobile = $session->get( KEY_VALUE_SESSION );
        if ( ! exists( $mobile ) ) return Alert::Error( -1 );

        $select_user = $this->selectUserByUsername( $mobile );

        if ( $verify_code !== intval( $select_user->verify_code_mobile ) ) return Alert::Error( 107 );

        $data_update = array(
            "mobile_verified_at" => date( "Y-m-d H:i:s" ),
            "status"             => TRUE,
            "password"           => password_hash( $password, PASSWORD_BCRYPT ),

        );

        $user_model = new UserModel;

        try {
            $user_model->update( $select_user->ID, $data_update );
        } catch( \Exception $e ) {
            return Alert::Error( -1, $e );
        }

        $user_info = TokenController::Insert( LOGIN_TOKEN_COOKIE_NAME, $mobile, DAY );

        if ( ! $user_info ) return Alert::Error( 100 );

        $user_info = handle_user_info( $user_info );

        $session->remove( KEY_VALUE_SESSION );
        $session->remove( KEY_CHECK_RESPONSE );
        return Alert::Success( 201, $user_info, base_url( "/dashboard" ) );
    }

}