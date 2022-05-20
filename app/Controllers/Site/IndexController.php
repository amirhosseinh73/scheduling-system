<?php

namespace App\Controllers\Site;

use App\Controllers\ParentController;
use App\Libraries\TextLibrary;
use App\Models\PostModel;

class IndexController extends ParentController
{
    public function index() {

        $user_info = get_user_info();

        $post_controller = new PostController();
        
        $data_page = array(
            "title_head"        => TextLibrary::title( "index" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "blog"              => $post_controller->blogData( 4 ),
            "page_name"         => "index",
            "user_info"         => $user_info,
        );

        return $this->renderPageSite( "index", $data_page );
    }
}
