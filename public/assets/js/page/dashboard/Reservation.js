class Reservation {
    appointmentCardHandler = ( event ) => {
        event.target.closest( ".appointment-card" ).classList.toggle( "active" );
    }

    callEventAppointmentCard = () => {
        document.querySelectorAll( ".appointment-card" ).forEach( section => {
            section.addEventListener( "click", this.appointmentCardHandler.bind( this ) );
        } );
    }

    handleBookingData = ( response ) => {
        if ( response.data.length < 1 ) return;

        data_store.patient_booking = response.data;
        const parent_HTML = document.getElementById( "reservation_form" ).querySelector( ".inside-container-right" );
        response.data.forEach( ( booking, index ) => {
            const is_full = ( booking.number_reserved === booking.number_reserve );
            const extra_class = is_full ? "full" : "";
            const gregorian_date = ( booking.date.split( " " ) )[ 0 ].split( "-" );
            const day_of_week = get_day_of_week( gregorian_date[ 0 ], gregorian_date[ 1 ], gregorian_date[ 2 ] );
            const booking_type_icon = ( Boolean(+booking.type) ? "<span class='card-icon text-success fas fa-phone-volume'></span>" : "<span class='card-icon text-success fas fa-user-group'></span>" );

            let jalaali_date = jalaali.toJalaali( +gregorian_date[ 0 ], +gregorian_date[ 1 ], +gregorian_date[ 2 ] ); // y,m,d
        
            jalaali_date = jalaali_date.jy + "/" + jalaali_date.jm + "/" + jalaali_date.jd ;

            parent_HTML.insertAdjacentHTML( "afterbegin", `
            <section id="appointment_card_${ index + 1 }" class='appointment-card ${ extra_class }'>
                <img src='${ booking.doctor_info.image }'/>
                <div>
                    <h5 class='card-title'>
                        دکتر
                        ${booking.doctor_info.firstname + " " + booking.doctor_info.lastname}
                    </h5>
                    <p class='card-description-1'>${booking.kind_text}</p>
                    ${booking_type_icon}
                    <p class='card-description-2'>
                        <span>${day_of_week} ${jalaali_date} </span>
                        <abbr>${booking.start + " - " + booking.end}</abbr>
                    </p>
                </div>
            </section>
            ` );
        } );
        this.callEventAppointmentCard();
    }

    loadBookingData = () => {
        const fetch_data = {
            method: "get",
            data: {}
        };

        ajax_fetch( route.booking_patient, this.handleBookingData, fetch_data );
    }

    init = () => {
        this.loadBookingData();
    }

    static run = () => {
        const reservation = new Reservation;

        reservation.init();
    }
}

const init = () => {
    Reservation.run();
}

doc_ready( init );