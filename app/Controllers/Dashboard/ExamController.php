<?php

namespace App\Controllers\Dashboard;

use App\Controllers\ParentController;
use App\Libraries\Alert;
use App\Libraries\TextLibrary;
use App\Models\ExamAnswerModel;
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

    public function submitAnswer() {
        $questions_data = json_decode( $this->request->getPost( "all_questions" ) );

        if ( ! exists( $questions_data ) ) return Alert::Error( -1 );

        $user_info = get_user_info();

        if ( ! exists( $user_info ) ) return Alert::Error( -1 );

        $exam_answer_model = new ExamAnswerModel();

        $select_exist_answer = $exam_answer_model
            ->where( "exam_ID", $questions_data[ 0 ]->exam_ID )
            ->where( "user_ID", $user_info->ID )
            ->findAll();

        // $select_exist_answer = json_decode( json_encode_unicode( $select_exist_answer ) , TRUE );

        if ( $select_exist_answer ) :
            //soft delete old answer of user
            $old_answers_ID = array_column( $select_exist_answer, "ID" );
            
            $exam_answer_model->delete( $old_answers_ID );

        endif;

        $data_insert = array();
        foreach ( $questions_data as $answer ) :

            array_push(
                $data_insert,
                array(
                    "question_ID" => $answer->question_ID,
                    "answer_ID" => $answer->answer_ID,
                    "answer_text" => $answer->answer_text,
                    "user_ID" => $user_info->ID,
                    "exam_ID" => $answer->exam_ID,
                )
            );

        endforeach;

        try {
            if ( ! $user_info->email ) return Alert::Error( 118 );
            $exam_answer_model->insertBatch( $data_insert );

            $this->email_name = $user_info->firstname . " " . $user_info->lastname;
            $this->email_send = $user_info->email;
            $this->email_subject = "آزمون آنلاین";
            $this->sendEmail();
        } catch ( \Exception $e ) {
            return Alert::Error( 102 );
        }

        return Alert::Success( 200, [], base_url( "dashboard/exam" ) );
    }
}