<?php

namespace App\Controllers\Dashboard;

use App\Controllers\ParentController;
use App\Libraries\Alert;
use App\Libraries\TextLibrary;
use App\Models\AnswerModel;
use App\Models\QuestionModel;
use App\Models\UserModel;

class QuestionAndAnswerController extends ParentController {
    public function indexPatient() {
        $user_info = get_user_info();

        $data_page = array(
            "title_head"        => TextLibrary::title( "question_answer" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "page_name"         => "question_answer_index_patient",
            "user_info"         => $user_info,
        );

        return $this->renderPageDashboard( "question-answer-patient-index", $data_page );
    }

    public function createPatient() {
        $user_info = get_user_info();

        $data_page = array(
            "title_head"        => TextLibrary::title( "question_answer" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "page_name"         => "question_answer_index_patient",
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

        $select_question_private = $question_model
            ->where( "user_ID", $user_info->ID )
            ->where( "type", FALSE ) // type 1 is ticket
            ->findAll();

        $select_question_public = $question_model
            ->where( "show", TRUE )
            ->where( "type", FALSE ) // type 1 is ticket
            ->findAll();

        $data_return = array(
            "private" => array(),
            "public"  => array(),
        );

        for ( $i = 0; $i < count( $select_question_private ); $i++ ) :
            $question = $select_question_private[ $i ];

            array_push(
                $data_return["private"],
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

        for ( $j = 0; $j < count( $select_question_public ); $j++ ) :
            $question = $select_question_public[ $j ];

            array_push(
                $data_return["public"],
                array(
                    "ID"         => $question->ID,
                    "created_at" => gregorianDatetimeToJalali( $question->created_at )->date,
                    "question"   => str_split_unicode( $question->question, 30 )[ 0 ] . "...",
                    "status"     => $this->statusText( $question->status ),
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

    public function detailPatient() {
        $user_info = get_user_info();

        $QA_ID = $this->request->getGet( "qa-id" );

        if ( ! exists( $QA_ID ) || ! exists( $user_info ) ) return redirect()->to( base_url( "/dashboard/question-answer/patient" ) );

        $question_model = new QuestionModel();
        $answer_model   = new AnswerModel();
        $user_model     = new UserModel();

        $select_question = $question_model
            ->where( "ID", $QA_ID )
            ->where( "user_ID", $user_info->ID )
            ->first();

        if ( ! exists( $select_question ) ) return redirect()->to( base_url( "/dashboard/question-answer/patient" ) );

        $Q_created_at = gregorianDatetimeToJalali( $select_question->created_at );
        $Q_updated_at = gregorianDatetimeToJalali( $select_question->updated_at );

        $select_question->created_at = $Q_created_at->date . " " . $Q_created_at->time;
        $select_question->updated_at = $Q_updated_at->date . " " . $Q_updated_at->time;
        $select_question->show       = !!$select_question->show;

        $select_answer = $answer_model
            ->where( "question_ID", $QA_ID )
            ->orderBy( "created_at", "ASC" )
            ->findAll();

        $data_doctor = array();

        if ( exists( $select_answer ) ) :
            foreach( $select_answer as $answer ) :

                $A_created_at = gregorianDatetimeToJalali( $answer->created_at );
                $A_updated_at = gregorianDatetimeToJalali( $answer->updated_at );

                $answer->created_at = $A_created_at->date . " " . $A_created_at->time;
                $answer->updated_at = $A_updated_at->date . " " . $A_updated_at->time;

                if ( $answer->user_ID === $user_info->ID || exists( $data_doctor ) ) continue;

                $select_doctor = $user_model
                    ->where( "ID", $answer->user_ID )
                    ->first();

                $data_doctor = handle_user_info( $select_doctor );

                $data_doctor = (object)array(
                    "ID" => $data_doctor->ID,
                    "image" => $data_doctor->image,
                    "fullname" => $data_doctor->firstname . " " . $data_doctor->lastname,
                );

            endforeach;
        endif;

        $data_page = array(
            "title_head"        => TextLibrary::title( "question_answer" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "page_name"         => "question_answer_index_patient",
            "user_info"         => $user_info,
            "QA"                => $select_question,
            "answers"           => $select_answer,
            "doctor_info"       => $data_doctor,
        );

        return $this->renderPageDashboard( "question-answer-patient-detail", $data_page );
    }

    public function submitAnswer() {
        $user_info = get_user_info();

        $question    = $this->request->getPost( "question" );
        $question_ID = $this->request->getPost( "question_ID" );

        if ( strlen( $question ) < 10 ) return Alert::Error( 118 );

        if ( ! exists( $question_ID ) ) return Alert::Error( -1 );

        $question_model = new QuestionModel();
        $answer_model = new AnswerModel();

        if ( $user_info->type_user ) { // patient
            $show       = $this->request->getPost( "show" );
    
            $select_question = $question_model
                ->where( "ID", $question_ID )
                ->where( "user_ID", $user_info->ID )
                ->first();
            
            if ( ! exists( $select_question ) ) return Alert::Error( -1 );
    
            $data_update = array(
                "status"    => FALSE,
                "show"      => !!$show,
            );

            $data_insert = array(
                "user_ID"       => $user_info->ID,
                "question_ID"   => $question_ID,
                "answer"        => $question,
            );
    
            try {
                $question_model->update( $question_ID, $data_update );
                $answer_model->insert( $data_insert );
            } catch( \Exception $e ) {
                return Alert::Error( -1, $e );
            }
    
            return Alert::Success( 200 );
        } else { //doctor

        }
    }

    public function closePatient() {
        $user_info = get_user_info();

        $question_ID = $this->request->getPost( "question_ID" );

        if ( ! exists( $question_ID ) ) return Alert::Error( -1 );

        $question_model = new QuestionModel();

        $select_question = $question_model
            ->where( "ID", $question_ID )
            ->where( "user_ID", $user_info->ID )
            ->first();
        
        if ( ! exists( $select_question ) ) return Alert::Error( -1 );

        $data_update = array(
            "status"    => 2,
        );

        try {
            $question_model->update( $question_ID, $data_update );
        } catch( \Exception $e ) {
            return Alert::Error( -1, $e );
        }

        return Alert::Success( 200 );
    }
    
    public function deletePatient() {
        $user_info = get_user_info();

        $question_ID = $this->request->getPost( "question_ID" );

        if ( ! exists( $question_ID ) ) return Alert::Error( -1 );

        $question_model = new QuestionModel();

        $select_question = $question_model
            ->where( "ID", $question_ID )
            ->where( "user_ID", $user_info->ID )
            ->first();
        
        if ( ! exists( $select_question ) ) return Alert::Error( -1 );

        try {
            $question_model->delete( $question_ID );
        } catch( \Exception $e ) {
            return Alert::Error( -1, $e );
        }

        return Alert::Success( 200 );
    }

    public function indexDoctor() {
        $user_info = get_user_info();

        $data_page = array(
            "title_head"        => TextLibrary::title( "question_answer" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "page_name"         => "question_answer_index_doctor",
            "user_info"         => $user_info,
        );

        return $this->renderPageDashboard( "question-answer-doctor-index", $data_page );
    }

    public function showDoctor() {
        $user_info = get_user_info();

        $question_model = new QuestionModel();
        $user_model     = new UserModel();

        $select_question_already_answered = $question_model
            ->where( "relation_user_ID", $user_info->ID )
            ->where( "status !=", FALSE )
            ->where( "type", FALSE ) // type 1 is ticket
            ->findAll();

        $select_question_not_answered = $question_model
            ->groupStart()
                ->where( "relation_user_ID", NULL )
                ->orWhere( "relation_user_ID", $user_info->ID )
            ->groupEnd()
            ->where( "status", FALSE )
            ->where( "type", FALSE ) // type 1 is ticket
            ->findAll();

        $data_return = array(
            "already_answered" => array(),
            "not_answered"  => array(),
        );

        $user_IDs_list_1 = array_column( $select_question_already_answered, "user_ID" );
        $user_IDs_list_2 = array_column( $select_question_not_answered, "user_ID" );

        if ( exists( $user_IDs_list_1 ) ) {
            $select_user_list_1 = $user_model
                ->select( array(
                    "ID",
                    "firstname",
                    "lastname",
                ) )
                ->whereIn( "ID", $user_IDs_list_1 )
                ->findAll();
        }
        
        if ( exists( $user_IDs_list_2 ) ) {
            $select_user_list_2 = $user_model
                ->select( array(
                    "ID",
                    "firstname",
                    "lastname",
                ) )
                ->whereIn( "ID", $user_IDs_list_2 )
                ->findAll();
        }

        for ( $i = 0; $i < count( $select_question_already_answered ); $i++ ) :
            $question = $select_question_already_answered[ $i ];

            $select_patient = array_values( array_filter( $select_user_list_1, function( $key ) use( $question ) {
                return ($key->ID === $question->user_ID); 
            } ) )[ 0 ];

            array_push(
                $data_return["already_answered"],
                array(
                    "ID"         => $question->ID,
                    "created_at" => gregorianDatetimeToJalali( $question->created_at )->date,
                    "question"   => str_split_unicode( $question->question, 30 )[ 0 ] . "...",
                    "show"       => $this->showText( !!$question->show ),
                    "updated_at" => gregorianDatetimeToJalali( $question->updated_at )->date,
                    "fullname_patient" => $select_patient->firstname . " " . $select_patient->lastname,
                )
            );

        endfor;

        for ( $j = 0; $j < count( $select_question_not_answered ); $j++ ) :
            $question = $select_question_not_answered[ $j ];

            $select_patient = array_values( array_filter( $select_user_list_2, function( $key ) use( $question ) {
                return ($key->ID === $question->user_ID); 
            } ) )[ 0 ];

            array_push(
                $data_return["not_answered"],
                array(
                    "ID"         => $question->ID,
                    "created_at" => gregorianDatetimeToJalali( $question->created_at )->date,
                    "question"   => str_split_unicode( $question->question, 30 )[ 0 ] . "...",
                    "show"       => $this->showText( !!$question->show ),
                    "updated_at" => gregorianDatetimeToJalali( $question->updated_at )->date,
                    "fullname_patient" => $select_patient->firstname . " " . $select_patient->lastname,
                )
            );

        endfor;

        return Alert::Success( 200, $data_return );
    }

    public function detailDoctor() {
        $user_info = get_user_info();

        $QA_ID = $this->request->getGet( "qa-id" );

        if ( ! exists( $QA_ID ) || ! exists( $user_info ) ) return redirect()->to( base_url( "/dashboard/question-answer/doctor" ) );

        $question_model = new QuestionModel();
        $answer_model   = new AnswerModel();
        $user_model     = new UserModel();

        $select_question = $question_model
            ->where( "ID", $QA_ID )
            // ->where( "relation_user_ID", $user_info->ID )
            ->first();

        if ( ! exists( $select_question ) ) return redirect()->to( base_url( "/dashboard/question-answer/doctor" ) );

        $Q_created_at = gregorianDatetimeToJalali( $select_question->created_at );
        $Q_updated_at = gregorianDatetimeToJalali( $select_question->updated_at );

        $select_question->created_at = $Q_created_at->date . " " . $Q_created_at->time;
        $select_question->updated_at = $Q_updated_at->date . " " . $Q_updated_at->time;
        $select_question->show       = !!$select_question->show;

        $select_answer = $answer_model
            ->where( "question_ID", $QA_ID )
            ->orderBy( "created_at", "ASC" )
            ->findAll();

        $data_patient = array();

        if ( exists( $select_answer ) ) :
            foreach( $select_answer as $answer ) :

                $A_created_at = gregorianDatetimeToJalali( $answer->created_at );
                $A_updated_at = gregorianDatetimeToJalali( $answer->updated_at );

                $answer->created_at = $A_created_at->date . " " . $A_created_at->time;
                $answer->updated_at = $A_updated_at->date . " " . $A_updated_at->time;

                if ( $answer->user_ID === $user_info->ID || exists( $data_patient ) ) continue;

                $select_patient = $user_model
                    ->where( "ID", $answer->user_ID )
                    ->first();

                $data_patient = handle_user_info( $select_patient );

                $data_patient = (object)array(
                    "ID" => $data_patient->ID,
                    "image" => $data_patient->image,
                    "fullname" => $data_patient->firstname . " " . $data_patient->lastname,
                );

            endforeach;
        endif;

        $data_page = array(
            "title_head"        => TextLibrary::title( "question_answer" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "page_name"         => "question_answer_index_doctor",
            "user_info"         => $user_info,
            "QA"                => $select_question,
            "answers"           => $select_answer,
            "patient_info"       => $data_patient,
        );

        return $this->renderPageDashboard( "question-answer-doctor-detail", $data_page );
    }
}