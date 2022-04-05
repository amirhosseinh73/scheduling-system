<?php

namespace App\Controllers\Site;

use App\Controllers\ParentController;
use App\Libraries\TextLibrary;
use App\Models\PostModel;

class IndexController extends ParentController
{
    public function loadIndex() {

        $data_page = array(
            "title_head"        => TextLibrary::title( "index" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "blog"              => $this->blogData(),
        );

        return $this->renderPageSite( "index", $data_page );
    }

    private function blogData() {
        $post_model = new PostModel();

        $select_blog = $post_model
            ->where( "type", TRUE ) //blog is 1
            ->where( "status", TRUE ) //draft is 0
            ->where( "publish_at <", date( "Y-m-d H:i:s" ) )
            ->orderBy( "publish_at", "DESC" )
            ->findAll();

        foreach( $select_blog as $blog ) :
            $blog->url          = base_url( BLOG_URL . $blog->url );
            $blog->image        = $this->checkFileReturn( IMAGE_DIR_BLOG, $blog->image );
            $blog->excerpt      = $blog->excerpt ?: str_split_unicode( $blog->content, 150 )[ 0 ] . "...";
            $blog->publish_at   = gregorianDatetimeToJalali( $blog->publish_at );
        endforeach;

        return (object)array(
            "title_head" => TextLibrary::title( "blog" ),
            "data"       => $select_blog,
        );
    }
}
