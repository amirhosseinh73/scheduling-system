<?php

namespace App\Controllers\Dashboard;

use App\Controllers\ParentController;
use App\Libraries\Alert;
use App\Libraries\TextLibrary;
use App\Models\QuestionModel;

class QuestionAndAnswerController extends ParentController {
    public function indexPatient() {
        $user_info = get_user_info();

        $data_page = array(
            "title_head"        => TextLibrary::title( "question_answer" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "page_name"         => "question_answer_index",
            "user_info"         => $user_info,
        );

        return $this->renderPageDashboard( "question-answer-patient-index", $data_page );
    }

    public function createPatient() {
        $user_info = get_user_info();

        $data_page = array(
            "title_head"        => TextLibrary::title( "question_answer" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "page_name"         => "question_answer_index",
            "user_info"         => $user_info,
        );

        return $this->renderPageDashboard( "question-answer-patient-create", $data_page );
    }

    public function submitPatient() {
        $user_info = get_user_info();

        $question   = $this->request->getPost( "question" );
        $show       = $this->request->getPost( "show" );
        $type       = $this->request->getPost( "type" );

        if ( strlen( $question ) < 10 ) return Alert::Error( 118 );

        $question_model = new QuestionModel();

        $data_insert = array(
            "user_ID"   => $user_info->ID,
            "question"  => $question,
            "status"    => FALSE,
            "show"      => !!$show,
            "type"      => !!$type,
        );

        try {
            $ret_ID = $question_model->insert( $data_insert );
        } catch( \Exception $e ) {
            return Alert::Error( -1, $e );
        }

        $data_insert[ "ID" ] = $ret_ID;

        return Alert::Success( 200, $data_insert );
    }

    public function showPatient() {
        $user_info = get_user_info();

        $question_model = new QuestionModel();

        $select_question = $question_model
            ->where( "user_ID", $user_info->ID )
            ->where( "type", FALSE )
            ->findAll();

        $data_return = array();

        for ( $i = 0; $i < count( $select_question ); $i++ ) :
            $question = $select_question[ $i ];

            array_push(
                $data_return,
                array(
                    "ID"         => $question->ID,
                    "created_at" => gregorianDatetimeToJalali( $question->created_at )->date,
                    "question"   => str_split_unicode( $question->question, 30 )[ 0 ] . "...",
                    "status"     => $this->statusText( $question->status ),
                    "show"       => $this->showText( !!$question->show ),
                    "updated_at" => gregorianDatetimeToJalali( $question->updated_at )->date,
                )
            );

        endfor;

        return Alert::Success( 200, $data_return );
    }

    private function statusText( $status ) {
        switch ( $status ) :
            case 0:
                return "<span class='text-color-4'>در انتظار پاسخ</span>";
            case 1:
                return "<span class='text-success'>پاسخ داده شده</span>";
            case 2:
                return "<span class='text-dark'>بسته شده</span>";
        endswitch;
    }

    private function showText( $show ) {
        if ( $show ) {
            return "<span class='text-primary'>عمومی</span>";
        } else {
            return "<span class='text-danger'>خصوصی</span>";
        }
    }
}