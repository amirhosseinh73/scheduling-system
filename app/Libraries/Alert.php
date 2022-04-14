<?php

namespace App\Libraries;

/**
 * Summary.
 * return Alert success|error|info message by switch case
 * @version 2.0.0
 * @author amirhosein hasani
 * @return string JSON
 */
class Alert {
    
    /**
     * Summary.
     * return Error messages
     * @param int $Code
     * @param bool $ShowCode TRUE|FALSE default is TRUE and if set FALSE not showing code of message
     * @param array|object $Data
     * @param string $BackUrl current of user url for return url 
     * @return string JSON status|code|type|message|data|back_url
     */
    public static function Error( int $code, $data = array(), string $back_url = "/", bool $show_code = FALSE ) {
        header( "Content-Type: application/json" );

        switch ( $code ) :
            default :
                $message =  "درخواست صحیح نیست!";
                break;
            case 98:
                $message = "اطلاعات را صحیح وارد کنید.";
                break;
            case 99:
                $message = "ورودی ها اشتباه است.";
                break;
            case 100:
                $message = "متاسفانه عملیات انجام نشد!";
                break;
            case 101 :
                $message = "لطفا نام خود را وارد کنید.";
                break;
            case 102 :
                $message = "لطفا نام خانوادگی خود را وارد کنید.";
                break;
            case 103 :
                $message = "لطفا شماره همراه خود را صحیح وارد کنید.";
                break;
            case 104 :
                $message = "لطفا رمز عبور خود را حداقل 6 کاراکتر وارد کنید.";
                break;
            case 105 :
                $message = "تکرار رمز عبور صحیح نیست.";
                break;
            case 106 :
                $message = "نوع کاربری خود را مشخص گنید.";
                break;
            case 107 :
                $message = "کد وارد شده صحیح نیست!";
                break;
            case 108 :
                $message = "نام کاربری در سیستم وجود ندارد.";
                break;
            case 109 :
                $message = "حساب شما غیر فعال شده است! با ما تماس بگیرید.";
                break;
            case 110 :
                $message = "رمز عبور اشتباه است!";
                break;
            case 111 :
                $message = "ایمیل خود را صحیح وارد کنید!";
                break;
        endswitch;

        if ( $show_code ) :
            $message = "Error {$code}: {$message}";
        endif;

        echo json_encode_unicode( array(
            "status"     => "failed",
            "type"       => "danger",
            "type_2"     => "error",
            "code"       => $code,
            "message"    => $message,
            "data"       => $data,
            "return_url" => $back_url,
        ) );

        die;
    }

    /**
     * Summary.
     * return Success messages
     * @param int $Code
     * @param bool $ShowCode TRUE|FALSE default is TRUE and if set FALSE not showing code of message
     * @param array|object $Data
     * @param string $BackUrl current of user url for return url 
     * @return string JSON status|code|type|message|data|back_url
     */
    public static function Success( int $code, $data = array(), string $back_url = "/", bool $show_code = FALSE ) {
        header( "Content-Type: application/json" );

        switch ( $code ) :
            case 200:
                $message = "عملیات با موفقیت انجام شد.";
                break;
            case 201:
                $message = "ثبت نام شما با موفقیت انجام شد. \n خوش آمدید! ";
                break;
        endswitch;

        if ( $show_code ) :
            $message = "Message {$code}: {$message}";
        endif;

        echo json_encode_unicode( array(
            "status"     => "success",
            "type"       => "success",
            "type_2"     => "success",
            "code"       => $code,
            "message"    => $message,
            "data"       => $data,
            "return_url" => $back_url,
        ) );
        
        die;
    }

    /**
     * Summary.
     * return Info messages
     * @param int $Code
     * @param bool $ShowCode TRUE|FALSE default is TRUE and if set FALSE not showing code of message
     * @param array|object $Data
     * @param string $BackUrl current of user url for return url 
     * @return string JSON status|code|type|message|data|back_url
     */
    public static function Info( int $code, $data = array(), string $back_url = "/", bool $show_code = FALSE ) {
        header( "Content-Type: application/json" );

        switch ( $code ) :
            default:
                $message = "موردی پیدا نشد!";
                break;
            case 300:
                $message = "آیا از ادامه عملیات اطمینان دارید؟";
                break;
            case 301:
                $message = "نام کاربری شما قبلا در سامانه ثبت شده است! لطفا وارد سیستم شوید یا با پشتیبانی تماس بگیرید.";
                break;
            case 302:
                $message = "لطفا شماره همراه خود را تایید کنید.";
                break;
            
        endswitch;

        if ( $show_code ) :
            $message = "Alert {$code}: {$message}";
        endif;

        echo json_encode_unicode( array(
            "status"     => "info",
            "type"       => "info",
            "type_2"     => "info",
            "code"       => $code,
            "message"    => $message,
            "data"       => $data,
            "return_url" => $back_url,
        ) );
        
        die;
    }
}