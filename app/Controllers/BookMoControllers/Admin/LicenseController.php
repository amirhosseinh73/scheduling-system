<?php

namespace App\Controllers\Admin;

use App\Controllers\ParentAdminController;
use App\Libraries\Alert;
use App\Models\LibraryModel;
use App\Models\LicenseModel;
use App\Models\PackageModel;
use App\Models\UserModel;

/**
 * Summary.
 * Mange And Create Package items
 * @author amirhosein hasani
*/
class LicenseController extends ParentAdminController {

    /**
     * # Summary.
     * Get list of license
     * @method GET
     * @var int $offset
     * @var int $limit
     * @var bool $other_data --- return all list packages, users or not
     */
    public function Get() {

        $limit  = intval( $this->request->getGet( "limit" ) );
        $offset = intval( $this->request->getGet( "offset" ) );
        $other_data = ( $this->request->getGet( "list_package" ) === "true" ? TRUE : FALSE );

        if ( ! exists( $offset ) ) $offset = QUERY_OFFSET;
        if ( ! exists( $limit ) ) $limit = QUERY_LIMIT;

        $offset = $offset * $limit;

        $select_packages = (new PackageModel())->findAll();

        $select_users    = (new UserModel())->findAll();

        $select_license = (new LicenseModel())
            ->orderBy( "id", "DESC" )
            ->findAll( $limit, $offset );


        $data_return = array();
        foreach ( $select_license as $index => $license ) :

            //packages
            $package_IDs = json_decode( $license->packages, TRUE );

            $active_packages = array();
            if ( exists( $package_IDs ) && is_array( $package_IDs ) ) {
                foreach ( $package_IDs as $package_ID ) {
                    $package_name = array_values( array_filter( $select_packages, function( $key ) use( $package_ID ) {
                        return $key->ID == $package_ID;
                    } ) )[0];

                    array_push(
                        $active_packages,
                        array(
                            "ID"   => $package_name->ID,
                            "name" => $package_name->title,
                        )
                    );
                }
            }

            //users limit
            $user_IDs = json_decode( $license->users, TRUE );
            $limit_users = array();
            if ( exists( $user_IDs ) && is_array( $user_IDs ) ) {
                foreach ( $user_IDs as $user_ID ) {
                    $user_name = array_values( array_filter( $select_users, function( $key ) use( $user_ID ) {
                        return $key->ID == $user_ID;
                    } ) )[0];

                    array_push(
                        $limit_users,
                        array(
                            "ID"   => $user_name->ID,
                            "name" => $user_name->email,
                        )
                    );
                }
            }
            if ( ! exists( $limit_users ) ) $limit_users = "همه";

            //users used
            $user_IDs = json_decode( $license->users_use, TRUE );
            $users_use = array();
            if ( exists( $user_IDs ) && is_array( $user_IDs ) ) {
                foreach ( $user_IDs as $user_ID ) {
                    $user_name = array_values( array_filter( $select_users, function( $key ) use( $user_ID ) {
                        return $key->ID == $user_ID;
                    } ) )[0];

                    array_push(
                        $users_use,
                        array(
                            "ID"   => $user_name->ID,
                            "name" => $user_name->email,
                        )
                    );
                }
            }
            if ( ! exists( $users_use ) ) $users_use = "هیچکس";

            $enable = "<span class='text-success'>فعال</span>";
            $disable = "<span class='text-danger'>غیر فعال</span>";
            $data_return[] = array(
                "ID"             => $license->ID,
                "code"           => $license->code,
                "limit"          => $license->limit, 
                "use"            => $license->use,
                "active_package" => $active_packages,
                "limit_users"    => $limit_users,
                "users_use"      => $users_use,
                "status"         => !!$license->status ? $enable : $disable,
                "created_at"     => $license->created_at,
                "updated_at"     => $license->updated_at,
            );
        endforeach;

        if ( $other_data ) {
            $data_return["all_packages"] = $select_packages;
            $data_return["all_users"]    = $select_users;
        }

        return Alert::Success( -200, $data_return );
    }

    /**
     * # Summary.
     * Get paginate for list of license
     * @method GET
     */
    public function GetPaginate() {
        return Alert::Success( -200, (new LicenseModel())->countAllResults() );
    }

