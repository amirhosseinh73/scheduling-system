<?php

namespace App\Controllers\Admin;

use App\Controllers\ParentAdminController;
use App\Libraries\Alert;
use App\Models\UserModel;

/**
 * Summary.
 * Mange And Create Package items
 * @author amirhosein hasani
*/
class UserController extends ParentAdminController {

    /**
     * # Summary.
     * Get list of user
     * @method GET
     * @var int $offset
     * @var int $limit
     */
    public function Get() {

        $limit  = intval( $this->request->getGet( "limit" ) );
        $offset = intval( $this->request->getGet( "offset" ) );

        if ( ! exists( $offset ) ) $offset = QUERY_OFFSET;
        if ( ! exists( $limit ) ) $limit = QUERY_LIMIT;

        $offset = $offset * $limit;

        $select_user = (new UserModel())->findAll( $limit, $offset );

        $data_return = array();

        $enable  = "<span class='text-success'>فعال</span>";
        $disable = "<span class='text-danger'>غیر فعال</span>";
        $yes     = "<span class='text-success'>بله</span>";
        $no      = "<span class='text-danger'>خیر</span>";
        $male    = "آقا";
        $female  = "خانم";
        
        foreach ( $select_user as $index => $user ) :

            $data_return[] = array(
                "ID"              => $user->ID,
                "firstname"       => $user->firstname,
                "lastname"        => $user->lastname,
                "email"           => $user->email,
                "status"          => !!$user->status ? $enable : $disable,
                "gender"          => !!$user->gender ? $male : $female,
                "age"             => $user->age ?: 0,
                "is_admin"        => !!$user->is_admin ? $yes : $no,
                "image"           => base_url( IMAGE_DIR_PROFILE . $user->image ), 
                "recover_pass_at" => $user->recover_pass_at,
                "last_login"      => $user->last_login,
                "created_at"      => $user->created_at,
                "updated_at"      => $user->updated_at,
            );
        endforeach;

        return Alert::Success( -200, $data_return );
    }

    /**
     * # Summary.
     * Get paginate for list of user
     * @method GET
     */
    public function GetPaginate() {
        return Alert::Success( -200, (new UserModel())->countAllResults() );
    }

    /**
     * # Summary.
     * Create user
     * @var string $code
     * @var string $name
     * @var string $email
     * @var string $password
     * @var bool $status
     * @var bool $is_admin
     * @method POST
     */
    public function Create() {
        $firstname = $this->request->getPost( "firstname" );
        $lastname  = $this->request->getPost( "lastname" );
        $email     = $this->request->getPost( "email" );
        $password  = $this->request->getPost( "password" );
        $status    = $this->request->getPost( "status" ) === "true" ? TRUE : FALSE;
        $is_admin  = $this->request->getPost( "is_admin" ) === "true" ? TRUE : FALSE;
        $gender    = $this->request->getPost( "gender" ) === "male" ? TRUE : FALSE;
        $age       = $this->request->getPost( "age" );
        $is_admin  = $this->request->getPost( "is_admin" ) === "true" ? TRUE : FALSE;
        $image     = $this->request->getFiles();

        if ( ! exists( $firstname ) )                                              return Alert::Error( -115 );
        if ( ! exists( $lastname ) )                                               return Alert::Error( -120 );
        if ( ! exists( $email ) || ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) return Alert::Error( -116 );
        if ( ! exists( $password ) || ! validate_password( $password ) )           return Alert::Error( -119 );

        $user_model = new UserModel();

        $check_user = $user_model->where( "email", $email )->first();
        if ( exists( $check_user ) ) return Alert::Error( -118 );

        $file = $image["image"];
        if ( exists( $file ) ) $image_address = save_request_files( $file, IMAGE_DIR_PROFILE );
        if ( ! exists( $image_address ) ) $image_address = "profile.png";

        $data_insert = array(
            "firstname" => $firstname,
            "lastname"  => $lastname,
            "email"     => $email,
            "password"  => password_hash( $password, PASSWORD_BCRYPT ),
            "status"    => $status,
            "is_admin"  => $is_admin,
            "image"     => $image_address,
            "age"       => $age,
            "gender"    => $gender,
        );

        try{
            $user_ID = $user_model->insert( $data_insert, TRUE );

            if ( ! exists( $user_ID ) ) return Alert::Error( -100 );

        } catch (\Exception $e) {
            logFile( (array)$e, "log/query_insert_" . time() . ".json" );
            return Alert::Error( -100 );
        }

        $enable  = "<span class='text-success'>فعال</span>";
        $disable = "<span class='text-danger'>غیر فعال</span>";
        $yes     = "<span class='text-success'>بله</span>";
        $no      = "<span class='text-danger'>خیر</span>";
        $male    = "آقا";
        $female  = "خانم";

        $data_return = array(
            "ID"              => $user_ID,
            "firstname"       => $firstname,
            "lastname"        => $lastname,
            "email"           => $email,
            "status"          => !!$status ? $enable : $disable,
            "gender"          => !!$gender ? $male : $female,
            "age"             => $age ?: 0,
            "is_admin"        => !!$is_admin ? $yes : $no,
            "image"           => base_url( IMAGE_DIR_PROFILE . $image_address ), 
            "recover_pass_at" => date( "Y-m-d H:i:s" ),
            "last_login"      => date( "Y-m-d H:i:s" ),
            "created_at"      => date( "Y-m-d H:i:s" ),
            "updated_at"      => date( "Y-m-d H:i:s" ),
        );
        return Alert::Success( -200, array( $data_return ) );
    }

