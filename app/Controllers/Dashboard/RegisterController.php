<?php

namespace App\Controllers\Dashboard;

use App\Controllers\ParentController;
use App\Libraries\Alert;
use App\Libraries\TextLibrary;
use App\Models\UserModel;

class RegisterController extends ParentController {

    public function index() {
        $data_page = array(
            "title_head"        => TextLibrary::title( "register" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "page_name"         => "register",
        );

        return $this->renderPageSite( "register", $data_page );
    }

    public function submit() {

        $firstname  = $this->request->getPost( "firstname" );
        $lastname   = $this->request->getPost( "lastname" );
        $mobile     = $this->request->getPost( "mobile" );
        $type_user  = $this->request->getPost( "type_user" );
        // $password           = $this->request->getPost( "password" );
        // $confirm_password   = $this->request->getPost( "confirm_password" );

        if ( strlen( $firstname ) < 2 ) return Alert::Error( 101 );

        if ( strlen( $lastname ) < 2 ) return Alert::Error( 102 );

        if ( strlen( $mobile ) !== 11 || $mobile[ 0 ] != 0 || $mobile[ 1 ] != 9 ) return Alert::Error( 103, $mobile );

        if ( $type_user == 0 ) return Alert::Error( 106, $mobile );

        // if ( strlen( $password ) < 6 ) return Alert::Error( 104 );

        // if ( $password !== $confirm_password ) return Alert::Error( 105 );

        $user_model = new UserModel();
        $select_user = $user_model
            ->where( "username", $mobile )
            ->first();

        $data_insert = array(
            "username"  => $mobile,
            "firstname" => $firstname,
            "lastname"  => $lastname,
            "mobile"    => $mobile,
            "type_user" => $type_user == 2 ? TRUE : FALSE,
            "verify_code_mobile" => custom_random_string( 6, TRUE ),
        );

        $sms_result = sms_ir_ultra_fast_send_service( $mobile, "VerificationCode", $data_insert[ "verify_code_mobile" ] );
        $data_insert[ "sms_result" ] = $sms_result;

        $session = session();
        if ( exists( $select_user ) ) {
            $data_insert[ "ID" ] = $select_user->ID;

            $data_update = array(
                "verify_code_mobile" => $data_insert[ "verify_code_mobile" ],
            );
            $user_model->update( $select_user->ID, $data_update );

            if ( exists( $select_user->mobile_verified_at ) ) return Alert::Info( 301, $data_insert, base_url( "/login" ) );
            else $session->set( KEY_CHECK_RESPONSE, "KEY_CHECK_RESPONSE" );

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
        return Alert::Success( 200, $data_insert, base_url( "/register/verify" ) );

    }

    public function verifyMobile() {
        $data_page = array(
            "title_head"        => TextLibrary::title( "verify" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "page_name"         => "register",
        );

        return $this->renderPageSite( "verify", $data_page );
    }

}