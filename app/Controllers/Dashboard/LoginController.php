<?php

namespace App\Controllers\Dashboard;

use App\Controllers\ParentController;
use App\Controllers\TokenController;
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

        return $this->renderPageDashboard( "login", $data_page, "header", "footer" );
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
        $select_user = $user_model->where( "username", $username );
        if ( exists( $is_admin_request ) && $is_admin_request === "true" )
            $select_user = $select_user->where( "is_admin", TRUE );

        $select_user = $select_user->first();

        if ( ! exists( $select_user ) ) return Alert::Error( 108 );

        if ( ! $select_user->status ) return Alert::Error( 109 );

        if ( ! password_verify( $password, $select_user->password ) ) return Alert::Error( 110 );

        if ( ! exists( $select_user->mobile_verified_at ) ) {

            $data_update = array(
                "verify_code_mobile" => custom_random_string( 6, TRUE ),
            );
            $sms_result = sms_ir_ultra_fast_send_service( $username, "VerificationCode", $data_update[ "verify_code_mobile" ] );
            $data_insert[ "sms_result" ] = $sms_result;
            
            $user_model->update( $select_user->ID, $data_update );

            $session = session();
            $session->set( KEY_CHECK_RESPONSE, "KEY_CHECK_RESPONSE" );
            $session->set( KEY_VALUE_SESSION, $username );
            return Alert::Info( 302, $data_insert, base_url( "/register/verify" ) );
        }

        $user_info = TokenController::Insert( LOGIN_TOKEN_COOKIE_NAME, $username, $login_time );

        if ( ! $user_info ) return Alert::Error( 100 );

        $user_info = handle_user_info( $user_info );

        if ( $user_info->is_admin ) Alert::Success( 200, $user_info, base_url( "/dashboard" ) );

        return Alert::Success( 200, $user_info, base_url( "/dashboard" ) );
    }

    public function recoveryPage() {
        $data_page = array(
            "title_head"        => TextLibrary::title( "recovery_pass" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "page_name"         => "login",
        );

        return $this->renderPageDashboard( "recovery", $data_page, "header", "footer" );
    }

    public function submitRecovery() {

        $mobile = $this->request->getPost( "mobile" );

        if ( strlen( $mobile ) !== 11 || $mobile[ 0 ] != 0 || $mobile[ 1 ] != 9 ) return Alert::Error( 103 );

        $user_model = new UserModel();

        //check exist user
        $select_user = $user_model->where( "username", $mobile );

        $select_user = $select_user->first();

        if ( ! exists( $select_user ) ) return Alert::Error( 108 );

        if ( ! $select_user->status ) return Alert::Error( 109 );

        if ( ! exists( $select_user->mobile_verified_at ) ) {

            $data_update = array(
                "verify_code_mobile" => custom_random_string( 6, TRUE ),
            );
            $sms_result = sms_ir_ultra_fast_send_service( $mobile, "VerificationCode", $data_update[ "verify_code_mobile" ] );
            $data_update[ "sms_result" ] = $sms_result;
            
            $user_model->update( $select_user->ID, $data_update );

            $session = session();
            $session->set( KEY_CHECK_RESPONSE, "KEY_CHECK_RESPONSE" );
            $session->set( KEY_VALUE_SESSION, $mobile );
            return Alert::Info( 302, $data_update, base_url( "/register/verify" ) );
        }

        $new_password = custom_random_string( 8, FALSE );

        $data_update = array(
            "password" => password_hash( $new_password, PASSWORD_BCRYPT ),
            "recovery_pass_at" => date( "Y-m-d H:i:s" ),
        );

        $user_fullname = gender_text( $select_user ) . $select_user->firstname . " " . $select_user->lastname;
        $sms_result = sms_ir_ultra_fast_send_service( $mobile, "Password", $new_password, "UserName", $user_fullname );
        $data_update[ "sms_result" ] = $sms_result;
        
        $user_model->update( $select_user->ID, $data_update );

        return Alert::Success( 200, $data_update, base_url( "/login" ) );
    }

}