<?php

namespace App\Controllers\Site;

use App\Controllers\ParentController;
use App\Libraries\TextLibrary;

class IndexController extends ParentController
{
    public function loadIndex() {
        $data_page = array(
            "head_title"        => TextLibrary::title( "index" ),
            "head_description"  => TextLibrary::description( "company_name" ),
        );

        return $this->renderPageSite( "index", $data_page );
    }
}
