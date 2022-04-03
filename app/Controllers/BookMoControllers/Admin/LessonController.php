<?php

namespace App\Controllers\Admin;

use App\Controllers\ParentAdminController;
use App\Libraries\Alert;
use App\Models\LessonHeadModel;
use App\Models\LessonModel;
use App\Models\PackageModel;

/**
 * Summary.
 * Mange And Create Package items
 * @author amirhosein hasani
*/
class LessonController extends ParentAdminController {

    /**
     * # Summary.
     * Get list of lessons head
     * @method GET
     * @var int $offset
     * @var int $limit
     * @var bool $other_data --- return all list packages or not
     */
    public function GetHead() {

        $limit  = intval( $this->request->getGet( "limit" ) );
        $offset = intval( $this->request->getGet( "offset" ) );
        $other_data = ( $this->request->getGet( "list_package" ) === "true" ? TRUE : FALSE );

        if ( ! exists( $offset ) ) $offset = QUERY_OFFSET;
        if ( ! exists( $limit ) ) $limit = QUERY_LIMIT;

        $offset = $offset * $limit;

        $select_packages     = (new PackageModel())->findAll();
        $package_IDs         = array_column( (array)$select_packages, "ID" );

        $select_lessons_head = (new LessonHeadModel())
            ->whereIn( "package_ID", $package_IDs )
            ->orderBy( "id", "DESC" )
            ->findAll( $limit, $offset );


        $data_return = array();
        foreach ( $select_lessons_head as $index => $head ) :

            $package_name = array_values( array_filter( $select_packages, function( $key ) use( $head ) {
                return $key->ID == $head->package_ID;
            } ) )[0];

            $data_return[] = array(
                "ID"           => $head->ID,
                "package_name" => $package_name->title,
                "title"        => $head->title,
                "description"  => $head->description, 
                "created_at"   => $head->created_at,
                "updated_at"   => $head->updated_at,
                "package_ID"   => $package_name->ID,
            );
        endforeach;

        if ( $other_data ) $data_return["all_packages"] = $select_packages;

        return Alert::Success( -200, $data_return );
    }

    /**
     * # Summary.
     * Get paginate for list of lessons head
     * @method GET
     */
    public function GetPaginateHead() {
        return Alert::Success( -200, (new LessonHeadModel())->countAllResults() );
    }

    /**
     * # Summary.
     * Create lesson head item
     * @var string $title
     * @var string $description
     * @var int $package_ID
     * @method POST
     */
    public function CreateHead() {
        $title       = $this->request->getPost( "title" );
        $description = $this->request->getPost( "description" );
        $package_ID  = intval( $this->request->getPost( "package_ID" ) );

        if ( ! exists( $title ) )      return Alert::Error( -101 );
        if ( ! exists( $package_ID ) ) return Alert::Error( -106 );

        $package_model     = new PackageModel();
        $lesson_head_model = new LessonHeadModel();

        $check_package = $package_model->where( "ID", $package_ID )->first();
        if ( ! exists( $check_package ) ) return Alert::Error( -106 );

        $data_insert = array(
            "title"       => $title,
            "description" => $description,
            "package_ID"  => $package_ID,
        );
        try{
            $lesson_head_ID = $lesson_head_model->insert( $data_insert, TRUE );

            if ( ! exists( $lesson_head_ID ) ) return Alert::Error( -100 );

        } catch (\Exception $e) {
            logFile( (array)$e, "log/query_insert_" . time() . ".json" );
            return Alert::Error( -100 );
        }

        $data_return = array(
            "ID"           => $lesson_head_ID,
            "package_name" => $check_package->title,
            "title"        => $title,
            "description"  => $description, 
            "created_at"   => date( "Y-m-d H:i:s" ),
            "updated_at"   => date( "Y-m-d H:i:s" ),
            "package_ID"   => $check_package->ID,
        );
        return Alert::Success( -200, array( $data_return ) );
    }

