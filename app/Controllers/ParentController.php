<?php

namespace App\Controllers;

use App\Libraries\Alert;
use Config\Services;

class ParentController extends BaseController {
    protected $helpers = array(
        "Jalali_date",
        "public",
    );

    /**
     * email details
     * @var string $email
     * @var string $name
     * @var string $password
     * @var bool   $recovery_password
     * @var string $subject
     */
    protected string $email       = "";
    protected string $name        = "";
    protected string $password    = "";
    protected string $subject     = "";
    protected bool   $is_recovery = FALSE;

    protected function sendEmail() {

        if ( $this->is_recovery ) {
            $message = "<div style='direction: ltr !important;'>
                            Dear Mr/Mrs {$this->name} your <b>password</b> successfully changed!
                            <br/>
                            ------------------------
                            <br/>
                            your new password is: <b>{$this->password}</b>
                            <br/>
                    </div>";
        } else {
            $message = "<div style='direction: ltr !important;'>
                            Dear Mr/Mrs {$this->name} welcome to
                            <b>
                            BookMo!
                            </b>
                            <br/>
                            ------------------------
                            <br/>
                            username: <b>{$this->email}</b>
                            <br/>
                            password: <b>{$this->password}</b>
                            <br/>
                    </div>";
        }
        
        $config = array();
        $email_config = Services::email();
        $config["protocol"]    = "SMTP";
        // $config["SMTPHost"]    = "smtp.gmail.com";
        // $config["SMTPUser"]    = "amirhoseinh1373@gmail.com";
        // $config["SMTPPass"]    = "Am0016973178iR#";
        $config["SMTPHost"]    = "mail.bookmoapp.com";
        $config["SMTPUser"]    = "support@bookmoapp.com";
        $config["SMTPPass"]    = "MeoWjQOj&{_I";
        $config["SMTPPort"]    = 465;
        $config["SMTPTimeout"] = 60;
        $config["SMTPCrypto"]  = "ssl";
        $config["mailType"]    = "html";
        
        $email_config->initialize($config);
        
        $email_config->setTo($this->email);
        $email_config->setFrom( $config["SMTPUser"], "Support BookMo" );
        $email_config->setSubject($this->subject);
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

    /**
     * Summary.
     * if set TRUE, return data in methods
     * if FLSE return Alert and die with data
     * @var bool $CallFunction
     */
    protected $CallFunction = FALSE;

    protected function renderPageSite( string $page, array $data ) {
        return renderPage( "Site\\$page", $data, "header", "footer" );
    }

    protected function renderPageDashboard( string $page, array $data ) {
        return renderPage( "Dashboard\\$page", $data, "header", "footer" );
    }

    protected function checkFileReturn( $address, $image ) {
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
        $post->image        = $this->checkFileReturn( $post_image_url, $post->image );
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
}