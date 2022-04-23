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
    booking_turns   : base_url + "/dashboard/booking/turns-data",

    submit_reservation : base_url + "/dashboard/reserve/submit",
    reservation_turns : base_url + "/dashboard/reserve/turns-data",

    question_answer_index        : base_url + "/dashboard/question-answer/patient",
    question_answer_create       : base_url + "/dashboard/question-answer/patient/create",
    question_answer_submit       : base_url + "/dashboard/question-answer/patient/submit",
    question_answer_show         : base_url + "/dashboard/question-answer/patient/show",
    question_answer_show_detail  : base_url + "/dashboard/question-answer/patient/detail",
    
    question_answer_submit_answer: base_url + "/dashboard/question-answer/patient/submit-answer",
    question_answer_close        : base_url + "/dashboard/question-answer/patient/close",
    question_answer_delete       : base_url + "/dashboard/question-answer/patient/delete",
};

const state = {
    user_info: null,
}

const data_store = {
    patient_booking: new Array,
    current_booking: {},

    reservation_turns: new Array,

    question_answer_patient: new Array,
};