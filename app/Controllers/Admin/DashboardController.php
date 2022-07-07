<?php

namespace App\Controllers\Admin;

use App\Controllers\ParentController;
use App\Libraries\TextLibrary;

class DashboardController extends ParentController {
    public function index() {
        $user_info = get_user_info();

        $data_page = array(
            "title_head"        => TextLibrary::title( "index" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "page_name"         => "dashboard",
            "user_info"         => $user_info,
        );

        return render_page_admin( "dashboard", $data_page, "header", "footer" );
    }
}