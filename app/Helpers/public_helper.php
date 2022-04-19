<?php

//defines

use App\Controllers\TokenController;
use App\Libraries\SmsIrUltraFastSend;

defined( "TOKEN_COOKIE_NAME" )      || define( "LOGIN_TOKEN_COOKIE_NAME", "Scheduling_system" );
defined( "KEY_CHECK_RESPONSE" )     || define( "KEY_CHECK_RESPONSE"     , "request_response_session" );
defined( "KEY_VALUE_SESSION" )      || define( "KEY_VALUE_SESSION"      , "needed_key_in_session" );

defined( "PAYMENT_MERCHANT_ID" )    || define( "PAYMENT_MERCHANT_ID"    , "zibal" );
defined( "PAYMENT_CALLBACK_URL" )   || define( "PAYMENT_CALLBACK_URL"   , base_url( "callback-reservation" ) );

defined( "BLOG_URL" )               || define( "BLOG_URL"               , "/blog/" );
defined( "PAGE_URL" )               || define( "PAGE_URL"               , "/page/" );

defined( "IMAGE_DIR_PROFILE" )      || define( "IMAGE_DIR_PROFILE"      , "/uploads/profile/" );
defined( "IMAGE_DIR_BLOG" )         || define( "IMAGE_DIR_BLOG"         , "/uploads/blog/" );
defined( "IMAGE_DIR_PAGE" )         || define( "IMAGE_DIR_PAGE"         , "/uploads/page/" );
defined( "IMAGE_DEFAULT" )          || define( "IMAGE_DEFAULT"          , "/uploads/default.jpg" );
defined( "IMAGE_DEFAULT_MALE" )     || define( "IMAGE_DEFAULT_MALE"     , "/uploads/default-male.jpg" );
defined( "IMAGE_DEFAULT_FEMALE" )   || define( "IMAGE_DEFAULT_FEMALE"   , "/uploads/default-female.jpg" );


//functions
/**
 * @param string $page `index` | `contact-us`
 * @param array|object $data
 * @param ?string $header
 * @param ?string $footer
 */
function render_page( string $page, array $data, string $header = NULL, string $footer = NULL ) {
    if( $header ) $header = view("Template/{$header}", $data);

    if( $footer ) $footer = view("Template/{$footer}", $data);

    $content = view($page, $data);

    return $header . $content . $footer;
}

function str_split_unicode($str, $length = 0) {
    if ($length > 0) {
        $ret = array();
        $len = mb_strlen($str, "UTF-8");
        for ($i = 0; $i < $len; $i += $length) {
            $ret[] = mb_substr($str, $i, $length, "UTF-8");
        }
        return $ret;
    }
    return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
}

/**
 * Summary.
 * return random string with number or only number
 * @author amirhosein hasani
 * @param int $length 1 to 112 if string
 * @param int $length 1 to 108 if only number
 * @param bool $only_number TRUE only numer | FALSE string
 * @return string $rand_string
 */
function custom_random_string( int $length, bool $only_number = FALSE ) {
    //max = 112
    $permitted_chars = '123456789ABCDEFGHKMNPRSTWXYZ123456789ABCDEFGHKMNPRSTWXYZ123456789ABCDEFGHKMNPRSTWXYZ123456789ABCDEFGHKMNPRSTWXYZ';
    if ($only_number) {
        //max = 108
        $permitted_chars = '123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789';
    }
    $rand_string = substr(str_shuffle($permitted_chars), 0, $length);
    return (string) $rand_string;
}

/**
 * Summary.
 * check if string is base64 or not
 * @author amirhosein hasani
 * @param string $string
 * @return bool
 */
