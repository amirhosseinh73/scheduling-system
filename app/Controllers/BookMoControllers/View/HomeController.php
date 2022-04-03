<?php

namespace App\Controllers\View;

use App\Controllers\ParentController;

class HomeController extends ParentController
{
    public function index()
    {
        $data = array(
            "head" => "BookMo"
        );
        return render_page( "home", $data );
    }
}
