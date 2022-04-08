class Alert {
    static error( code ) {
        switch ( code ) {

            default :
                return "اطلاعات را صحیح وارد کنید.";
            case 101 :
                return "لطفا نام خود را وارد کنید.";
            case 102 :
                return "لطفا نام خانوادگی خود را وارد کنید.";
            case 103 :
                return "لطفا شماره همراه خود را صحیح وارد کنید.";
            case 104 :
                return "لطفا رمز عبور خود را حداقل 6 کاراکتر وارد کنید.";
            case 105 :
                return "تکرار رمز عبور صحیح نیست.";
        }
    }
}