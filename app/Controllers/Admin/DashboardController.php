<?php

namespace App\Controllers\Admin;

use App\Controllers\ParentController;

class DashboardController extends ParentController {
    public function index() {
        $user_info = $this->CheckLogin();

        $data = array(
            "head" => "Admin Dashboard",
            "css"  => array(
                "dashboard"
            ),
            "js"   => array(
                "dashboard"
            ),
            "user_info" => $user_info,
            "page_title" => "داشبورد",
            "page_description" => "به داشبورد بوک مو خوش آمدید",
        );
        return render_page_admin( "page/dashboard", $data );
    }
}