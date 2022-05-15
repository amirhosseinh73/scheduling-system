<?php

namespace App\Controllers\Dashboard;

use App\Controllers\ParentController;
use App\Libraries\Alert;
use App\Libraries\TextLibrary;
use App\Models\ExamModel;
use App\Models\ExamQuestionModel;

class ExamController extends ParentController {
    public function index() {
        $user_info = get_user_info();

        $data_page = array(
            "title_head"        => TextLibrary::title( "exam" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "page_name"         => "exam_index",
            "user_info"         => $user_info,
        );

        return $this->renderPageDashboard( "exam-index", $data_page );
    }

    public function get() {
        $exam_model = new ExamModel();
        $exam_question_model = new ExamQuestionModel();

        $select_exam = $exam_model->findAll();
        $select_exam_question = $exam_question_model->select( "exam_ID" )->findAll();

        $data_return = array();
        if ( is_array( $select_exam_question ) ) :
            foreach ( $select_exam as $exam ) :
                $exam_questions = array_values( array_filter( $select_exam_question, function( $key ) use( $exam ) {
                    return $key->exam_ID === $exam->ID;
                } ) );

                $data_return[] = array(
                    "ID"              => $exam->ID,
                    "title"           => $exam->title,
                    "description"     => $exam->description,
                    "time"            => $exam->time,
                    "image"           => $exam->image ? base_url( IMAGE_DIR_EXAM . $exam->image ) : IMAGE_DEFAULT,
                    "created_at"      => gregorianDatetimeToJalali( $exam->created_at )->date,
                    "updated_at"      => gregorianDatetimeToJalali( $exam->updated_at )->date,
                    "questions_count" => count( $exam_questions ),
                );
            endforeach;
        endif;

        return Alert::Success( 200, $data_return );
    }

    public function page() {
        $exam_ID = $this->request->getGet( "id" );

        if ( ! exists( $exam_ID ) ) return redirect()->to( base_url( "/dashboard/exam" ) );

        $exam_model = new ExamModel();

        $select_exam = $exam_model
            ->where( "ID", $exam_ID )
            ->first();

        if ( ! exists( $select_exam ) ) return redirect()->to( base_url( "/dashboard/exam" ) );

        $user_info = get_user_info();

        $data_page = array(
            "title_head"        => TextLibrary::title( "exam" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "page_name"         => "exam_index",
            "user_info"         => $user_info,
        );

        return $this->renderPageDashboard( "exam-page", $data_page );        
    }

    public function getQuestions() {

        $exam_ID = $this->request->getGet( "id" );

        $exam_question_model = new ExamQuestionModel();

        $select_exam_question = $exam_question_model
            ->where( "exam_ID", $exam_ID)
            ->findAll();

        $data_return = array();
        foreach( $select_exam_question as $question ) :

            if ( ! !!$question->status ) continue;

            $data_return[] = array(
                "ID"         => $question->ID,
                "exam_ID"    => $question->exam_ID,
                "type"       => !!$question->type ? "checkbox" : "radio",
                "status"     => !!$question->status,
                "question"   => $question->question,
                "answer"     => json_decode( $question->answer ),
                "created_at" => gregorianDatetimeToJalali( $question->created_at )->date,
                "updated_at" => gregorianDatetimeToJalali( $question->updated_at )->date,
            );
        endforeach;

        return Alert::Success( 200, $data_return );
    }
}