    /**
     * # Summary.
     * Edit user
     * @var string $code
     * @var string $name
     * @var string $email
     * @var string $password
     * @var bool $status
     * @var bool $is_admin
     * @var int $ID
     * @method POST
     */
    public function Edit() {
        $ID       = $this->request->getPost( "ID" );
        $firstname = $this->request->getPost( "firstname" );
        $lastname  = $this->request->getPost( "lastname" );
        $email     = $this->request->getPost( "email" );
        $password  = $this->request->getPost( "password" );
        $status    = $this->request->getPost( "status" ) === "true" ? TRUE : FALSE;
        $is_admin  = $this->request->getPost( "is_admin" ) === "true" ? TRUE : FALSE;
        $gender    = $this->request->getPost( "gender" ) === "male" ? TRUE : FALSE;
        $age       = $this->request->getPost( "age" );
        $is_admin  = $this->request->getPost( "is_admin" ) === "true" ? TRUE : FALSE;
        $image     = $this->request->getFiles();

        if ( ! exists( $ID ) )                                                     return Alert::Error( -105 );
        if ( ! exists( $firstname ) )                                              return Alert::Error( -115 );
        if ( ! exists( $lastname ) )                                               return Alert::Error( -120 );
        if ( ! exists( $email ) || ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) return Alert::Error( -116 );
        if ( exists( $password ) && ! validate_password( $password ) )             return Alert::Error( -117 );

        $user_model = new UserModel();

        $check_user = $user_model->where( "ID !=", $ID )->where( "email", $email )->first();
        if ( exists( $check_user ) ) return Alert::Error( -118 );

        $check_user = $user_model->where( "ID", $ID )->first();
        if ( ! exists( $check_user ) ) return Alert::Error( -105 );

        $file = $image["image"];
        if ( exists( $file ) ) $image_address = save_request_files( $file, IMAGE_DIR_PROFILE );
        if ( ! exists( $image_address ) ) $image_address = $check_user->image;

        $data_update = array(
            "firstname" => $firstname,
            "lastname"  => $lastname,
            "email"     => $email,
            "password"  => exists( $password ) ? password_hash( $password, PASSWORD_BCRYPT ) : $check_user->password,
            "status"    => $status,
            "is_admin"  => $is_admin,
            "image"     => $image_address,
            "age"       => $age ?: 0,
            "gender"    => $gender,
        );
        try{
            $check_update = $user_model->update( $ID, $data_update );

            if ( ! $check_update ) return Alert::Error( -100 );

        } catch (\Exception $e) {
            logFile( (array)$e, "log/query_update_" . time() . ".json" );
            return Alert::Error( -100 );
        }

        return Alert::Success( -200, array( $data_update ) );
    }

    /**
     * # Summary.
     * Remove user
     * @var int $ID
     * @method POST
     */
    public function Remove() {
        $ID = $this->request->getPost( "ID" );

        if ( ! exists( $ID ) ) return Alert::Error( -105 );

        try{
            (new UserModel())->delete( $ID );
        } catch (\Exception $e) {
            logFile( (array)$e, "log/query_delete_" . time() . ".json" );
            return Alert::Error( -100 );
        }

        return Alert::Success( -200 );
    }
}