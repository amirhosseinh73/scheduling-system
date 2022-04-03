<?php

namespace App\Controllers\Api;

use App\Controllers\ParentController;
use App\Libraries\Alert;
use App\Models\PackageModel;

class PackageController extends ParentController {

    /**
     * Summary.
     * Get Packages
     * @method GET
     * @return string JSON : DATA list packages
     * @var string $incomming_token as token
     * @var int $grade 1,2,3,4
     */
    public function Get() {
        
        $user_info = $this->CheckLogin();

        $grade = intval( $this->request->getVar( "grade" ) );

        if ( ! exists( $grade ) ) return Alert::Error( 120 );

        $package_model = new PackageModel();

        $select_packages = $package_model
            ->where( "grade", $grade )
            ->findAll();

        if ( ! exists( $select_packages ) ) return Alert::Info( 301 );

        $library_controller = new LibraryController();
        $library_controller->CallFunction = TRUE;
        $select_library_items = $library_controller->Get( $user_info );

        $data_return = array();
        for ( $i = 0; $i < count( $select_packages ); $i++ ) :
            $package = $select_packages[$i];

            // if package dosen't have any image or if image file is missing
            if ( ! exists( $package->image ) ) $package->image = "package-1.jpg";
            if ( ! file_exists( FCPATH . IMAGE_DIR_PACKAGE . $package->image ) ) $package->image = "package-1.jpg";

            // check buy package or not
            $check_bought = array_filter( $select_library_items, function( $key ) use ( $package ) {
                return $key->package_ID === $package->ID;
            } );

            array_push(
                $data_return,
                array(
                    "ID"               => $package->ID,
                    "title"            => $package->title,
                    "description"      => $package->description,
                    "grade"            => $package->grade,
                    "image"            => base_url( "/" . IMAGE_DIR_PACKAGE . $package->image ),
                    "price"            => floatval( $package->price ),
                    "price_discounted" => floatval( $package->price ) - floatval( $package->discount ),
                    "bought"           => !!exists( $check_bought )
                )
            );

        endfor;

        return Alert::Success( 200, $data_return );
    }
}