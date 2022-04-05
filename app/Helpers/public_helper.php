<?php

//defines
defined( "TOKEN_COOKIE_NAME" ) || define( "LOGIN_TOKEN_COOKIE_NAME", "Scheduling_system" );
defined( "IMAGE_DIR_PROFILE" ) || define( "IMAGE_DIR_PROFILE",       "uploads/profile/" );
defined( "IMAGE_DIR_PACKAGE" ) || define( "IMAGE_DIR_PACKAGE",       "uploads/package/" );
defined( "IMAGE_DIR_LESSON" )  || define( "IMAGE_DIR_LESSON",        "uploads/lesson/" );


//functions
function renderPage( string $page, array $data, string $header = "header", string $footer = "footer" ) {
    $header = view("Template/{$header}", $data);

    $footer = view("Template/{$footer}", $data);

    $content = view($page, $data);

    return $header . $content . $footer;
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

function _base_url(){
    return "http://192.168.1.11:2525";
}

function grade_text( int $grade ) {
    switch ( $grade ) :
        case 1:
            return "Lower Primary";
        case 2:
            return "Upper Primary";
        case 3:
            return "Lower Secondary";
        case 4:
            return "Upper Secondary";
        default:
            return "";
    endswitch;
}