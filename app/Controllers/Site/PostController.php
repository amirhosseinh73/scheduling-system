<?php

namespace App\Controllers\Site;

use App\Controllers\ParentController;
use App\Libraries\TextLibrary;
use App\Models\FAQModel;
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

        if ( ! $select_blog ) return redirect()->to( base_url() );

        $select_blog = $this->handlePostData( $select_blog, BLOG_URL, IMAGE_DIR_BLOG );

        $user_info = get_user_info();

        $data_page = array(
            "title_head"        => TextLibrary::title( "blog" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "blog"              => $select_blog,
            "page_name"         => "blog",
            "description"       => TextLibrary::description( "blog" ),
            "user_info"         => $user_info,
        );

        return $this->renderPageSite( "single-blog", $data_page ) ;

    }

    protected function loadPage() {
        $select_page = $this->loadPost( FALSE );
        
        if ( ! $select_page ) return redirect()->to( base_url() );

        $select_page = $this->handlePostData( $select_page, PAGE_URL, IMAGE_DIR_PAGE );

        $user_info = get_user_info();

        $data_page = array(
            "title_head"        => $select_page->title,
            "description_head"  => TextLibrary::description( "company_name" ),
            "page"              => $select_page,
            "page_name"         => "page",
            "description"       => TextLibrary::description( "page" ),
            "user_info"         => $user_info,
        );

        if ( strpos( $select_page->url, "about-us" ) ) {
            return $this->renderPageSite( "page-about", $data_page );
        } elseif( strpos( $select_page->url, "contact-us" ) ) {

            $data_page[ "metadata" ] = $this->handleMetadata( "contact_us" );
            $data_page[ "faq" ] = $this->loadFAQ();

            return $this->renderPageSite( "page-contact", $data_page );
        } else {
            return $this->renderPageSite( "page-default", $data_page );
        }
    }

    /**
     * @param bool $post_type blog as `TRUE` | page as `FALSE`
     * @return bool|object `FALSE` | `page or blog`
     */
    protected function loadPost( $post_type ) {
        $post_key = $this->secondSegment();

        if ( ! exists( $post_key ) ) return FALSE;

        $post_model = new PostModel();

        $select_post = $post_model
            ->where( "type", $post_type ) //blog is 1
            // ->where( "status", TRUE ) //draft is 0
            ->where( "publish_at <", date( "Y-m-d H:i:s" ) )
            ->where( "url", urldecode( $post_key ) )
            ->orderBy( "publish_at", "DESC" )
            ->customFirst();

        if ( ! exists( $select_post ) ) return FALSE;

        try {
            $data_update = array(
                "view" => intval( $select_post->view ) + 1
            );
            $post_model->update( $select_post->ID, $data_update );
        } catch ( \Exception $e ) {
            return FALSE;
        }

        return $select_post;
    }

    public function loadFAQ() {
        $faq_model = new FAQModel();

        $select_faq = $faq_model->orderBy( "updated_at", "DESC" )->customFindAll( FALSE, 8, 0 );

        return $select_faq;
    }

}