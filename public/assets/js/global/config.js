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

    question_answer_index_patient        : base_url + "/dashboard/question-answer/patient",
    question_answer_create_patient       : base_url + "/dashboard/question-answer/patient/create",
    question_answer_submit_patient       : base_url + "/dashboard/question-answer/patient/submit",
    question_answer_show_patient         : base_url + "/dashboard/question-answer/patient/show",
    question_answer_show_detail_patient  : base_url + "/dashboard/question-answer/patient/detail",
    
    question_answer_submit_answer_patient: base_url + "/dashboard/question-answer/patient/submit-answer",
    question_answer_close_patient        : base_url + "/dashboard/question-answer/patient/close",
    question_answer_delete_patient       : base_url + "/dashboard/question-answer/patient/delete",

    question_answer_index_doctor        : base_url + "/dashboard/question-answer/doctor",
    question_answer_create_doctor       : base_url + "/dashboard/question-answer/doctor/create",
    question_answer_submit_doctor       : base_url + "/dashboard/question-answer/doctor/submit",
    question_answer_show_doctor         : base_url + "/dashboard/question-answer/doctor/show",
    question_answer_show_detail_doctor  : base_url + "/dashboard/question-answer/doctor/detail",
    
    question_answer_submit_answer_doctor: base_url + "/dashboard/question-answer/doctor/submit-answer",
    question_answer_close_doctor        : base_url + "/dashboard/question-answer/doctor/close",
    question_answer_delete_doctor       : base_url + "/dashboard/question-answer/doctor/delete",

    exam_data: base_url + "/dashboard/exam/data",
    exam_page: base_url + "/dashboard/exam/page",
    exam_page_data: base_url + "/dashboard/exam/page/data",
    exam_submit: base_url + "/dashboard/exam/submit",
};

const state = {
    user_info: null,
}

const data_store = {
    patient_booking: new Array,
    current_booking: {},

    reservation_turns: new Array,

    question_answer_list_1: new Array,
    question_answer_list_2: new Array,
};

const match_media_1 = window.matchMedia( "(orientation: landscape) and (min-height: 576px)" );
const match_media_2 = window.matchMedia( "(orientation: landscape) and (min-width: 992px)" );
const is_phone = ! ( ( ( match_media_1.matches ) || ( match_media_2.matches ) ) );