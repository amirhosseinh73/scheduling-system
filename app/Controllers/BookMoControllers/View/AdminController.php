<?php

namespace App\Controllers\View;

use App\Controllers\ParentAdminController;
use App\Libraries\Alert;
use App\Models\LessonHeadModel;
use App\Models\LessonModel;
use App\Models\PackageModel;

use function PHPUnit\Framework\fileExists;

/**
 * Summary.
 * for load pages
 * @author amirhosein hasani
 * @method GET
 */
class AdminController {

    public function PackageAdd() {
        $json = file_get_contents( FCPATH . "config/data-package.json" );
        $json = json_decode( $json );

        $package_model     = new PackageModel();
        $lesson_head_model = new LessonHeadModel();
        $lesson_model      = new LessonModel();

        // $data_package     = array();
        // $data_lesson_head = array();
        // $data_lesson      = array();
        foreach ( $json as $index => $item ) {
            $data_package = array(
                "title"       => $item->title,
                "description" => $item->description,
                "price"       => $item->price,
                "discount"    => $item->discount,
                "grade"       => $item->grade,
                "image"       => file_exists( FCPATH . IMAGE_DIR_PACKAGE . $item->image ) ? $item->image : "package.png",
            );

            $check_insert_package = $package_model->insert( $data_package, TRUE );
            if ( ! exists( $check_insert_package ) ) return Alert::Error( 100 );

            $lesson_heads = (array)$item;
            $lesson_heads = $lesson_heads["lesson-heads"];

            foreach ( $lesson_heads as $head ) {
                $data_lesson_head = array(
                    "title"       => $head->title,
                    "description" => $head->description,
                    "package_ID"  => $check_insert_package,
                );

                $check_insert_lesson_head = $lesson_head_model->insert( $data_lesson_head, TRUE );
                if ( ! exists( $check_insert_lesson_head ) ) return Alert::Error( 101 );
                
                foreach ( $head->lessons as $lesson ) {
                    $data_lesson = array(
                        "title"       => $lesson->title,
                        "description" => $lesson->description,
                        "image"       => file_exists( FCPATH . IMAGE_DIR_PACKAGE . $lesson->image ) ? $lesson->image : "lesson.png",
                        "URL"         => $lesson->url,
                        "is_free "    => !!$lesson->is_free,
                        "head_ID"     => $check_insert_lesson_head,
                    );
    
                    $check_insert_lesson = $lesson_model->insert( $data_lesson, TRUE );
                    if ( ! exists( $check_insert_lesson ) ) return Alert::Error( 102 );

                }
            }
        }
        return Alert::Success( 200 );
    }
}