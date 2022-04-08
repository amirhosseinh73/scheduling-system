
class Register {
    static run = () => {
        const register = new Register();

        register.submit();
    }

    submit() {
        const register_form = document.getElementById( "register_form" );
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

            const password = this.validatePassword();
            if ( ! password ) return;
            
            const confirm_passwrod = this.validateConfirmPasswrod();
            if ( ! confirm_passwrod ) return;

            const fetch_data = {
                method: "post",
                data: {
                    firstname       : firstname,
                    lastname        : lastname,
                    mobile          : mobile,
                    password        : password,
                    confirm_password: confirm_passwrod,
                }
            };

            ajax_fetch( route.register_submit, this.loginAfterRegister, fetch_data );
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

    validatePassword() {

        const register_form     = document.getElementById( "register_form" );
        const password          = document.getElementById( "password" ).value;

        if ( password.length < 6 ) {
            register_form.insertAdjacentHTML( "afterbegin", alert_html_rtl( "danger", Alert.error( 104 ) ) );
            return false;
        }

        return password;
    }

    validateConfirmPasswrod() {

        const register_form     = document.getElementById( "register_form" );
        const password          = document.getElementById( "password" ).value;
        const confirm_password  = document.getElementById( "confirm_password" ).value;

        if ( confirm_password !== password ) {
            register_form.insertAdjacentHTML( "afterbegin", alert_html_rtl( "danger", Alert.error( 105 ) ) );
            return false;
        }

        return confirm_password;
    }

    loginAfterRegister( response ) {
        console.log(response);
        if ( response.status === "failed" )
            sweet_alert_message( response );
        else
            sweet_alert_confirm( response, () => {
                window.location.href = response.return_url;
            } );
    }
}

doc_ready( Register.run );