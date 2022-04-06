<?php

namespace App\Libraries;

/**
 * Summary.
 * return persian text by key
 * @author amirhosein hasani
 */
class TextLibrary {

    /**
     * @param string $key `index` | `blog`
     * @return string
     */
    public static function title( string $key = NULL ) {

        switch ( $key ) :

            default :
            case "index" :
                return "مرکز مشاوره و روانشناختی";
            case "blog" :
                return "اخبار و مقالات";

        endswitch;

    }

    /**
     * @param string $key `company_name` | 
     * @return string
     */
    public static function description( string $key = NULL ) {
        
        switch ( $key ) :

            default :
            case "company_name" :
                return "موسسه روانشناسی کیمیای مهر";
            case "blog" :
                return "جدید ترین مقالات آموزشی و اخبار موسسه روانشناسی کیمیای مهر";

        endswitch;

    }

}