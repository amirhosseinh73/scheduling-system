<?php

namespace App\Controllers\Site;

use App\Controllers\ParentController;
use App\Libraries\TextLibrary;

class IndexController extends ParentController
{
    public function loadIndex() {
        $data_page = array(
            "title_head"        => TextLibrary::title( "index" ),
            "description_head"  => TextLibrary::description( "company_name" ),
        );

        return $this->renderPageSite( "index", $data_page );
    }
}
