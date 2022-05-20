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

        if( $post_type === "page" ) return $this->loadPage();
        elseif ( $post_type === "blog" ) return $this->loadBlog();

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
        switch ( TRUE ) :
            case strpos( $select_page->url, "about-us" ):
                return $this->renderPageSite( "page-about", $data_page );
            case strpos( $select_page->url, "contact-us" ):
                $data_page[ "metadata" ] = $this->handleMetadata( "contact_us" );
                $data_page[ "faq" ] = $this->loadFAQ();
    
                return $this->renderPageSite( "page-contact", $data_page );
            case strpos( $select_page->url, "blog" ):
                $data_page[ "blog" ] = $this->blogData( 16 );
                return $this->renderPageSite( "page-blog-category", $data_page );
            default:
                if ( strpos( $select_page->url, "faq" ) ) {
                    $data_page[ "faq" ] = $this->loadFAQ();
                } elseif ( strpos( $select_page->url, "gallery" ) ) {
                    $data_page[ "gallery" ] = $this->loadGallery();
                    $data_page[ "page_name_2" ] = "gallery";
                }
                return $this->renderPageSite( "page-default", $data_page );
        endswitch;
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

    public function loadFAQ( $limit = 8 ) {
        $faq_model = new FAQModel();

        $select_faq = $faq_model->orderBy( "updated_at", "DESC" )->customFindAll( FALSE, $limit, 0 );

        return $select_faq;
    }

    public function blogData( $limit = 4 ) {
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

    public function loadGallery() {
        $path  = FCPATH . "uploads/gallery";
        $files = scandir( $path );
        $files = array_diff( scandir( $path ), array( '.' , '..' ) );

        $thumbnails = array();
        $images = array();
        foreach( $files as $file ) {
            $url = base_url( "uploads/gallery/" . $file );

            if ( strpos( $file, "tn" ) ) $thumbnails[] = $url;
            else $images[] = $url;
        }
        
        return [
            "thumbnails" => $thumbnails,
            "images"     => $images,
        ];
    }

}