    /**
     * # Summary.
     * Create license
     * @var int $limit
     * @var bool $status
     * @var array $active_packages
     * @method POST
     */
    public function Create() {
        $limit           = intval( $this->request->getPost( "limit" ) );
        $status          = $this->request->getPost( "status" ) === "true" ? TRUE : FALSE ;
        $active_packages = $this->request->getPost( "active_packages" );
        $limit_users     = $this->request->getPost( "limit_users" );

        if ( ! exists( $limit ) )           return Alert::Error( -110 );
        if ( ! exists( $active_packages ) ) return Alert::Error( -112 );

        $active_packages = explode( ",", $active_packages );
        if ( ! exists( $active_packages ) ) return Alert::Error( -113 );

        $package_model = new PackageModel();
        $license_model = new LicenseModel();
        $user_model    = new UserModel();

        $check_package = $package_model->whereIn( "ID", $active_packages )->findAll();
        if ( ! exists( $check_package ) || count( $check_package ) !== count( $active_packages ) ) return Alert::Error( -106 );

        if ( exists( $limit_users ) && $limit_users !== "all" ) {
            $limit_users = explode( ",", $limit_users );
            if ( ! exists( $limit_users ) ) return Alert::Error( -114 );

            $check_user = $user_model->whereIn( "ID", $limit_users )->findAll();
            if ( ! exists( $check_user ) || count( $check_user ) !== count( $limit_users ) ) return Alert::Error( -114 );
        } else {
            $limit_users = NULL;
        }

        $code = custom_random_string( 12 );

        $check_code = $license_model->where( "code", $code )->first();

        while ( exists( $check_code ) ) {
            $code = custom_random_string( 12 );

            $check_code = $license_model->where( "code", $code )->first();
        }

        $data_insert = array(
            "code"     => $code,
            "limit"    => $limit,
            "use"      => 0,
            "status"   => $status,
            "packages" => json_encode( $active_packages ),
            "users"    => exists( $limit_users ) ? json_encode( $limit_users ) : $limit_users,
        );

        try{
            $license_ID = $license_model->insert( $data_insert, TRUE );

            if ( ! exists( $license_ID ) ) return Alert::Error( -100 );

        } catch (\Exception $e) {
            logFile( (array)$e, "log/query_insert_" . time() . ".json" );
            return Alert::Error( -100 );
        }

        $enable = "<span class='text-success'>فعال</span>";
        $disable = "<span class='text-danger'>غیر فعال</span>";
        $data_return = array(
            "ID"             => $license_ID,
            "code"           => $code,
            "limit"          => $limit,
            "use"            => 0,
            "active_package" => $active_packages,
            "limit_users"    => $limit_users,
            "status"         => $status ? $enable : $disable,
            "created_at"     => date( "Y-m-d H:i:s" ),
            "updated_at"     => date( "Y-m-d H:i:s" ),
        );
        return Alert::Success( -200, array( $data_return ) );
    }

