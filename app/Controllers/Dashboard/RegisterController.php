<?php

namespace App\Controllers\Dashboard;

use App\Controllers\ParentController;
use App\Libraries\Alert;
use App\Libraries\TextLibrary;
use App\Models\UserModel;

use function PHPUnit\Framework\returnSelf;

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

        $firstname          = $this->request->getPost( "firstname" );
        $lastname           = $this->request->getPost( "lastname" );
        $mobile             = $this->request->getPost( "mobile" );
        $password           = $this->request->getPost( "password" );
        $confirm_password   = $this->request->getPost( "confirm_password" );

        if ( strlen( $firstname ) < 2 ) return Alert::Error( 101 );

        if ( strlen( $lastname ) < 2 ) return Alert::Error( 102 );

        if ( strlen( $mobile ) !== 11 || $mobile[ 0 ] != 0 || $mobile[ 1 ] != 9 ) return Alert::Error( 103, $mobile );

        if ( strlen( $password ) < 6 ) return Alert::Error( 104 );

        if ( $password !== $confirm_password ) return Alert::Error( 105 );

        $user_model = new UserModel();
        $select_user = $user_model
            ->where( "username", $mobile )
            ->first();

        $data = array(
            "username"  => $mobile,
            "firstname" => $firstname,
            "lastname"  => $lastname,
            "mobile"    => $mobile,
            "password"  => $password,
        );
        if ( exists( $select_user ) ) {
            $data[ "ID" ] = $select_user->ID;

            if ( exists( $select_user->mobile_verified_at ) ) return Alert::Info( 301, $data, base_url( "/login" ) );
            else return Alert::Info( 302, $data, base_url( "/register/verify" ) );
        }

        try {

            $return_ID = $user_model->insert( $data );

            if ( ! exists( $return_ID ) ) return Alert::Error( 100 );

        } catch( \Exception $e ) {
            return Alert::Error( -1 );
        }

        $data[ "ID" ] = $return_ID;

        return Alert::Success( 200, $data, base_url( "/register/verify" ) );

    }

    public function verifyMobile() {

    }

}