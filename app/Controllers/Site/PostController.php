<?php

namespace App\Controllers\Site;

use App\Controllers\ParentController;
use App\Libraries\TextLibrary;
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

        $select_blog = $this->loadPost( TRUE );

        $select_blog = $this->handlePostData( $select_blog );

        $data_page = array(
            "title_head"        => TextLibrary::title( "blog" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "blog"              => $select_blog,
            "page_name"         => "blog",
            "description"       => TextLibrary::description( "blog" ),
        );

        return $this->renderPageSite( "single-blog", $data_page ) ;

    }

    protected function loadPage() {

    }

    /**
     * @param bool $post_type blog as `TRUE` | page as `FALSE`
     */
    protected function loadPost( $post_type ) {
        $post_key = $this->secondSegment();

        if ( ! exists( $post_key ) ) return redirect()->to( base_url() );

        $post_model = new PostModel();

        $select_blog = $post_model
            ->where( "type", $post_type ) //blog is 1
            ->where( "status", TRUE ) //draft is 0
            ->where( "publish_at <", date( "Y-m-d H:i:s" ) )
            ->where( "url", urldecode( $post_key ) )
            ->orderBy( "publish_at", "DESC" )
            ->first();

        if ( ! exists( $select_blog ) ) return redirect()->to( base_url() );

        try {
            $data_update = array(
                "view" => intval( $select_blog->view ) + 1
            );
            $post_model->update( $select_blog->ID, $data_update );
        } catch ( \Exception $e ) {
            return redirect()->to( base_url() );
        }

        return $select_blog;
    }

}