    /**
     * # Summary.
     * Edit license
     * @var string $code
     * @var int $limit
     * @var int $use
     * @var bool $status
     * @var array $active_packages
     * @var int $ID
     * @method POST
     */
    public function Edit() {
        $ID              = $this->request->getPost( "ID" );
        $code            = $this->request->getPost( "code" );
        $limit           = intval( $this->request->getPost( "limit" ) );
        $use             = intval( $this->request->getPost( "use" ) );
        $status          = $this->request->getPost( "status" ) === "true" ? TRUE : FALSE ;
        $active_packages = $this->request->getPost( "active_packages" );
        $limit_users     = $this->request->getPost( "limit_users" );
        $users_use       = $this->request->getPost( "users_use" );

        if ( ! exists( $ID ) )                           return Alert::Error( -105 );
        if ( ! exists( $code ) || strlen( $code ) > 12 ) return Alert::Error( -109 );
        if ( ! exists( $limit ) )                        return Alert::Error( -110 );
        if ( ! exists( $active_packages ) )              return Alert::Error( -112 );

        $active_packages = explode( ",", $active_packages );
        if ( ! exists( $active_packages ) )              return Alert::Error( -113 );

        $package_model = new PackageModel();
        $license_model = new LicenseModel();
        $user_model    = new UserModel();
        //when update status license should update status library item active with license
        $library_model = new LibraryModel();

        $check_license = $license_model->where( "ID", $ID )->first();
        if ( ! exists( $check_license ) ) return Alert::Error( -105 );

        $check_package = $package_model->whereIn( "ID", $active_packages )->findAll();
        if ( ! exists( $check_package ) || count( $check_package ) !== count( $active_packages ) ) return Alert::Error( -106 );

        //check users can use this license is for all or specific users
        if ( exists( $limit_users ) && $limit_users !== "all" ) {
            $limit_users = explode( ",", $limit_users );
            if ( ! exists( $limit_users ) ) return Alert::Error( -114 );

            $check_user = $user_model->whereIn( "ID", $limit_users )->findAll();
            if ( ! exists( $check_user ) || count( $check_user ) !== count( $limit_users ) ) return Alert::Error( -114 );
        } else {
            //all users
            $limit_users = NULL;
        }

        if ( exists( $users_use ) && $users_use !== "all" ) {
            $users_use = explode( ",", $users_use );
            if ( ! exists( $users_use ) ) return Alert::Error( -114 );

            $check_user = $user_model->whereIn( "ID", $users_use )->findAll();
            if ( ! exists( $check_user ) || count( $check_user ) !== count( $users_use ) ) return Alert::Error( -114 );
        } else {
            $users_use = NULL;
        }

        if ( ! exists( $use ) ) $use = $check_license->use;

        $check_code = $license_model->where( "ID !=", $ID )->where( "code", $code )->first();
        if ( exists( $check_code ) ) return Alert::Error( -113 );

        $select_library_item = $library_model
            ->where( "active_mode", FALSE ) //false is 0 for license
            ->where( "active_value", $ID ) // license ID
            ->findAll();

        //change status of activated with license
        if ( exists( $select_library_item ) ) {
            $data_update_batch_library = array();
            foreach ( $select_library_item as $library_item ) :
                array_push(
                    $data_update_batch_library,
                    array(
                        "ID"     => $library_item->ID,
                        "status" => $status
                    )
                );
            endforeach;

            if ( exists( $data_update_batch_library ) ) {
                try{
                    $check_update = $library_model->updateBatch( $data_update_batch_library, "ID" );
        
                    if ( ! $check_update || $check_update !== count( $data_update_batch_library ) ) return Alert::Error( -100 );
        
                } catch (\Exception $e) {
                    logFile( (array)$e, "log/query_update_" . time() . ".json" );
                    return Alert::Error( -100 );
                }
            }
        }

        $data_update = array(
            "code"       => $code,
            "limit"      => $limit,
            "use"        => $use,
            "status"     => $status,
            "packages"   => json_encode( $active_packages ),
            "users"      => exists( $limit_users ) ? json_encode( $limit_users ) : $limit_users,
            "users_use"  => exists( $users_use ) ? json_encode( $users_use ) : $users_use,
        );
        try{
            $check_update = $license_model->update( $ID, $data_update );

            if ( ! $check_update ) return Alert::Error( -100 );

        } catch (\Exception $e) {
            logFile( (array)$e, "log/query_update_" . time() . ".json" );
            return Alert::Error( -100 );
        }

        return Alert::Success( -200, array( $data_update ) );
    }

    /**
     * # Summary.
     * Remove license
     * @var int $ID
     * @method POST
     */
    public function Remove() {
        $ID = $this->request->getPost( "ID" );

        if ( ! exists( $ID ) ) return Alert::Error( -105 );

        $license_model = new LicenseModel();
        //when delete license should delete library item active with license
        $library_model = new LibraryModel();

        $select_library_item = $library_model
            ->where( "active_mode", FALSE ) //false is 0 for license
            ->where( "active_value", $ID ) // license ID
            ->findAll();

        //change status of activated with license
        if ( exists( $select_library_item ) ) {
            $data_delete_library = array();
            foreach ( $select_library_item as $library_item ) :
                array_push(
                    $data_delete_library,
                    $library_item->ID
                );
            endforeach;

            if ( exists( $data_delete_library ) ) {
                try{
                    $library_model->delete( $data_delete_library );
        
                } catch (\Exception $e) {
                    logFile( (array)$e, "log/query_update_" . time() . ".json" );
                    return Alert::Error( -100 );
                }
            }
        }

        try{
            $license_model->delete( $ID );
        } catch (\Exception $e) {
            logFile( (array)$e, "log/query_delete_" . time() . ".json" );
            return Alert::Error( -100 );
        }

        return Alert::Success( -200 );
    }
}