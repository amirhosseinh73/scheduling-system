<?php

namespace App\Controllers\Api;

use App\Controllers\ParentController;
use App\Libraries\Alert;

class PublicController extends ParentController {
    
    /**
     * Summary.
     * Get lessons
     * @method GET
     * @return string JSON : DATA list lessons
     */
    public function Version() {
        $data_return = array(
            "version" => "1.0.0"
        );
        return Alert::Info( 305, $data_return );
    }
}