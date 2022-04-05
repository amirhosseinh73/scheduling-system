<?php

namespace App\Libraries;

/**
 * Summary.
 * return persian text by key
 * @author amirhosein hasani
 */
class TextLibrary {

    /**
     * @param string $key `index` | 
     * @return string
     */
    public static function title( string $key ) {

        switch ( $key ) :

            case "index" :
                return "مرکز مشاوره و روانشناختی";

        endswitch;

    }

    /**
     * @param string $key `company_name` | 
     * @return string
     */
    public static function description( string $key ) {
        
        switch ( $key ) :

            case "company_name" :
                return "موسسه روانشناسی کیمیای مهر";

        endswitch;

    }

}