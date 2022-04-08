<?php

namespace App\Controllers\Dashboard;

use App\Controllers\ParentController;
use App\Libraries\TextLibrary;

class LoginController extends ParentController {

    public function index() {
        $data_page = array(
            "title_head"        => TextLibrary::title( "login" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "page_name"         => "login",
        );

        return $this->renderPageSite( "login", $data_page );
    }

}