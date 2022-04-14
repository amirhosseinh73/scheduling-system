class Booking {
    datePicaker = new mds.MdsPersianDateTimePicker( document.getElementById( "booking_choose_date" ), {
        targetTextSelector: '#booking_choose_date_append',
        // targetDateSelector: '[data-name="dtp1-date"]',
        // placement: 'left',
        monthsToShow: [2,2],
        englishNumber: true,
        disabled: false,
        // selectedDate: date, //new Date('2022, 00, 23, 11,50,45'),
        disableBeforeToday: true,
        disableAfterToday: false,
        modalMode: false,
        yearOffset: 0,
        enableTimePicker: true,
        // onClickEvent: function() {
        //     homework_config.flag_edit = true; //when click back button show alert
        // }
    });

    timePicker = ( id, id_append ) => {
        mdtimepicker( id , {
            format: 'hh:mm',
            is24hour: false,
            events: {
                shown: function () {
                    // $('#ibv_vb_time_publish_content_maker_input').parent().addClass('active');
                },
                hidden: function () {
                    // $('#ibv_vb_time_publish_content_maker_input').parent().removeClass('active');
                },
                timeChanged: ( e ) => {
                    document.querySelector( id_append ).value = e.value;
                }
            },
            btnCancelContent: 'لغو',
            btnOkContent: 'تایید',
        });
    }

    init = () => {
        this.datePicaker;
        this.timePicker( "#booking_start_time", "#booking_start_time_append" );
        this.timePicker( "#booking_end_time", "#booking_end_time_append" );
    }

    static run = () => {
        const booking = new Booking;
        booking.init();
    }
}

init = () => {
    Booking.run();
}

doc_ready( init );