const route = {
    register_submit : base_url + "/register/submit",
    verify_mobile   : base_url + "/register/verify",
    verify_submit   : base_url + "/register/verify/submit",
    
    login_submit    : base_url + "/login/submit",
    recovery_submit : base_url + "/recovery/submit",

    dashboard       : base_url + "/dashboard",
    update_profile  : base_url + "/dashboard/update",

    submit_booking  : base_url + "/dashboard/booking/submit",
    booking_patient : base_url + "/dashboard/booking/data-patient",

    submit_reservation : base_url + "/dashboard/reserve/submit",
    reservation_turns : base_url + "/dashboard/reserve/turns-data",
};

const state = {
    user_info: null,
}

const data_store = {
    patient_booking: new Array,
    current_booking: {},

    reservation_turns: new Array,
};