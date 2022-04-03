<?php

namespace App\Controllers\Admin;

use App\Controllers\ParentAdminController;
use App\Libraries\Alert;
use App\Models\PackageModel;

/**
 * Summary.
 * Mange And Create Package items
 * @author amirhosein hasani
*/
class PackageController extends ParentAdminController {

    /**
     * # Summary.
     * Get list of packages
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

        $select_packages = (new PackageModel())->findAll( $limit, $offset );

        $data_return = array();
        foreach ( $select_packages as $index => $package ) :
            $data_return[] = array(
                "ID"          => $package->ID,
                "title"       => $package->title,
                "description" => $package->description,
                "grade"       => grade_text( intval( $package->grade ) ),
                "price"       => $package->price,
                "discount"    => $package->discount,
                "image"       => base_url( IMAGE_DIR_PACKAGE . $package->image ),
                "created_at"  => $package->created_at,
                "updated_at"  => $package->updated_at,
            );
        endforeach;

        return Alert::Success( -200, $data_return );
    }

    /**
     * # Summary.
     * Get paginate for list of packages
     * @method GET
     */
    public function GetPaginate() {
        return Alert::Success( -200, (new PackageModel())->countAllResults() );
    }

    /**
     * # Summary.
     * Create Package item
     * @var string $title
     * @var string $description
     * @var int $grade
     * @var int $price
     * @var int $discount
     * @var file $image
     * @method POST
     */
    public function Create() {
        $title       = $this->request->getPost( "title" );
        $description = $this->request->getPost( "description" );
        $grade       = intval( $this->request->getPost( "grade" ) );
        $price       = floatval( $this->request->getPost( "price" ) );
        $discount    = floatval( $this->request->getPost( "discount" ) );
        $image       = $this->request->getFiles();

        if ( ! exists( $title ) )                             return Alert::Error( -101 );
        if ( ! exists( $grade ) || $grade > 4 || $grade < 1 ) return Alert::Error( -102 );
        if ( ! exists( $price ) )                             return Alert::Error( -103 );
        if ( exists( $discount ) && $discount > $price )      return Alert::Error( -104 );

        $package_model = new PackageModel();

        $file = $image["image"];
        if ( exists( $file ) ) $image_address = save_request_files( $file, IMAGE_DIR_PACKAGE );
        if ( ! exists( $image_address ) ) $image_address  = "package.png";

        $data_insert = array(
            "title"       => $title,
            "description" => $description,
            "grade"       => $grade,
            "price"       => $price,
            "discount"    => $discount,
            "image"       => $image_address,
        );
        try{
            $package_ID = $package_model->insert( $data_insert, TRUE );

            if ( ! exists( $package_ID ) ) return Alert::Error( -100 );

            // $data_insert[ "ID" ]    = $package_ID;
            $data_insert[ "image" ] = base_url( IMAGE_DIR_PACKAGE . $image_address );
            $data_insert[ "grade" ] = grade_text( $grade );
            $data_insert[ "created_at" ] = date( "Y-m-d H:i:s" );
            
        } catch (\Exception $e) {
            logFile( (array)$e, "log/query_insert_" . time() . ".json" );
            return Alert::Error( -100 );
        }

        return Alert::Success( -201, array( $data_insert ) );
    }

    /**
     * # Summary.
     * Edit Package item
     * @var string $title
     * @var string $description
     * @var int $grade
     * @var int $price
     * @var int $discount
     * @var file $image
     * @var int $ID
     * @method POST
     */
    public function Edit() {
        $ID          = $this->request->getPost( "ID" );
        $title       = $this->request->getPost( "title" );
        $description = $this->request->getPost( "description" );
        $grade       = intval( $this->request->getPost( "grade" ) );
        $price       = floatval( $this->request->getPost( "price" ) );
        $discount    = floatval( $this->request->getPost( "discount" ) );
        $image       = $this->request->getFiles();

        if ( ! exists( $ID ) ) return Alert::Error( -105 );

        $package_model = new PackageModel();

        $check_package = $package_model->where( "ID", $ID )->first();
        if ( ! exists( $check_package ) ) return Alert::Error( -105 );

        if ( ! exists( $title ) )                             return Alert::Error( -101 );
        if ( ! exists( $grade ) || $grade > 4 || $grade < 1 ) return Alert::Error( -102 );
        if ( ! exists( $price ) )                             return Alert::Error( -103 );
        if ( exists( $discount ) && $discount > $price )      return Alert::Error( -104 );

        $file = $image["image"];
        if ( exists( $file ) ) $image_address = save_request_files( $file, IMAGE_DIR_PACKAGE );
        if ( ! exists( $image_address ) ) $image_address  = $check_package->image;

        $data_update = array(
            "title"       => $title,
            "description" => $description,
            "grade"       => $grade,
            "price"       => $price,
            "discount"    => $discount,
            "image"       => $image_address,
        );
        try{
            $check_update = $package_model->update( $ID, $data_update );

            if ( ! $check_update ) return Alert::Error( -100 );

            // $data_update[ "ID" ]    = $ID;
            // $data_update[ "image" ] = base_url( IMAGE_DIR_PACKAGE . $image_address );
            // $data_update[ "grade" ] = grade_text( $grade );
            // $data_update[ "created_at" ] = date( "Y-m-d H:i:s" );
            
        } catch (\Exception $e) {
            logFile( (array)$e, "log/query_update_" . time() . ".json" );
            return Alert::Error( -100 );
        }

        return Alert::Success( -203, array( $data_update ) );
    }

    /**
     * # Summary.
     * Remove Package item
     * @var int $ID
     * @method POST
     */
    public function Remove() {
        $ID = $this->request->getPost( "ID" );

        if ( ! exists( $ID ) ) return Alert::Error( -105 );

        $package_model = new PackageModel();

        try{
            $package_model->delete( $ID );
        } catch (\Exception $e) {
            logFile( (array)$e, "log/query_delete_" . time() . ".json" );
            return Alert::Error( -100 );
        }

        return Alert::Success( -202 );
    }
}