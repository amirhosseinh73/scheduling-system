<?php

namespace App\Filters;

use App\Controllers\TokenController;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class IsLogin implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null)
    {
        helper( "public" );
        //check if user is login going to dashboard and not going to login page
        //and is admin
        $user_info = TokenController::UserData( LOGIN_TOKEN_COOKIE_NAME );

        if ( exists( $user_info ) && exists( $user_info->ID ) && $user_info->is_admin ) return redirect()->to( base_url( "admin/dashboard" ) );

        return TRUE;
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}