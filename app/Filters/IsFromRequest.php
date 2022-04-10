<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * this filter check user type url or redirect to this page with my response
 */
class IsFromRequest implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null)
    {
        helper( "public" );

        $session = session();
        $check = $session->get( KEY_CHECK_RESPONSE );

        if ( ! exists( $check ) ) return redirect()->to( base_url( "/register" ) );

        $session->remove( KEY_CHECK_RESPONSE );

        return TRUE;
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}