function is_base64( string $string ) {
    if (strpos($string, 'base64') !== false && base64_encode(base64_decode(explode('base64,', $string)[1], true)) == explode('base64,', $string)[1]) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function is_json($string) {
   json_decode($string);
   return json_last_error() === JSON_ERROR_NONE;
}

/**
 * Summary.
 * is item declared or not
 * @author amirhosein hasani
 * @param mixed $item
 * @return bool
 */
function exists( $item ) {
    return (bool) ( isset( $item ) && ! empty( $item ) );
}

/**
 * Summary.
 * var_dump and die together
 * @author amirhosein hasani
 * @param mixed $item
 */
function _dump( $item ){
    echo "<pre>";
    var_dump( $item );
    die;
}

/**
 * Summary.
 * json_encode and die together
 * @author amirhosein hasani
 * @param mixed $item
 */
function _json_die( $item ) {
    header( "Content-Type: application/json" );
    echo json_encode( $item, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
    die;
}

/**
 * Summary.
 * check if password conditions is valid or not
 * @author amirhosein hasani
 * @param string $string
 * @return bool
 */
function validate_password( string $password ) {
    if ( strlen( $password ) < 6) {
        return FALSE;
    } else {
        return TRUE;
    }
}

/**
 * Summary.
 * make floatval number of decimals after .
 * 
 * Description.
 * toFixed in javascript
 * 
 * @author amirhosein hasani
 * @param float $number
 * @param int $decimals number of after .
 * @return float $number
 */
function toFixed( float $number, int $decimals = 1 ) {
    $expo   = pow(10,$decimals);
    $number = intval( $number * $expo ) / $expo;

    return (float) $number;
}

/**
 * Summary.
 * add a log in file in public in JSON format
 * 
 * @author amirhosein hasani
 * @param array $data
 * @param string $name name of log file
 * @return nothing
 */
function logFile( array $data, string $name = "log.json") {
    $log = fopen(FCPATH . $name, "w+");
    fwrite($log, json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    fclose($log);
}

/**
 * Summary.
 * json_encode in unicode format and ignore slashes
 * 
 * @author amirhosein hasani
 * @param array $data
 * @return string $JSON_UNICODE_SLASHES
 */
function json_encode_unicode( array $data ) {
    return (string) json_encode( $data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
}

function save_request_files( $file, $address = IMAGE_DIR_PROFILE ) {
    $saved_file_name = "";
    if ($file->isValid() && !$file->hasMoved()) {
        //profile image size
        // $file_size = $file->getSize();
        $random_name = $file->getRandomName();
        $file->move(FCPATH . $address, $random_name);
        $saved_file_name = $random_name;
    }

    return $saved_file_name;
}

/**
 * @return object `time` & `date`
 */
function gregorianDatetimeToJalali( $datetime ) {
    $datetime = explode( " ", $datetime );
    $time     = $datetime[ count( $datetime ) - 1 ];
    $time     = explode( ":", $time );
    $time     = $time[ 0 ] . ":" . $time[ 1 ];
    $date     = explode( "-", $datetime[ 0 ] );
    $date     = gregorian_to_jalali( $date[ 0 ], $date[ 1 ], $date[ 2 ], " / " );

    return ( object ) [
        "time" => $time,
        "date" => $date,
    ];
}

function sms_ir_ultra_fast_send_service( $mobile, $param, $value ) {
    try {
        date_default_timezone_set("Asia/Tehran");

        // your sms.ir panel configuration
        $APIKey = "646a2a1a76f4451355e3745";
        $SecretKey = "amirhoseinh730016973178";

        $APIURL = "https://ws.sms.ir/";

        switch ( $param ) {
            case "VerificationCode":
                $template_ID = "64651";
                break;
            case "Password":
                $template_ID = "64975";
                break;
        }

        // message data
        $data = array(
            "ParameterArray" => array(
                array(
                    "Parameter" => "$param",
                    "ParameterValue" => $value
                ),
            ),
            "Mobile" => $mobile,
            "TemplateId" => $template_ID,
        );
        $SmsIR_UltraFastSend = new SmsIrUltraFastSend($APIKey, $SecretKey, $APIURL);
        $UltraFastSend = $SmsIR_UltraFastSend->ultraFastSend($data);

        return $UltraFastSend;
    } catch ( \Exception $e ) {
        echo 'Error UltraFastSend : ' . $e->getMessage();
    }
}

function gender_text( $user_info ) {
    if ( is_null( $user_info->gender ) ) :
        return "آقای / خانم ";
    elseif ( $user_info->gender ) :
        return "آقای ";
    elseif ( ! $user_info->gender ) :
        return "خانم ";
    endif;

    return "";
}

function gender_handler( $user_info ) {
    if ( is_null( $user_info->gender ) ) :
        return "default-male.jpg";
    elseif ( $user_info->gender ) :
        return "default-male.jpg";
    elseif ( ! $user_info->gender ) :
        return "default-female.jpg";
    endif;

    return "default-male.jpg";
}
function type_user_text( $user_info ) {
    if ( $user_info->type_user ) :
        return "کاربر گرامی، ";
    elseif ( ! $user_info->type_user ) :
        return "پزشک گرامی، ";
    endif;

    return "";
}

function handle_user_info( $user_info ) {

    $user_info->status    = !!$user_info->status;
    $user_info->type_user = !!$user_info->type_user;
    $user_info->is_admin  = !!$user_info->is_admin;
    $user_info->gender    = is_null( $user_info->gender ) ? $user_info->gender : !!$user_info->gender;
    $user_info->image     = ( exists( $user_info->image ) ? base_url( IMAGE_DIR_PROFILE . $user_info->image ) : base_url( IMAGE_DIR_PROFILE . gender_handler( $user_info ) ) );

    return $user_info;
}

function get_day_of_week( $date = "now" ) {
    $day_of_week = new DateTime( $date );
    $day_of_week = intval( $day_of_week->format('w') );

    switch ( $day_of_week ) {
        case 0:
            return "یکشنبه";
        case 1:
            return "دوشنبه";
        case 2:
            return "سه شنبه";
        case 3:
            return "چهارشنبه";
        case 4:
            return "پنج شنبه";
        case 5:
            return "جمعه";
        case 6:
            return "شنبه";
    }
}

function get_user_info() {
    $user_info = TokenController::UserData( LOGIN_TOKEN_COOKIE_NAME );

    $user_info = handle_user_info( $user_info );

    return $user_info;
}