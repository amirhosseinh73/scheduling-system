<?php

namespace App\Controllers\Site;

use App\Controllers\ParentController;
use App\Models\PostModel;

class PostController extends ParentController {

    public function index() {

        $post_type = $this->firstSegment();

        // if ( $post_type !== "blog" && $post_type !== "page" ) return redirect()->to( base_url() );

        if ( $post_type === "blog" ) return $this->loadBlog();
        elseif( $post_type === "page" ) return $this->loadPage();

        return redirect()->to( base_url() );
    }

    protected function loadBlog() {

        $post_key = $this->secondSegment();

        if ( ! exists( $post_key ) ) return redirect()->to( base_url() );

        $post_model = new PostModel();

        $select_blog = $post_model
            ->where( "type", TRUE ) //blog is 1
            ->where( "status", TRUE ) //draft is 0
            ->where( "publish_at <", date( "Y-m-d H:i:s" ) )
            ->where( "url", $post_key )
            ->orderBy( "publish_at", "DESC" )
            ->first();

        if ( ! exists( $select_blog ) ) return redirect()->to( base_url() );

        $data_page = array(
            "title_head"        => "",
            "description_head"  => "",
            "blog"              => $select_blog,
        );

        return $this->renderPageSite( "single-blog", $data_page ) ;

    }

    protected function loadPage() {

    }

}