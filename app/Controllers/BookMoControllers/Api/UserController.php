<?php

namespace App\Controllers\Api;

use App\Controllers\ParentController;
use App\Controllers\TokenController;
use App\Libraries\Alert;
use App\Models\UserModel;

class UserController extends ParentController {

    /**
     * Summary.
     * Register User
     * @method POST
     * @return string success|failed
     * @var string $firstname firstname
     * @var string $lastname lastname
     * @var string $email
     * @var string $password
     */
    public function Register() {
        $firstname = $this->request->getPost( "firstname" );
        $lastname  = $this->request->getPost( "lastname" );
        $email     = $this->request->getPost( "email" );
        $password  = $this->request->getPost( "password" );
        // $gender    = $this->request->getPost( "gender" );
        // $age       = $this->request->getPost( "age" );
        // $image     = $this->request->getFiles();

        if ( ! exists( $firstname ) ) return Alert::Error( 110 );
        if ( ! exists( $lastname ) ) return Alert::Error( 126 );

        if ( ! exists( $email ) || ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) return Alert::Error( 111 );

        if ( ! exists( $password ) || ! validate_password( $password ) ) return Alert::Error( 112 );

        $user_model = new UserModel();

        //check exist user
        $select_exist_user = $user_model
            ->where( "email", $email )
            ->first();

        //check email exists in DB
        if ( exists( $select_exist_user ) ) :
            if ( ! $select_exist_user->status ) {
                return Alert::Error( 114 );
            } else {
                return Alert::Error( 113 );
            }
        endif;

        $this->email    = $email;
        $this->subject  = "WELCOME!";
        $this->name     = $firstname . " " . $lastname;
        $this->password = $password;
        $check_mail     = $this->send_email();

        if ( ! $check_mail ) return Alert::Error( 117 );

        // $file = $image["image"];
        // if ( exists( $file ) ) $image_address = save_request_files( $file, IMAGE_DIR_PROFILE );
        // if ( ! exists( $image_address ) ) $image_address = "profile.png";
        $image_address = "profile.png";

        $data_insert = array(
            "firstname" => $firstname,
            "lastname"  => $lastname,
            "email"     => $email,
            "password"  => password_hash( $password, PASSWORD_BCRYPT ),
            "image"     => $image_address,
            "status"    => TRUE,
            "gender"    => "",
            "age"       => "",
        );
        try{
            $user_id = $user_model->insert( $data_insert, TRUE );

            if ( ! exists( $user_id ) ) return Alert::Error( 100 );

            $data_insert[ "ID" ] = $user_id;

        } catch (\Exception $e) {
            logFile( (array)$e, "log/query_insert_" . time() . ".json" );
            return Alert::Error( 100 );
        }

        $data_insert["image"] = base_url( IMAGE_DIR_PROFILE . $data_insert["image"] );

        $user_data = TokenController::Insert( LOGIN_TOKEN_COOKIE_NAME, $email, DAY );

        if ( ! $user_data ) return Alert::Error( 100 );

        $user_data["image"]    = base_url( IMAGE_DIR_PROFILE . $user_data["image"] );
        $user_data["status"]   = !!$user_data["status"];
        $user_data["is_admin"] = !!$user_data["is_admin"];
        $user_data["gender"]   = !!$user_data["gender"] ? "male" : "female";

        //return token and base64 of user_data
        $user_data["token"]    = $user_data["token"] . "." . base64_encode( json_encode_unicode($user_data) );

        return Alert::Success( 200, $user_data, base_url( "admin/dashboard" ) );

        return Alert::Success( 200, $user_data );
    }

    /**
     * # Summary.
     * Login User and create Token Cookie and save into DB
     * # Description.
     * Also use for admin login
     * @method POST
     * @return string success|failed
     * @var string $email as username
     * @var string $password
     */
    public function Login() {
        $email            = $this->request->getPost( "email" );
        $password         = $this->request->getPost( "password" );
        $remember_me      = $this->request->getPost( "remember_me" );
        $is_admin_request = $this->request->getPost( "admin" );

        $login_time  = ( ( exists( $remember_me ) && $remember_me === "true" ) ? MONTH : DAY );

        if ( ! exists( $email ) || ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) return Alert::Error( 111 );

        if ( ! exists( $password ) || ! validate_password( $password ) ) return Alert::Error( 112 );

        $user_model = new UserModel();

        //check exist user
        $select_exist_user = $user_model->where( "email", $email );
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
    }

    /**
     * Summary.
     * Recovery password Send random password to email
     * @method POST
     * @return string success|failed
     * @var string $email as username
     */
    public function RecoverPasswrod() {
        $email = $this->request->getPost( "email" );

        if ( ! exists( $email ) || ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) return Alert::Error( 111 );

        $user_model = new UserModel();

        //check exist user
        $select_exist_user = $user_model
            ->where( "email", $email )
            ->first();

        if ( ! exists( $select_exist_user ) || ! exists( $select_exist_user->ID ) ) return Alert::Error( 115 );

        if ( ! $select_exist_user->status ) return Alert::Error( 114 );

        // send email first then set password

        $this->email       = $email;
        $this->subject     = "Recover password!";
        $this->name        = $select_exist_user->firstname . " " . $select_exist_user->lastname;
        $this->password    = custom_random_string( 8 );
        $this->is_recovery = TRUE;
        $check_mail = $this->send_email();

        if ( ! $check_mail ) return Alert::Error( 117 );

        try{
            $data_update = array(
                "password"        => password_hash( $this->password, PASSWORD_BCRYPT ),
                "recover_pass_at" => date( "Y-m-d H:i:s" ),
            );
            $check_update = $user_model->update( $select_exist_user->ID, $data_update );

            if ( ! $check_update ) return Alert::Error( 100 );

        } catch (\Exception $e) {
            logFile( (array)$e, "log/query_update_" . time() . ".json" );
            return Alert::Error( 100 );
        }

        return Alert::Success( 201 );
    }

