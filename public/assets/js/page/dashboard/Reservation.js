class Reservation {

    get submitSelector() {
        return document.getElementById( "reservation_form" );
    }

    successAlert = ( response ) => {
        sweet_alert_message( response, () => {
            if ( response.status === "success" ) window.location.href = response.return_url;
        } );
    }

    submitHandler = ( event ) => {
        event.preventDefault();

        const current_booking = data_store.current_booking;

        const fetch_data = {
            method: "post",
            data: {
                ID: current_booking.ID
            }
        };

        ajax_fetch( route.submit_reservation, this.successAlert, fetch_data );
    }
    
    submit = () => {
        this.submitSelector.addEventListener( "submit", this.submitHandler );
    }

    // buttonChooseHourActiveHandler = ( event ) => {
    //     const btn = event.target;

    //     if ( btn.classList.contains( "btn-color-1" ) ) {
    //         btn.classList.replace( "btn-color-1", "btn-color-2" );
    //         return;
    //     }

    //     document.querySelectorAll( ".btn-choose-hour" ).forEach( btn => {
    //         btn.classList.replace( "btn-color-1", "btn-color-2" );
    //     } );
    //     btn.classList.replace( "btn-color-2", "btn-color-1" );
    // }

    // buttonChooseHourActive = () => {
    //     document.querySelectorAll( ".btn-choose-hour" ).forEach( btn => {
    //         btn.addEventListener( "click", this.buttonChooseHourActiveHandler );
    //     } );
    // }

    chooseHourHTML = ( text ) => {
        //<button type="button" class="btn-color-2 font-size-0-8 w-100 btn-choose-hour">${ text }</button>
        return `<div class="col-12 px-1 my-4">
                    <span class="font-size-0-9 text-dark-1 w-100">ساعت حضور شما در مطب 
                        <strong class="font-size-0-95">${ text }</strong>
                    </span>
                </div>`;
    }

    containerLeftHandler = ( card ) => {
        this.containerLeft.classList.remove( "d-none" );

        const booking_ID = card.getAttribute( "data-id" );
        const current_booking = data_store.patient_booking.find( booking => +booking.ID === +booking_ID );        

        const name = document.getElementById( "detail_name" );
        name.innerHTML = "دکتر " + current_booking.doctor_info.firstname + " " + current_booking.doctor_info.lastname;

        const more_detail = document.getElementById( "more_detail" );

        more_detail.innerHTML = "";
        more_detail.insertAdjacentHTML( "beforeend", `<span class="d-block font-size-0-95 text-black mt-5">${current_booking.kind_text}</span>` );

        const booking_type_text = ( Boolean(+current_booking.type) ? "تلفنی" : "حضوری" );
        
        const gregorian_date = ( current_booking.date.split( " " ) )[ 0 ].split( "-" );
        const day_of_week = get_day_of_week( gregorian_date[ 0 ], gregorian_date[ 1 ], gregorian_date[ 2 ] );
        let jalaali_date = jalaali.toJalaali( +gregorian_date[ 0 ], +gregorian_date[ 1 ], +gregorian_date[ 2 ] ); // y,m,d
    
        jalaali_date = jalaali_date.jy + "/" + jalaali_date.jm + "/" + jalaali_date.jd ;
        more_detail.insertAdjacentHTML( "beforeend", `<span class="d-block font-size-0-95 text-dark-1 mt-3">${booking_type_text}</span>` );

        more_detail.insertAdjacentHTML( "beforeend", `<span class="d-block font-size-1-2 text-black mt-3">${day_of_week} ${jalaali_date}</span>` );

        const choose_hour_section = document.getElementById( "choose_hour" );
        if ( current_booking.number_reserved === current_booking.number_reserve ) {
            choose_hour_section.insertAdjacentText( "afterbegin", "نوبت ها پر شده است." );
            return;
        }

        choose_hour_section.innerHTML = "";

        // const reserve_available = parseInt( current_booking.number_reserve ) - parseInt( current_booking.number_reserved );

        const start_time = current_booking.start.split( ":" );
        let hour    = parseInt( start_time[ 0 ] );
        let minute  = parseInt( start_time[ 1 ] );

        if ( +current_booking.number_reserved !== 0 ) {
            minute = minute + ( current_booking.time * current_booking.number_reserved );

            while ( minute >= 60 ) { //calc hour
                hour++;
                minute -= 60;
            }
        }
        if ( minute === 0 ) minute = "00";
        if ( hour.toString().length === 1 ) hour = "0" + hour;
        choose_hour_section.insertAdjacentHTML( "beforeend", this.chooseHourHTML( hour + ":" + minute ) );

        // for ( let i = 0; i < reserve_available; i++ ) {
        //     //calc minute and hour after each visit
        //     minute = parseInt( minute );
        //     if ( i === 0 ) {
        //         if ( +current_booking.number_reserved !== 0 ) {
        //             minute = minute + ( current_booking.time * current_booking.number_reserved );
        //         }
        //     } else {
        //         minute = minute + parseInt( current_booking.time );
        //     }

        //     while ( minute >= 60 ) { //calc hour
        //         hour++;
        //         minute -= 60;
        //     }

        //     if ( minute === 0 ) minute = "00";

        //     choose_hour_section.insertAdjacentHTML( "beforeend", this.chooseHourHTML( hour + ":" + minute ) );
        // }

        const price_section = document.getElementById( "price_section" );
        price_section.innerHTML = current_booking.price;

        // this.buttonChooseHourActive();

        data_store.current_booking = current_booking;
        this.submit();
    }

    get containerLeft() {
        return document.querySelector( ".inside-container-left" );
    }

    appointmentCardHandler = ( event ) => {
        const card = event.target.closest( ".appointment-card" );

        if ( card.classList.contains( "active" ) ) {
            this.containerLeft.classList.add( "d-none" );
            card.classList.remove( "active" );
            return;
        }

        this.getAllCard.forEach( card => {
            card.classList.remove( "active" );
        } );
        card.classList.add( "active" );
        this.containerLeftHandler( card );
    }

    get getAllCard() {
        return document.querySelectorAll( ".appointment-card" );
    }

    callEventAppointmentCard = () => {
        this.getAllCard.forEach( section => {
            section.addEventListener( "click", this.appointmentCardHandler.bind( this ) );
        } );
    }

    appendBookingData = () => {
        const parent_HTML = document.getElementById( "reservation_form" ).querySelector( ".inside-container-right" );
        data_store.patient_booking.forEach( ( booking, index ) => {
            const is_full = ( booking.number_reserved === booking.number_reserve );
            const extra_class = is_full ? "full" : "";
            const gregorian_date = ( booking.date.split( " " ) )[ 0 ].split( "-" );
            const day_of_week = get_day_of_week( gregorian_date[ 0 ], gregorian_date[ 1 ], gregorian_date[ 2 ] );
            const booking_type_icon = ( Boolean(+booking.type) ? "<span class='card-icon text-success fas fa-phone-volume'></span>" : "<span class='card-icon text-success fas fa-user-group'></span>" );

            let jalaali_date = jalaali.toJalaali( +gregorian_date[ 0 ], +gregorian_date[ 1 ], +gregorian_date[ 2 ] ); // y,m,d
        
            jalaali_date = jalaali_date.jy + "/" + jalaali_date.jm + "/" + jalaali_date.jd ;

            parent_HTML.insertAdjacentHTML( "beforeend", `
            <section id="appointment_card_${ index + 1 }" data-id="${booking.ID}" class='appointment-card ${ extra_class }'>
                <img src='${ booking.doctor_info.image }'/>
                <div>
                    <h5 class='card-title'>
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

    handleBookingData = ( response ) => {
        if ( response.data.length < 1 ) return;

        data_store.patient_booking = response.data;
        
        this.appendBookingData();
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