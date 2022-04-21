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
                return "مرکز مشاوره روانشناختی";
            case "blog" :
                return "اخبار و مقالات";
            case "register" :
                return "ثبت نام";
            case "verify" :
                return "تایید تلفن همراه";
            case "login" :
                return "ورود به حساب کاربری";
            case "dashboard" :
                return "حساب کاربری";
            case "booking" :
            case "reservation" :
                return "رزرو نوبت";
            case "recovery_pass" :
                return "بازیابی رمز عبور";

        endswitch;

    }

    /**
     * @param string $key `company_name` | `blog` | `turn_sms`
     * @return string
     */
    public static function description( string $key = NULL ) {
        
        switch ( $key ) :

            default :
            case "company_name" :
                return "موسسه روانشناسی کیمیای مهر";
            case "blog" :
                return "جدید ترین مقالات آموزشی و اخبار موسسه روانشناسی کیمیای مهر";
            case "turn_sms":
                return "تاریخ حضور %s ساعت مراجعه: %s";

        endswitch;

    }

}