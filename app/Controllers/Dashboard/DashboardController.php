<?php

namespace App\Controllers\Dashboard;

use App\Controllers\ParentController;
use App\Controllers\TokenController;
use App\Libraries\Alert;
use App\Libraries\TextLibrary;
use App\Models\UserModel;

class DashboardController extends ParentController {
    public function index() {

        $user_info = get_user_info();

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

    public function updateProfile() {
        $user_info = TokenController::UserData( LOGIN_TOKEN_COOKIE_NAME );
        
        $firstname  = $this->request->getPost( "firstname" );
        $lastname   = $this->request->getPost( "lastname" );
        $email      = $this->request->getPost( "email" );
        $gender     = $this->request->getPost( "gender" );
        $image      = $this->request->getFiles();
        $password   = $this->request->getPost( "password" );
        $confirm_password  = $this->request->getPost( "confirm_password" );
        $verify_code_email = $this->request->getPost( "verify_code_email" );

        if ( strlen( $firstname ) < 2 ) return Alert::Error( 101 );
        if ( strlen( $lastname ) < 2 ) return Alert::Error( 102 );

        
        if ( $email === "true" || $email === "null" ) {
            $email = NULL;
        } else {
            if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
                return Alert::Error( 111 );
            }
        }

        if ( $gender === "true" || $gender === "null" ) {
            $gender = NULL;
        } else {
            $gender = !!$gender;
        }

        if ( $password === "true" || $password === "null" ) {
            $password         = $user_info->password;
            $confirm_password = NULL;
            $change_pass_at   = NULL;
        } else {
            if ( ! validate_password( $password ) ) return Alert::Error( 104 );
            if ( $password !== $confirm_password ) return Alert::Error( 105 );

            $password = password_hash( $password, PASSWORD_BCRYPT );

            $change_pass_at = date( "Y-m-d H:i:s" );
        }

        if ( ! exists( $verify_code_email ) || $verify_code_email === "true" || $verify_code_email === "null" ) {
            $verify_code_email = NULL;
        } else {
            if ( strlen( $verify_code_email ) !== 6 || ! is_numeric( $verify_code_email ) ) return Alert::Error( 107 );
        }

        $file = $image["image"];
        if ( exists( $file ) ) $image_address = save_request_files( $file, IMAGE_DIR_PROFILE );

        if ( ! exists( $image_address ) ) $image_address = $user_info->image;

        $user_model = new UserModel();
        $data_update = array(
            "firstname" => $firstname,
            "lastname"  => $lastname,
            "email"     => $email,
            "gender"    => $gender,
            "image"     => $image_address,
            "password"  => $password,
            "verify_code_email" => $verify_code_email,
            "change_pass_at"    => $change_pass_at,
        );

        if ( ! exists( $user_info ) ) return Alert::Error( -1 );
        try {
            $user_model->update( $user_info->ID, $data_update );
        } catch( \Exception $e ) {
            return Alert::Error( 100 );
        }

        $user_info->firstname   = $firstname;
        $user_info->lastname    = $lastname;
        $user_info->email       = $email;
        $user_info->gender      = $gender;
        $user_info->image       = $image_address;
        $user_info->password    = $password;
        $user_info->verify_code_email = $verify_code_email;

        $user_info = handle_user_info( $user_info );

        return Alert::Success( 200, $user_info );
    }
}