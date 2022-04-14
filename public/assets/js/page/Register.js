class Register {
    static run = () => {
        const register = new Register();

        register.submit();
        register.submitVerify();
    }

    submit() {
        const register_form = document.getElementById( "register_form" );
        if ( ! register_form ) return;
        register_form.addEventListener( "submit", ( e ) => {
            e.preventDefault();

            if ( register_form.querySelector( ".alert" ) ) {
                register_form.querySelector( ".alert" ).remove();
            }

            const firstname = this.validateFirstname();
            if ( ! firstname ) return;

            const lastname = this.validateLastname();
            if ( ! lastname ) return;

            const mobile = this.validateMobile();
            if ( ! mobile ) return;

            const type_user = this.validateTypeUser();
            if ( ! type_user ) return;

            const fetch_data = {
                method: "post",
                data: {
                    firstname   : firstname,
                    lastname    : lastname,
                    mobile      : mobile,
                    type_user   : type_user,
                }
            };

            ajax_fetch( route.register_submit, this.stepVerifyMobile, fetch_data );
        } );
    }

    validateFirstname() {

        const register_form     = document.getElementById( "register_form" );
        const first_name        = document.getElementById( "first_name" ).value;

        if ( first_name.length < 2 ) {
            register_form.insertAdjacentHTML( "afterbegin", alert_html_rtl( "danger", Alert.error( 101 ) ) );
            return false;
        }

        return first_name;
    }

    validateLastname() {

        const register_form     = document.getElementById( "register_form" );
        const last_name         = document.getElementById( "last_name" ).value;

        if ( last_name.length < 2 ) {
            register_form.insertAdjacentHTML( "afterbegin", alert_html_rtl( "danger", Alert.error( 102 ) ) );
            return false;
        }

        return last_name;
    }

    validateMobile() {

        const register_form     = document.getElementById( "register_form" );
        const mobile            = document.getElementById( "mobile" ).value;

        if ( mobile.length !== 11 || +mobile[ 0 ] !== 0 || +mobile[ 1 ] !== 9 ) {
            register_form.insertAdjacentHTML( "afterbegin", alert_html_rtl( "danger", Alert.error( 103 ) ) );
            return false;
        }

        return mobile;
    }

    validateTypeUser() {
        const register_form     = document.getElementById( "register_form" );
        const type_user_doctor  = document.getElementById( "type_user_1" );
        const type_user_patient = document.getElementById( "type_user_2" );

        if ( type_user_doctor.checked ) return 1;
        else if( type_user_patient.checked ) return 2;
        else {
            register_form.insertAdjacentHTML( "afterbegin", alert_html_rtl( "danger", Alert.error( 106 ) ) );
            return 0;
        }
    }

    validatePassword() {

        const verify_form       = document.getElementById( "verify_form" );
        const password          = document.getElementById( "password" ).value;

        if ( password.length < 6 ) {
            verify_form.insertAdjacentHTML( "afterbegin", alert_html_rtl( "danger", Alert.error( 104 ) ) );
            return false;
        }

        return password;
    }

    validateConfirmPassword() {

        const verify_form       = document.getElementById( "verify_form" );
        const password          = document.getElementById( "password" ).value;
        const confirm_password  = document.getElementById( "confirm_password" ).value;

        if ( confirm_password !== password ) {
            verify_form.insertAdjacentHTML( "afterbegin", alert_html_rtl( "danger", Alert.error( 105 ) ) );
            return false;
        }

        return confirm_password;
    }

    validateVerifyCode() {

        const verify_form       = document.getElementById( "verify_form" );
        const verify_code          = document.getElementById( "verify_code" ).value;

        if ( verify_code.length !== 6 ) {
            verify_form.insertAdjacentHTML( "afterbegin", alert_html_rtl( "danger", Alert.error( 107 ) ) );
            return false;
        }

        return verify_code;
    }

    stepVerifyMobile( response ) {
        sweet_alert_message( response, () => {
            const register_form = document.getElementById( "register_form" );
            if ( response.status === "failed" ) return;
            register_form.reset();
            window.location.href = response.return_url;
        } );
    }

    submitVerify() {
        const verify_form = document.getElementById( "verify_form" );
        if ( ! verify_form ) return;
        verify_form.addEventListener( "submit", ( e ) => {
            e.preventDefault();

            if ( verify_form.querySelector( ".alert" ) ) {
                verify_form.querySelector( ".alert" ).remove();
            }

            const verify_code = this.validateVerifyCode();
            if ( ! verify_code ) return;

            const password = this.validatePassword();
            if ( ! password ) return;

            const confirm_password = this.validateConfirmPassword();
            if ( ! confirm_password ) return;

            const fetch_data = {
                method: "post",
                data: {
                    verify_code     : verify_code,
                    password        : password,
                    confirm_password: confirm_password,
                }
            };

            ajax_fetch( route.verify_submit, this.completeRegister, fetch_data );
        } );
    }

    completeRegister( response ) {
        sweet_alert_message( response, () => {
            const verify_form = document.getElementById( "verify_form" );
            if ( response.status !== "success" ) return;
            verify_form.reset();
            window.location.href = response.return_url;
        } );
    }
}

doc_ready( Register.run );