    /**
     * # Summary.
     * Edit lesson head item
     * @var string $title
     * @var string $description
     * @var int $grade
     * @var int $price
     * @var int $discount
     * @var file $image
     * @var int $ID
     * @method POST
     */
    public function EditHead() {
        $ID          = $this->request->getPost( "ID" );
        $title       = $this->request->getPost( "title" );
        $description = $this->request->getPost( "description" );
        $package_ID  = intval( $this->request->getPost( "package_ID" ) );

        if ( ! exists( $ID ) ) return Alert::Error( -105 );

        $package_model     = new PackageModel();
        $lesson_head_model = new LessonHeadModel();

        $check_lesson_head = $lesson_head_model->where( "ID", $ID )->first();
        if ( ! exists( $check_lesson_head ) ) return Alert::Error( -105 );

        if ( ! exists( $title ) )      return Alert::Error( -101 );
        if ( ! exists( $package_ID ) ) return Alert::Error( -106 );

        $check_package = $package_model->where( "ID", $package_ID )->first();
        if ( ! exists( $check_package ) ) return Alert::Error( -106 );

        $data_update = array(
            "title"       => $title,
            "description" => $description,
            "package_ID"  => $package_ID,
        );
        try{
            $check_update = $lesson_head_model->update( $ID, $data_update );

            if ( ! $check_update ) return Alert::Error( -100 );

        } catch (\Exception $e) {
            logFile( (array)$e, "log/query_update_" . time() . ".json" );
            return Alert::Error( -100 );
        }

        return Alert::Success( -200, array( $data_update ) );
    }

    /**
     * # Summary.
     * Remove lesson head item
     * @var int $ID
     * @method POST
     */
    public function RemoveHead() {
        $ID = $this->request->getPost( "ID" );

        if ( ! exists( $ID ) ) return Alert::Error( -105 );

        $lesson_head_model = new LessonHeadModel();

        try{
            $lesson_head_model->delete( $ID );
        } catch (\Exception $e) {
            logFile( (array)$e, "log/query_delete_" . time() . ".json" );
            return Alert::Error( -100 );
        }

        return Alert::Success( -200 );
    }

    /**
     * # Summary.
     * Get list of lessons
     * @method GET
     * @var int $offset
     * @var int $limit
     * @var bool $other_data --- return all list packages or not
     */
    public function Get() {

        $limit  = intval( $this->request->getGet( "limit" ) );
        $offset = intval( $this->request->getGet( "offset" ) );
        $other_data = ( $this->request->getGet( "list_package" ) === "true" ? TRUE : FALSE );

        if ( ! exists( $offset ) ) $offset = QUERY_OFFSET;
        if ( ! exists( $limit ) ) $limit = QUERY_LIMIT;

        $offset = $offset * $limit;

        $select_packages = (new PackageModel())->findAll();

        $select_lesson_heads = (new LessonHeadModel())->findAll();
        $head_IDs     = array_column( $select_lesson_heads, "ID" );

        $select_lessons = (new LessonModel())
            ->whereIn( "head_ID", $head_IDs )
            ->orderBy( "id", "DESC" )
            ->findAll( $limit, $offset );


        $data_return = array();
        foreach ( $select_lessons as $index => $lesson ) :

            $head_name = array_values( array_filter( $select_lesson_heads, function( $key ) use( $lesson ) {
                return $key->ID == $lesson->head_ID;
            } ) )[0];

            $no  = "<span class='text-danger'>خیر</span>";
            $yes = "<span class='text-success'>بله</span>";
            $data_return[] = array(
                "ID"           => $lesson->ID,
                "head_name"    => $head_name->title,
                "title"        => $lesson->title,
                "description"  => $lesson->description,
                "URL"          => "<a href='{$lesson->URL}'>{$lesson->URL}</a>",
                "is_free"      => ( $lesson->is_free ) ? $yes : $no,
                "image"        => base_url( IMAGE_DIR_LESSON . $lesson->image ),
                "created_at"   => $lesson->created_at,
                "updated_at"   => $lesson->updated_at,
                "head_ID"      => $head_name->ID,
            );
        endforeach;

        if ( $other_data ) {
            $data_return["all_packages"] = $select_packages;
            $data_return["all_heads"] = $select_lesson_heads;
        }

        return Alert::Success( -200, $data_return );
    }

    /**
     * # Summary.
     * Get paginate for list of lessons
     * @method GET
     */
    public function GetPaginate() {
        return Alert::Success( -200, (new LessonModel())->countAllResults() );
    }

