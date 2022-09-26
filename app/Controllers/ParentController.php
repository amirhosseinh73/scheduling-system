<?php

namespace App\Controllers;

use App\Libraries\Alert;
use App\Models\MetadataModel;
use Config\Services;

class ParentController extends BaseController {
    protected $helpers = array(
        "Jalali_date",
        "public",
    );

    /**
     * Summary.
     * if set TRUE, return data in methods
     * if FLSE return Alert and die with data
     * @var bool $CallFunction
     */
    protected $callFunction = FALSE;

    /**
     * email details
     * @var string $email
     * @var string $name
     * @var string $password
     * @var bool   $recovery_password
     * @var string $subject
     */
    protected string $email_send       = "";
    protected string $email_name        = "";
    protected string $email_subject     = "";

    protected function sendEmail() {

        $message = "<div style='direction: ltr !important;'>
                        آقای/خانم {$this->email_name} عزیز! پاسخ آزمون شما ثبت شد!
                        <b>
                        موسسه مشاوره کیمیای مهر
                        </b>
                        <br/>
                        ------------------------
                        <br/>
                </div>";
        
        $config = array();
        $email_config = Services::email();
        $config["protocol"]    = "SMTP";
        $config["SMTPHost"]    = "smtp.gmail.com";
        $config["SMTPUser"]    = "amirhoseinh1373@gmail.com";
        $config["SMTPPass"]    = "AmiR0016973178#aMIr@";
        $config["SMTPPort"]    = 465;
        $config["SMTPTimeout"] = 60;
        $config["SMTPCrypto"]  = "ssl";
        $config["mailType"]    = "html";
        
        $email_config->initialize($config);
        
        $email_config->setTo($this->email_send);
        $email_config->setFrom( $config["SMTPUser"], "Support KimiyaMehr" );
        $email_config->setSubject($this->email_subject);
        $email_config->setMessage($message);
    
        // if (mail($email_details->email, $email_details->subject, $message, "From: amirhoseinh1373@gmail.com")) {
        //     echo "Email successfully sent to ...";
        // } else {
        //     echo "Email sending failed...";
        // }

        if ($email_config->send()) {
            return TRUE;
        } else {
            // print_r($email_config->printDebugger());
            logFile((array)$email_config->printDebugger(), "log/email_not_send_" . time() . ".json");
            return FALSE;
        }
    }

    /**
     * Summary.
     * Check login by token
     * @var $incomming_token as token
     * @return string|object die and return json | $user_info
     */
    protected function checkLogin() {

        $user_info = TokenController::UserData( LOGIN_TOKEN_COOKIE_NAME ); // use for web

        if ( ! $user_info || ! exists( $user_info->ID ) ) return Alert::Error( 101 );

        return $user_info;
    }

    protected function renderPageSite( string $page, array $data, $header = "header", $footer = "footer" ) {
        global $classes;
        $classes = [
            $data[ "page_name" ],
            "$page-php"
        ];

        $data[ "classes" ] = implode( " ", $classes );

        return render_page( "Site/$page", $data, $header, $footer );
    }

    protected function renderPageDashboard( string $page, array $data, $header = "header-dashboard", $footer = "footer-dashboard" ) {
        global $classes;
        $classes = [
            $data[ "page_name" ],
            "$page-php"
        ];

        $data[ "classes" ] = implode( " ", $classes );

        return render_page( "Dashboard/$page", $data, $header, $footer );
    }

    function render_page_admin(string $page, array $data, string $header = "header", string $footer = "footer") {
        global $classes;
        $classes = [
            $data[ "page_name" ],
            "$page-php"
        ];

        $data[ "classes" ] = implode( " ", $classes );

        return render_page( "Admin/$page", $data, $header, $footer );
    }

    protected function checkImageReturn( $address, $image ) {
        return ( ( exists( $image ) && file_exists( FCPATH . $address . $image ) ) ? base_url( $address ) . "/" . $image  : IMAGE_DEFAULT );
    }

    protected function firstSegment() {
        //"http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"
        $uri = new \CodeIgniter\HTTP\URI( current_url() );

        return $uri->getSegment( 1 );
    }

    protected function secondSegment() {
        $uri = new \CodeIgniter\HTTP\URI( current_url() );

        return $uri->getSegment( 2 );
    }

    protected function handlePostData( $post, $post_url, $post_image_url ) {
        $post->url          = base_url( $post_url . $post->url );
        $post->image        = $this->checkImageReturn( $post_image_url, $post->image );
        $post->excerpt      = $post->excerpt ?: str_split_unicode( $post->content, 150 )[ 0 ] . "...";
        $post->publish_at   = gregorianDatetimeToJalali( $post->publish_at );
        $post->tag          = $this->handleTag( $post->tag );

        return $post;
    }

    /**
     * @return array
     */
    protected function handleTag( string $tags ) {
        if ( is_array( $tags ) ) return;

        $tags_1 = explode( ",", $tags );

        $tags_1 = implode( "/", $tags_1 );
        $tags_2 = explode( "/", $tags_1 );

        $tags_2 = implode( "،", $tags_2 );
        $tags_3 = explode( "،", $tags_2 );

        $tags_3 = implode( "-", $tags_3 );
        $tags_4 = explode( "-", $tags_3 );

        return $tags_4;
    }

    protected function handleMetadata( $parent_key ) {

        $metadata_model = new MetadataModel();

        $select_metadata = $metadata_model
            ->where( "parent", $parent_key )
            ->findAll();

        $data = array();
        foreach( $select_metadata as $metadata ) :

            $meta_value = json_decode( $metadata->meta_value );

            $data[ $metadata->meta_key ] = ( count( $meta_value ) === 1 ? $meta_value[ 0 ] : $meta_value );
        endforeach;

        return (object)$data;
    }

    protected function calcTurnTime( $start_time, $reserved, $each_time ) {
        $start_time = explode( ":", $start_time );
        $hour    = intval( $start_time[ 0 ] );
        $minute  = intval( $start_time[ 1 ] );

        if ( intval( $reserved ) !== 0 ) {
            $minute = $minute + ( $each_time * $reserved );

            while ( $minute >= 60 ) { //calc hour
                $hour++;
                $minute -= 60;
            }
        }
        if ( $minute === 0 ) $minute = "00";
        if ( strlen( strval( $minute ) ) === 1 ) $minute = "0" . $minute;
        if ( strlen( strval( $hour ) ) === 1 ) $hour = "0" . $hour;

        return $hour . ":" . $minute;
    }
}