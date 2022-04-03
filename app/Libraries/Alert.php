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
    public static function Error( int $Code, $Data = array(), string $BackUrl = "/", bool $ShowCode = FALSE ) {
        header( "Content-Type: application/json" );

        switch ( $Code ) :
            case 100:
            default:
                $message = "Operation Failed!";
                break;
            case -1:
                $message = "Invalid Request!";
                break;
            case 101:
                $message = "Please check your login!";
                break;
            case 102:
                $message = "Please check your inputs!";
                break;
            case 110:
                $message = "Please enter your first name!";
                break;
            case 111:
                $message = "Please enter valid email address!";
                break;
            case 112:
                $message = "Please enter your password, Minimum Length is 6!";
                break;
            case 113:
                $message = "Username already exists!";
                break;
            case 114:
                $message = "Your account has been banned, Please contact us for support!";
                break;
            case 115:
                $message = "Username not Found!";
                break;
            case 116:
                $message = "Incorrect Password!";
                break;
            case 117:
                $message = "Server can not send email right now! please try again later.";
                break;
            case 118:
                $message = "Wrong old password!";
                break;
            case 119:
                $message = "Confirm password not match!";
                break;
            case 120:
                $message = "Incorrect grade!";
                break;
            case 121:
                $message = "Incorrect package id!";
                break;
            case 122:
                $message = "User not found!";
                break;
            case 123:
                $message = "Please enter valid license code!";
                break;
            case 124:
                $message = "Maximum use of license code reached!";
                break;
            case 125:
                $message = "This license isn't available to you!";
                break;
            case 126:
                $message = "Please enter your last name!";
                break;

            //admin alerts persian
            case -100:
                $message = "متاسفانه عملیات انجام نشد!";
                break;
            case -101:
                $message = "لطفا عنوان را وارد کنید.";
                break;
            case -102:
                $message = "لطفا پایه را به درستی انتخاب کنید.";
                break;
            case -103:
                $message = "لطفا قیمت را مشخص کنید.";
                break;
            case -104:
                $message = "مبلغ تخفیف نباید بیشتر از قیمت اصلی باشد.";
                break;
            case -105:
                $message = "ورودی ها اشتباه است.";
                break;
            case -106:
                $message = "لطفا پکیج مربوطه را به درستی انتخاب کنید.";
                break;
            case -107:
                $message = "لطفا سرفصل مربوطه را به درستی انتخاب کنید.";
                break;
            case -108:
                $message = "لطفا لینک درس را وارد کنید.";
                break;
            case -109:
                $message = "کد مجوز باید بین 0 تا 12 کاراکتر باشد.";
                break;
            case -110:
                $message = "محدودیت تعداد استفاده را مشخص کنید.";
                break;
            case -111:
                $message = "وضعیت فعال بودن یا غیر فعال بودن را مشخص کنید.";
                break;
            case -112:
                $message = "حداقل یک پکیج برای این مجوز تعیین کنید.";
                break;
            case -113:
                $message = "کد مجوز تکراری است، لطفا یک کد دیگر انتخاب کنید یا آن را تغییر ندهید.";
                break;
            case -114:
                $message = "لطفا کاربران را درست انتخاب کنید.";
                break;
            case -115:
                $message = "لطفا نام را وارد کنید.";
                break;
            case -116:
                $message = "لطفا ایمیل را به درستی وارد کنید.";
                break;
            case -117:
                $message = "برای تغییر رمز حداقل 6 کاراکتر وارد کنید.";
                break;
            case -118:
                $message = "ایمیل وارد شده قبلا برای یکی از کاربران استفاده شده است.";
                break;
            case -119:
                $message = "رمز عبور حداقل باید 6 کاراکتر باشد.";
                break;
            case -120:
                $message = "لطفا نام خانوادگی را وارد کنید.";
                break;
        endswitch;

        if ( $ShowCode ) :
            $message = "Error {$Code}: {$message}";
        endif;

        echo json_encode_unicode( array(
            "status"     => "failed",
            "type"       => "danger",
            "code"       => $Code,
            "message"    => $message,
            "data"       => $Data,
            "return_url" => $BackUrl,
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
    public static function Success( int $Code, $Data = array(), string $BackUrl = "/", bool $ShowCode = FALSE ) {
        header( "Content-Type: application/json" );

        switch ( $Code ) :
            case 200:
            default:
                $message = "Operation Complete!";
                break;
            case 201:
                $message = "Password Sent to your email!";
                break;
            case 202:
                $message = "Your password changed successfully!";
                break;

            //admin alerts persian
            case -200:
                $message = "عملیات با موفقیت انجام شد.";
                break;
            case -201:
                $message = "پکیج با موفقیت اضافه شد.";
                break;
            case -202:
                $message = "پکیج با موفقیت حذف شد.";
                break;
            case -203:
                $message = "پکیج با موفقیت ویرایش شد.";
                break;
        endswitch;

        if ( $ShowCode ) :
            $message = "Message {$Code}: {$message}";
        endif;

        echo json_encode_unicode( array(
            "status"     => "success",
            "type"       => "success",
            "code"       => $Code,
            "message"    => $message,
            "data"       => $Data,
            "return_url" => $BackUrl,
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
    public static function Info( int $Code, $Data = array(), string $BackUrl = "/", bool $ShowCode = FALSE ) {
        header( "Content-Type: application/json" );

        switch ( $Code ) :
            case 300:
                $message = "Are You Sure?";
            case 301:
                $message = "No package Found.";
                break;
            case 302:
                $message = "No lesson Found.";
                break;
            case 303:
                $message = "You have used this code before.";
                break;
            case 304:
                $message = "This code does not have a package available for you.";
                break;
            case 305:
                $message = "This is the Last Version.";
                break;
            default:
                $message = "Nothing Found.";
                break;
        endswitch;

        if ( $ShowCode ) :
            $message = "Alert {$Code}: {$message}";
        endif;

        echo json_encode_unicode( array(
            "status"     => "info",
            "type"       => "info",
            "code"       => $Code,
            "message"    => $message,
            "data"       => $Data,
            "return_url" => $BackUrl,
        ) );
        
        die;
    }
}