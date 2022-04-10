<?php

namespace App\Controllers\Site;

use App\Controllers\ParentController;
use App\Controllers\TokenController;
use App\Libraries\TextLibrary;
use App\Models\PostModel;

class IndexController extends ParentController
{
    public function index() {

        $user_info = TokenController::UserData( LOGIN_TOKEN_COOKIE_NAME );
        
        $data_page = array(
            "title_head"        => TextLibrary::title( "index" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "blog"              => $this->blogData( 4 ),
            "page_name"         => "index",
            "user_info"         => $user_info,
        );

        return $this->renderPageSite( "index", $data_page );
    }

    private function blogData( $limit = 4 ) {
        $post_model = new PostModel();

        $select_blog = $post_model
            ->where( "type", TRUE ) //blog is 1
            // ->where( "status", TRUE ) //draft is 0
            ->where( "publish_at <", date( "Y-m-d H:i:s" ) )
            ->orderBy( "publish_at", "DESC" )
            ->customFindAll( FALSE, $limit, 0 );

        foreach( $select_blog as $blog ) :
            $blog = $this->handlePostData( $blog, BLOG_URL, IMAGE_DIR_BLOG );
        endforeach;

        return (object)array(
            "title_head" => TextLibrary::title( "blog" ),
            "data"       => $select_blog,
        );
    }
}