    /**
     * # Summary.
     * Create lesson item
     * @var string $title
     * @var string $description
     * @var int $head_ID
     * @var string $URL
     * @var bool $is_free
     * @var file $image
     * @method POST
     */
    public function Create() {
        $title       = $this->request->getPost( "title" );
        $description = $this->request->getPost( "description" );
        $head_ID     = intval( $this->request->getPost( "head_ID" ) );
        $URL         = $this->request->getPost( "URL" );
        $is_free     = ( $this->request->getPost( "is_free" ) === "true" ? TRUE : FALSE );
        $image       = $this->request->getFiles();

        if ( ! exists( $title ) )   return Alert::Error( -101 );
        if ( ! exists( $head_ID ) ) return Alert::Error( -107 );
        if ( ! exists( $URL ) )     return Alert::Error( -108 );

        $lesson_head_model = new LessonHeadModel();
        $lesson_model      = new LessonModel();

        $check_lesson_head = $lesson_head_model->where( "ID", $head_ID )->first();
        if ( ! exists( $check_lesson_head ) ) return Alert::Error( -107 );

        $file = $image["image"];
        if ( exists( $file ) ) $image_address = save_request_files( $file, IMAGE_DIR_LESSON );
        if ( ! exists( $image_address ) ) $image_address  = "lesson.png";

        $data_insert = array(
            "title"       => $title,
            "description" => $description,
            "head_ID"     => $head_ID,
            "image"       => $image_address,
            "URL"         => $URL,
            "is_free"     => $is_free,
        );
        try{
            $lesson_ID = $lesson_model->insert( $data_insert, TRUE );

            if ( ! exists( $lesson_ID ) ) return Alert::Error( -100 );

        } catch (\Exception $e) {
            logFile( (array)$e, "log/query_insert_" . time() . ".json" );
            return Alert::Error( -100 );
        }

        $data_return = array(
            "ID"           => $lesson_ID,
            "head_name"    => $check_lesson_head->title,
            "title"        => $title,
            "description"  => $description,
            "URL"          => $URL,
            "is_free"      => $is_free,
            "image"        => $image_address,
            "created_at"   => date( "Y-m-d H:i:s" ),
            "updated_at"   => date( "Y-m-d H:i:s" ),
            "head_ID"      => $check_lesson_head->ID,
        );
        return Alert::Success( -201, array( $data_return ) );
    }

    /**
     * # Summary.
     * Edit Package item
     * @var string $title
     * @var string $description
     * @var int $head_ID
     * @var string $URL
     * @var bool $is_free
     * @var int $ID
     * @method POST
     */
    public function Edit() {
        $ID          = $this->request->getPost( "ID" );
        $title       = $this->request->getPost( "title" );
        $description = $this->request->getPost( "description" );
        $head_ID     = intval( $this->request->getPost( "head_ID" ) );
        $URL         = $this->request->getPost( "URL" );
        $is_free     = ( $this->request->getPost( "is_free" ) === "true" ? TRUE : FALSE );
        $image       = $this->request->getFiles();

        if ( ! exists( $ID ) )      return Alert::Error( -105 );
        if ( ! exists( $title ) )   return Alert::Error( -101 );
        if ( ! exists( $head_ID ) ) return Alert::Error( -107 );
        if ( ! exists( $URL ) )     return Alert::Error( -108 );

        $lesson_head_model = new LessonHeadModel();
        $lesson_model      = new LessonModel();

        $check_lesson = $lesson_model->where( "ID", $ID )->first();
        if ( ! exists( $check_lesson ) ) return Alert::Error( -105 );

        if ( ! exists( $head_ID ) ) return Alert::Error( -107 );
        $check_lesson_head = $lesson_head_model->where( "ID", $head_ID )->first();
        if ( ! exists( $check_lesson_head ) ) return Alert::Error( -107 );

        $file = $image["image"];
        if ( exists( $file ) ) $image_address = save_request_files( $file, IMAGE_DIR_LESSON );
        if ( ! exists( $image_address ) ) $image_address  = $check_lesson->image;

        $data_update = array(
            "title"       => $title,
            "description" => $description,
            "head_ID"     => $head_ID,
            "URL"         => $URL,
            "is_free"     => $is_free,
            "image"       => $image_address,
        );
        try{
            $check_update = $lesson_model->update( $ID, $data_update );

            if ( ! $check_update ) return Alert::Error( -100 );

        } catch (\Exception $e) {
            logFile( (array)$e, "log/query_update_" . time() . ".json" );
            return Alert::Error( -100 );
        }

        return Alert::Success( -200, array( $data_update ) );
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

        $lesson_model = new LessonModel();

        try{
            $lesson_model->delete( $ID );
        } catch (\Exception $e) {
            logFile( (array)$e, "log/query_delete_" . time() . ".json" );
            return Alert::Error( -100 );
        }

        return Alert::Success( -200 );
    }

    public function HeadListByPackageID() {
        $package_ID = $this->request->getPost( "package_ID" );

        if ( ! exists( $package_ID ) ) return Alert::Error( -106 );

        $lesson_head_model = new LessonHeadModel();

        $select_lesson_heads = $lesson_head_model
            ->where( "package_ID", $package_ID )
            ->findAll();

        return Alert::Success( -200, $select_lesson_heads );
    }
}