    /**
     * Summary.
     * Change password get token, old password and new password
     * @method POST
     * @return string success|failed
     * @var string $incomming_token as token
     * @var string $old_password
     * @var string $new_password
     * @var string $confirm_password
     */
    public function ChangePassword() {

        $old_password     = $this->request->getPost( "old_password" );
        $new_password     = $this->request->getPost( "new_password" );
        $confirm_password = $this->request->getPost( "confirm_password" );
        
        $user_info = $this->CheckLogin();

        if ( ! exists( $old_password ) || ! password_verify( $old_password, $user_info->password ) ) return Alert::Error( 118 );

        if ( ! exists( $new_password ) || ! validate_password( $new_password ) ) return Alert::Error( 112 );

        if ( $new_password !== $confirm_password ) return Alert::Error( 119 );

        $user_model = new UserModel();

        try{
            $data_update = array(
                "password"        => password_hash( $new_password, PASSWORD_BCRYPT ),
            );
            $check_update = $user_model->update( $user_info->ID, $data_update );

            if ( ! $check_update ) return Alert::Error( 100 );

            // set passwrod then send email
            $this->email       = $user_info->email;
            $this->subject     = "Change password!";
            $this->name        = $user_info->firstname . " " . $user_info->lastname;
            $this->password    = $new_password;
            $this->is_recovery = TRUE;
            $check_mail = $this->send_email();
            if ( ! $check_mail ) return Alert::Error( 117 );

        } catch (\Exception $e) {
            logFile( (array)$e, "log/query_update_" . time() . ".json" );
            return Alert::Error( 100 );
        }

        return Alert::Success( 202 );
    }

    /**
     * Summary.
     * Update profile.
     * @method POST
     * @return string success|failed
     * @var string $incomming_token as token
     * @var string $firstname firstname
     * @var string $lastname lastname
     * @var bool $gender gender
     * @var int $age age
     * @var file $image
     */
    public function UpdateProfile() {
        $user_info = $this->CheckLogin();

        $firstname = $this->request->getPost( "firstname" );
        $lastname  = $this->request->getPost( "lastname" );
        $image     = $this->request->getFiles();
        $gender    = $this->request->getPost( "gender" );
        $age       = $this->request->getPost( "age" );

        $file = $image["image"];
        if ( exists( $file ) ) $image_address = save_request_files( $file, IMAGE_DIR_PROFILE );

        if ( ! exists( $firstname ) )     $firstname     = $user_info->firstname;
        if ( ! exists( $lastname ) )      $lastname      = $user_info->lastname;
        if ( ! exists( $image_address ) ) $image_address = $user_info->image;
        if ( ! exists( $age ) )           $age           = $user_info->age;

        if ( ! exists( $gender ) )        $gender        = is_null( $user_info->gender ) ? NULL : !!$user_info->gender;
        else if ( $gender === "male" )    $gender        = TRUE;
        else if ( $gender === "female" )  $gender        = FALSE;
        else                              $gender        = NULL;

        $user_model = new UserModel();
        try{
            $data_update = array(
                "firstname" => $firstname,
                "lastname"  => $lastname,
                "image"     => $image_address,
                "gender"    => $gender,
                "age"       => $age,
            );
            $check_update = $user_model->update( $user_info->ID, $data_update );

            if ( ! $check_update ) return Alert::Error( 100 );

        } catch (\Exception $e) {
            logFile( (array)$e, "log/query_update_" . time() . ".json" );
            return Alert::Error( 100 );
        }

        $data_return = array(
            "ID"        => $user_info->ID,
            "firstname" => $firstname,
            "lastname"  => $lastname,
            "gender"    => is_null( $gender ) ? NULL : ( !!$gender ? "male" : "female" ),
            "age"       => $age,
            "image"     => base_url( IMAGE_DIR_PROFILE . $image_address ),
            "email"     => $user_info->email,
        );

        return Alert::Success( 200, $data_return );
    }

    /**
     * Summary.
     * logout user.
     * @method POST|GET
     * @return string success
     */
    public function Logout() {
        TokenController::Unset( LOGIN_TOKEN_COOKIE_NAME );
        if ( $this->request->getMethod( TRUE ) !== "GET" )
            return Alert::Success( 200 );
        else
            return redirect()->to( base_url( "admin/login" ) );
    }

    /**
     * Summary.
     * return user info by token.
     * @method POST
     * @return string success
     */
    public function Info() {
        $user_info = $this->CheckLogin();

        $user_info->ID        = $user_info->ID;
        $user_info->firstname = $user_info->firstname;
        $user_info->lastname  = $user_info->lastname;
        $user_info->gender    = !!$user_info->gender ? "male" : "female";
        $user_info->age       = $user_info->age;
        $user_info->image     = base_url( IMAGE_DIR_PROFILE . $user_info->image );
        $user_info->email     = $user_info->email;
        $user_info->status    = !!$user_info->status;
        $user_info->is_admin  = !!$user_info->is_admin;
        
        return Alert::Success( 200, $user_info );
    }
}