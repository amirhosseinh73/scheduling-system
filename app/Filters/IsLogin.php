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
        //check if user not login going to login page and not going to dashboard page
        //and is not admin
        $user_info = TokenController::UserData( LOGIN_TOKEN_COOKIE_NAME ); // use for web

        //|| !!!$user_info->is_admin
        if ( ! $user_info || ! exists( $user_info->ID ) ) return redirect()->to( base_url( "/login" ) );

        return TRUE;
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}