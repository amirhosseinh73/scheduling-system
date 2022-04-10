<?php


namespace App\Controllers;

use App\Models\TokenModel;
use App\Models\UserModel;

/**
 * Summary.
 * Create COOKIE and save token and other data to DB
 * @author amirhosein hasani
*/
class TokenController extends ParentController
{
    /**
     * Summary.
     * create token and other data needed for store in DB and COOKIE
     * 
     * @param int $time is a number in second
     * @return object $data status|token|ip|user_agent|expire by time
     */
    public static function Create(int $time = DAY)
    {
        try {
            $token = md5( custom_random_string( 24 ) . time() . '1373' );

            switch ( $time ) :
                default:
                case DAY :
                    $days = 1;
                    break;
                case MONTH :
                    $days = 30;
                    break;
                case YEAR :
                    $days = 365;
                    break;
            endswitch;

            $data = array(
                "status"     => "success",
                "token"      => $token,
                "ip_address" => $_SERVER["REMOTE_ADDR"], // $this->request->getIPAddress()
                "user_agent" => $_SERVER["HTTP_USER_AGENT"], // $this->request->getUserAgent()
                "expire_at"  => date( "Y-m-d H:i:s" , strtotime( "+{$days} days", time() ) ),
            );
        } catch (\Exception $exception) {
            $data = array(
                "status" => "failed",
                "data"   => $exception,
            );
        }

        return (object)$data;
    }

    /**
     * Summary.
     * insert token in DB and save token in COOKIE by time and COOKIE Name
     * @param string $session_cookie_name Name of token or COOKIE
     * @param string $username username of user email|nat_code
     * @param int $time DAY|MONTH|YEAR
     * @return bool|array FALSE|userdata
     */
    public static function Insert( string $session_cookie_name, string $username, int $time = DAY)
    {
        $create_token = self::Create( $time );
        if ($create_token->status !== "success") return FALSE;
        $token_model = new TokenModel();
        $user_model  = new UserModel();
        $select_user = $user_model
            ->where( "username", $username )
            ->CustomFirst();

        if ( ! exists( $select_user ) ) return FALSE;

        $data_update_user = array(
            'token'      => $create_token->token,
            'last_login_at' => date( "Y-m-d H:i:s", time() ),
        );

        $data_insert_token = array(
            "token"      => $create_token->token,
            "ip_address" => $create_token->ip_address,
            "user_agent" => $create_token->user_agent,
            "expire_at"  => $create_token->expire_at,
        );
        try {

            $token_model->insert( $data_insert_token );
            $user_model->update( $select_user->ID, $data_update_user );

            self::Unset( LOGIN_TOKEN_COOKIE_NAME );
            setcookie( $session_cookie_name, $create_token->token, time() + $time, '/' );

            $data_return = array_merge( (array)$select_user, $data_update_user );

            return $data_return;
        } catch (\Exception $exception) {
            logFile([$exception], "log/except_login_" . time() . ".json");
            return FALSE;
        }

    }

    /**
     * Summary.
     * Get token from COOKIE and check with DB for exist and expire
     * @param string $session_cookie_name Name of token or COOKIE
     * @return bool|string Token User
     */
    public static function Get( string $session_cookie_name )
    {
        $token_model = new TokenModel();

        if ( ! exists( $_COOKIE[$session_cookie_name] ) ) return FALSE;

        $cookie_value = $_COOKIE[$session_cookie_name];
        $get_token = $token_model
            ->where( "token", $cookie_value)
            ->where( "expire_at >", date("Y-m-d H:i:s", time() ) )
            ->first();
        if ( exists( $get_token ) ) {
            //return token
            return $get_token->token;
        } else {
            //has cookie and expired session date
            self::Unset( $session_cookie_name );
        }

        return FALSE;
    }

    /**
     * Summary.
     * Get token from COOKIE and check with DB for exist and expire
     * @param string $session_cookie_name Name of token or COOKIE
     * @param string $token use for app, get token from app
     * @return bool|object UserData
     */
    public static function UserData( string $session_cookie_name )
    {
        $token = self::Get( $session_cookie_name );

        if ( ! exists( $token )) return FALSE;

        $user_model = new UserModel();

        $select_user = $user_model
            ->where( 'token', $token )
            ->CustomFirst();

        if ( exists( $select_user ) ) {
            return $select_user;
        }

        return FALSE;
    }

    /**
     * Summary.
     * Remove token from COOKIE and DB for logout
     * @param string $session_cookie_name Name of token or COOKIE
     * @return bool TRUE
     */
    public static function Unset( string $session_cookie_name )
    {
        if ( ! exists( $_COOKIE[$session_cookie_name] ) ) return FALSE;
        $token_model = new TokenModel();

        $cookie_value = $_COOKIE[$session_cookie_name];

        $get_token = $token_model
            ->select( array(
                "ID"
            ) )
            ->where( "token", $cookie_value )
            ->first();

        if ( exists( $get_token ) ) $token_model->delete( $get_token->ID );

        setcookie( $session_cookie_name, '', '', '/' );

        return TRUE;
    }
}