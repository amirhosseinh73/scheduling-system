const docReadyFunctions = function () {
    loginHandlerEventSubmit();
};

docReady(docReadyFunctions);

function loginHandlerEventSubmit() {
    const submit = document.getElementById( "submit" );

    submit.addEventListener( "submit", event => {
        event.preventDefault();
        loginHandler();
    } );
}

function loginHandler() {
    const username    = document.getElementById( "username" ).value;
    const password    = document.getElementById( "password" ).value;
    const remember_me = document.getElementById( "remember_me" ).checked;
    const submit      = document.getElementById( "submit" );

    const fetch_data = {
        method: "post",
        data: {
            email: username,
            password: password,
            remember_me: remember_me,
            admin: true,
        }
    };

    function success_function( _data ) {
        const exist_alert = document.getElementById( "alert_form" );

        if ( exist_alert ) exist_alert.remove();

        submit.insertAdjacentHTML( "afterbegin", alertHtmlLtr( "alert_form", _data.type, _data.message, "height" ) );

        if ( _data.status === "success" ) {
            setTimeout( () => {
                window.location.href = _data.return_url
            }, 1000 );
        }
    }

    ajaxFetch( RoutesAdmin.login, success_function, fetch_data );
}