function suggestLocationApp() {
    const address = document.getElementById( "open_map" );
    if ( ! address ) return;

    address.addEventListener( "click", open_address );

    function open_address() {
        // if ( is_phone ) window.location = "google.navigation:q=" + this.dataset.ltLn + "&mode=d";
        if ( is_phone ) window.location = "geo:" + this.dataset.ltLn;
        else window.location.href = window.open( this.dataset.address , "_blank" );
    }
}

doc_ready( function() {
    suggestLocationApp();
} );