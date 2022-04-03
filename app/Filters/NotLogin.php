<?php

namespace App\Filters;

use App\Controllers\TokenController;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class NotLogin implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null)
    {
        helper( "public" );
        //check if user not login going to login page and not going to dashboard page
        //and is not admin
        $user_info = TokenController::UserData( LOGIN_TOKEN_COOKIE_NAME ); // use for web

        if ( ! $user_info || ! exists( $user_info->ID ) || !!!$user_info->is_admin ) return redirect()->to( base_url( "admin/login" ) );

        return TRUE;
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}