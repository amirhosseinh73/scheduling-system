<?php

namespace App\Controllers\Api;

use App\Controllers\ParentController;
use App\Libraries\Alert;
use App\Models\LibraryModel;
use App\Models\LicenseModel;
use App\Models\PackageModel;

class LicenseController extends ParentController{

    /**
     * Summary.
     * use license code to active packages have that license code
     * @var string $code license code
     * @return string JSON success or failed
     */
    public function Use() {
        $user_info = $this->CheckLogin();

        $code = $this->request->getPost( "code" );

        if ( ! exists( $code ) ) return Alert::Error( 123 );

        $license_model = new LicenseModel();
        $package_model = new PackageModel();
        $library_model = new LibraryModel();

        $select_license = $license_model
            ->where( "code", $code )
            ->CustomFirst();
        if ( ! exists( $select_license ) ) return Alert::Error( 123 );
        $select_license = $license_model
            ->where( "code", $code )
            ->where( "limit >", $select_license->use )
            ->CustomFirst();
        if ( ! exists( $select_license ) || ! exists( $select_license->ID ) ) return Alert::Error( 124 );

        //check license for all or specific user and check user ID
        if ( exists( $select_license->users ) ):
            $license_user_IDs = json_decode( $select_license->users, TRUE );

            if ( ! exists( $license_user_IDs ) ) return Alert::Error( 102 );

            if ( ! in_array( $user_info->ID, $license_user_IDs ) ) return Alert::Error( 125 );
        endif;

        //check user used this code or not
        if ( exists( $select_license->users_use ) ):
            $users_use_IDs = json_decode( $select_license->users_use, TRUE );

            if ( ! exists( $users_use_IDs ) ) return Alert::Error( 102 );

            if ( in_array( $user_info->ID, $users_use_IDs ) ) return Alert::Info( 303 );

            array_push(
                $users_use_IDs,
                $user_info->ID,
            );
        else:
            $users_use_IDs = array(
                $user_info->ID
            );
        endif;

        $package_IDs = json_decode( $select_license->packages, true );

        if ( ! exists( $package_IDs ) ) return Alert::Error( 123 );

        $select_package = $package_model
            ->whereIn( "ID", $package_IDs )
            ->findAll();

        if ( ! exists( $select_package ) ) return Alert::Error( 123 );

        $data_insert_library = array();
        $data_update_library = array();
        $data_update_package = array();

        //select all package in user library
        $select_library_item = $library_model
            ->where( "user_ID", $user_info->ID )
            ->findAll();
            
        //multiple package, use updateBatch and insertBatch
        foreach ($select_package as $package) :
            //check exist library item and if status is FALSE update it
            if ( exists( $select_library_item ) ) {
                $library_item = array_values( array_filter( $select_library_item, function( $key ) use( $package ) {
                    return ( $key->package_ID === $package->ID );
                } ) );

                if ( exists( $library_item ) && exists( $library_item[0] ) ) {
                    $library_item = $library_item[0];

                    if ( ! $library_item->status ) {
                        array_push(
                            $data_update_library,
                            array(
                                "ID"     => $library_item->ID,
                                "status" => TRUE,
                            )
                        );
                    }

                    continue;
                }
            }

            //insert data library
            array_push(
                $data_insert_library,
                array(
                    "user_ID"      => $user_info->ID,
                    "package_ID"   => $package->ID,
                    "active_mode"  => FALSE,
                    "active_value" => $select_license->ID,
                    "status"       => TRUE,
                )
            );

            //update data package
            array_push(
                $data_update_package,
                array(
                    "ID"          => $package->ID,
                    "sales_count" => intval( $package->sales_count ) + 1
                )
            );
        endforeach;

        $data_update_license = array(
            "use"       => intval( $select_license->use ) + 1,
            "users_use" => json_encode( $users_use_IDs ),
        );

        if ( ! exists( $data_update_library ) && ! exists( $data_insert_library ) ) return Alert::Info( 304 );

        try{

            $library_model->updateBatch( $data_update_library, "ID" );
            $library_model->insertBatch( $data_insert_library );

            $check_update = $license_model->update( $select_license->ID, $data_update_license );
            $check_update_2 = $package_model->updateBatch( $data_update_package, "ID" );

            if ( ! $check_update ) return Alert::Error( 100 );
            if ( $check_update_2 !== count( $data_update_package ) ) return Alert::Error( 100 );

        } catch (\Exception $e) {
            logFile( (array)$e, "log/query_insert_update_" . time() . ".json" );
            return Alert::Error( 100 );
        }

        return Alert::Success( 200 );
    }

}