<?php

namespace App\Controllers\Api;

use App\Controllers\ParentController;
use App\Libraries\Alert;
use App\Models\LibraryModel;
use App\Models\PackageModel;

class LibraryController extends ParentController{

    /**
     * Summary.
     * Get Library items
     * @method GET
     * @return string|array JSON : DATA list library items|array data
     * @var string $incomming_token as token
     * @see int user_ID with token
     */
    public function Get( $user_info = NULL ) {

        if ( ! $this->CallFunction ) $user_info = $this->CheckLogin();

        $library_model = new LibraryModel();
        $pacakge_model = new PackageModel();

        $select_library_items = $library_model
            ->where( "user_ID", $user_info->ID )
            ->CustomFindAll();

        $package_IDs = array_column( $select_library_items, "package_ID" );

        $select_packages_in_library = $pacakge_model
            ->whereIn( "ID", $package_IDs )
            ->findAll();
        
        if ( ! $this->CallFunction && ! exists( $select_library_items ) ) return Alert::Info( 302 );

        $data_return = array();
        for ( $i = 0; $i < count( $select_library_items ); $i++ ):
            $item = $select_library_items[$i];

            $package = array_values( array_filter( (array)$select_packages_in_library, function( $key ) use( $item ) {
                return $key->ID === $item->package_ID;
            } ) )[ 0 ];

            $data_item = array(
                "ID"           => $item->ID,
                "user_ID"      => $item->user_ID,
                "active_mode"  => ( !!$item->active_mode ? "payment" : "license" ),
                "active_value" => $item->active_value,
                "status"       => !!$item->status,
                "created_at"   => $item->created_at,
                "updated_at"   => $item->updated_at,

                //package data
                "package_ID"       => $item->package_ID,
                // "ID"               => $package->ID,
                "title"            => $package->title,
                "description"      => $package->description,
                "grade"            => $package->grade,
                "image"            => base_url( "/" . IMAGE_DIR_PACKAGE . $package->image ),
                "price"            => floatval( $package->price ),
                "price_discounted" => floatval( $package->price ) - floatval( $package->discount ),
                "bought"           => TRUE,
            );

            if ( $this->CallFunction ) $data_item = (object)$data_item;

            array_push(
                $data_return,
                $data_item
            );
        endfor;

        if ( $this->CallFunction ) return $data_return;

        return Alert::Success( 200, $data_return );
    }

}