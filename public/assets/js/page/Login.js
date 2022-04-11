
class Login {
    static run = () => {
        const login = new Login();

        login.submit();
    }

    submit() {
        const login_form = document.getElementById( "login_form" );
        if ( ! login_form ) return;
        login_form.addEventListener( "submit", ( e ) => {
            e.preventDefault();

            if ( login_form.querySelector( ".alert" ) ) {
                login_form.querySelector( ".alert" ).remove();
            }

            const username = this.validateMobile();
            if ( ! username ) return;

            const password = this.validatePassword();
            if ( ! password ) return;

            const fetch_data = {
                method: "post",
                data: {
                    username    : username,
                    password    : password,
                    remember_me : document.getElementById("remember_me").checked,
                }
            };

            ajax_fetch( route.login_submit, this.completeLogin, fetch_data );
        } );
    }

    validateMobile() {

        const login_form    = document.getElementById( "login_form" );
        const mobile        = document.getElementById( "username" ).value;

        if ( mobile.length !== 11 || +mobile[ 0 ] !== 0 || +mobile[ 1 ] !== 9 ) {
            login_form.insertAdjacentHTML( "afterbegin", alert_html_rtl( "danger", Alert.error( 103 ) ) );
            return false;
        }

        return mobile;
    }

    validatePassword() {

        const login_form    = document.getElementById( "login_form" );
        const password      = document.getElementById( "password" ).value;

        if ( password.length < 6 ) {
            login_form.insertAdjacentHTML( "afterbegin", alert_html_rtl( "danger", Alert.error( 104 ) ) );
            return false;
        }

        return password;
    }

    completeLogin( response ) {
        sweet_alert_message( response, () => {
            const login_form = document.getElementById( "login_form" );
            if ( response.status !== "success" ) return;
            login_form.reset();
            window.location.href = response.return_url;
        } );
    }
}

doc_ready( Login.run );