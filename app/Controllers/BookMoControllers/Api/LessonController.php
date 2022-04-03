<?php

namespace App\Controllers\Api;

use App\Controllers\ParentController;
use App\Libraries\Alert;
use App\Models\LessonHeadModel;
use App\Models\LessonModel;

class LessonController extends ParentController {
    
    /**
     * Summary.
     * Get lessons
     * @method GET
     * @return string JSON : DATA list lessons
     * @var string $incomming_token as token
     * @var int $package_ID
     */
    public function Get() {

        $user_info = $this->CheckLogin();

        $package_ID = intval( $this->request->getVar( "package_ID" ) );

        if ( ! exists( $package_ID ) ) return Alert::Error( 121 );

        $lesson_head_model = new LessonHeadModel();
        $lesson_model      = new LessonModel();

        $select_heads = $lesson_head_model
            ->where( "package_ID", $package_ID )
            ->findAll();

        if ( ! exists( $select_heads ) ) return Alert::Info( 302 );

        $data_return = array();
        for ( $i = 0; $i < count( $select_heads ); $i++ ) :
            $head = $select_heads[$i];

            $select_lessons = $lesson_model
                ->where( "head_ID", $head->ID )
                ->findAll();

            if ( ! exists( $select_lessons ) ) continue;

            $data_lessons = array();
            for ( $j = 0; $j < count( $select_lessons ); $j++ ) :
                $lesson = $select_lessons[$j];
                
                if ( ! exists( $lesson->image ) ) $lesson->image = "lesson-1.jpg";
                if ( ! file_exists( FCPATH . IMAGE_DIR_LESSON . $lesson->image ) ) $lesson->image = "lesson-1.jpg";

                array_push(
                    $data_lessons,
                    array(
                        "ID"           => $lesson->ID,
                        "title"        => $lesson->title,
                        "descrtiption" => $lesson->description,
                        "image"        => base_url( "/" . IMAGE_DIR_LESSON . $lesson->image ),
                        "url"          => $lesson->URL,
                        "is_free"      => !!$lesson->is_free,
                    )
                );

            endfor;

            array_push(
                $data_return,
                array(
                    "ID"          => $head->ID,
                    "title"       => $head->title,
                    "description" => $head->description,
                    "package_ID"  => $head->package_ID,
                    "lessons"     => $data_lessons,
                )
            );

        endfor;

        return Alert::Success( 200, $data_return );
    }
}