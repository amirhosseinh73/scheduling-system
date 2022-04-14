class Dashboard {

    sideNavProfileHTML = () => {
        return `
        <div class="side-nav-profile">
            <ul>
                <li>
                    <button type="button" id="btn_side_nav_edit_profile">
                        <i class="fas fa-user"></i>
                        <abbr>ویرایش پروفایل</abbr>
                    </button>
                </li>
                <li>
                    <button type="button" id="btn_side_nav_logout">
                        <i class="fas fa-sign-out"></i>
                        <abbr>خروج</abbr>
                    </button>
                </li>
            </ul>
        </div>
        `;
    }

    get sideNavProfileMenuSelector() {
        return document.querySelector( ".side-nav-profile" );
    }

    sideNavProfileHandler = ( event ) => {
        event.stopPropagation();

        const body = document.body;

        const html = this.sideNavProfileHTML();
        body.insertAdjacentHTML( "beforeend", html );
        
        body.offsetWidth;
        this.sideNavProfileMenuSelector.style.left = 0;

        //load events
        this.profileShow();
        this.logoutEvent();
        this.closeSideNav();
    }

    get sideNavProfileSelector() {
        return document.querySelector( ".nav-profile" );
    }

    sideNavProfileClick = () => {
        this.sideNavProfileSelector.addEventListener( "click", this.sideNavProfileHandler );
    }

    get btnSideNavEditProfileSelector() {
        return document.getElementById( "btn_side_nav_edit_profile" );
    }

    get btnSideNavLogoutSelector() {
        return document.getElementById( "btn_side_nav_logout" );
    }

    logoutEvent = () => {
        this.btnSideNavLogoutSelector.addEventListener( "click", this.logoutEventHandler );
    }

    logoutEventHandler = () => {
        window.location.href = base_url + "/logout";
    }

    closeSideNavHandler = ( event ) => {
        if ( event.target.closest( ".side-nav-profile" ) ) return;
        if ( ! this.sideNavProfileMenuSelector ) return;

        this.sideNavProfileMenuSelector.style.left = - this.sideNavProfileMenuSelector.offsetWidth + "px";
        setTimeout( () => {
            this.sideNavProfileMenuSelector.remove();
        }, 300);
    }

    closeSideNav = () => {
        const body = document.body;

        body.addEventListener( "click", this.closeSideNavHandler );
    }

    get profileModalSelector() {
        return document.getElementById( "profile_change_modal" );
    }

    get modalBtnCloseSelector() {
        return this.profileModalSelector.querySelector( ".cs-close-modal" );
    }

    get modalBackSelector() {
        return document.querySelector( ".cs-modal-back" );
    }

    get modalSelector() {
        return document.querySelector( ".cs-modal" );
    }

    profileCloseHandler = ( event ) => {
        if ( event.target.closest( ".cs-modal-inside" ) && ! event.target.closest( ".cs-close-modal" ) ) return;

        this.modalBackSelector.classList.remove( "active" );
        this.modalSelector.classList.remove( "active" );
    }

    profileClose = () => {
        this.modalSelector.addEventListener( "click", this.profileCloseHandler );
        this.modalBtnCloseSelector.addEventListener( "click", this.profileCloseHandler );
    }

    profileShowHandler = () => {
        this.profileModalSelector.classList.add( "active" );
        this.modalBackSelector.classList.add( "active" );
    }

    profileShow = () => {
        this.btnSideNavEditProfileSelector.addEventListener( "click", this.profileShowHandler );
        this.profileClose();
    }

    get profileUpdateFormSelector() {
        return document.getElementById( "form_edit_profile" );
    }

    validateFirstname = ( profile_form ) => {
        const first_name = document.getElementById( "firstname" ).value;

        if ( first_name.length < 2 ) {
            profile_form.insertAdjacentHTML( "afterbegin", alert_html_rtl( "danger", Alert.error( 101 ) ) );
            profile_form.scrollIntoView({behavior: 'smooth', block: 'start'});
            return false;
        }

        return first_name;
    }

    validateLastname = ( profile_form ) => {
        const last_name = document.getElementById( "lastname" ).value;

        if ( last_name.length < 2 ) {
            profile_form.insertAdjacentHTML( "afterbegin", alert_html_rtl( "danger", Alert.error( 102 ) ) );
            profile_form.scrollIntoView({behavior: 'smooth', block: 'start'});
            return false;
        }

        return last_name;
    }

    validateEmail = ( profile_form ) => {
        const valid_regex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        const email = document.getElementById( "email" ).value;

        if ( email.length === 0 ) return true;

        if (email.match( valid_regex )) {
            profile_form.insertAdjacentHTML( "afterbegin", alert_html_rtl( "danger", Alert.error( 108 ) ) );
            profile_form.scrollIntoView({behavior: 'smooth', block: 'start'});
            return false;
        }

        return email;
    }

    validateGender = () => {
        const male   = document.getElementById( "gender_1" );
        const female = document.getElementById( "gender_2" );

        if ( male.checked ) return 1;
        else if( female.checked ) return 0;
        else null;
    }

    validatePassword = ( profile_form ) => {
        const password = document.getElementById( "password" ).value;

        if ( password.length === 0 ) return true;

        if ( password.length < 6 ) {
            profile_form.insertAdjacentHTML( "afterbegin", alert_html_rtl( "danger", Alert.error( 104 ) ) );
            profile_form.scrollIntoView({behavior: 'smooth', block: 'start'});
            return false;
        }

        return password;
    }

    validateConfirmPassword = ( profile_form ) => {
        const password          = document.getElementById( "password" ).value;
        const confirm_password  = document.getElementById( "confirm_password" ).value;

        if ( password.length === 0 ) return true;

        if ( confirm_password !== password ) {
            profile_form.insertAdjacentHTML( "afterbegin", alert_html_rtl( "danger", Alert.error( 105 ) ) );
            profile_form.scrollIntoView({behavior: 'smooth', block: 'start'});
            return false;
        }

        return confirm_password;
    }

    validateVerifyCode = ( profile_form ) => {
        const verify_code = document.getElementById( "verify_code_email" );

        if ( ! verify_code ) return true;

        if ( verify_code.value.length === 0 ) return true;

        if ( verify_code.value.length !== 6 ) {
            profile_form.insertAdjacentHTML( "afterbegin", alert_html_rtl( "danger", Alert.error( 107 ) ) );
            profile_form.scrollIntoView({behavior: 'smooth', block: 'start'});
            return false;
        }

        return verify_code;
    }

    validateProfileImage = ( profile_form ) => {
        const image = document.getElementById( "choose_profile_image" );

        if ( ! image.files[0] ) return true;

        if( ! [ "image/jpeg", "image/png", "image/jpg" ].includes( image.files[0].type ) ) {
            profile_form.insertAdjacentHTML( "afterbegin", alert_html_rtl( "danger", Alert.error( 109 ) ) );
            return false;
        }

        return image;
    }

    successAlert = ( response ) => {
        sweet_alert_message( response, () => {
            // window.location.reload();
        } );
    }

    profileUpdateHandler = ( event ) => {
        event.preventDefault();
        const profile_form = this.profileUpdateFormSelector;

        if ( profile_form.querySelector( ".alert" ) ) {
            profile_form.querySelector( ".alert" ).remove();
        }

        const firstname = this.validateFirstname( profile_form );
        if ( ! firstname ) return;

        const lastname = this.validateLastname( profile_form );
        if ( ! lastname ) return;

        const email = this.validateEmail( profile_form );
        if ( ! email ) return;

        const gender = this.validateGender();

        const password = this.validatePassword( profile_form );
        if ( ! password ) return;

        const confirm_password = this.validateConfirmPassword( profile_form );
        if ( ! confirm_password ) return;

        const verify_code_email = this.validateVerifyCode( profile_form );
        if ( ! verify_code_email ) return;

        const image = this.validateProfileImage( profile_form );
        if ( ! image ) return;

        const fetch_data = {
            method: "post",
            data: {
                firstname: firstname,
                lastname : lastname,
                email    : email,
                gender   : gender,
                password : password,
                image    : image,
            }
        };

        ajax_fetch( route.update_profile, this.successAlert, fetch_data );
    }

    profileUpdate = () => {
        this.profileUpdateFormSelector.addEventListener( "submit", this.profileUpdateHandler );
    }

    init = () => {
        this.sideNavProfileClick();
        this.profileUpdate();
    }

    static run = () => {
        const dashboard = new Dashboard;
        dashboard.init();
    }
}

init = () => {
    Dashboard.run();
}

doc_ready( init );

function sss() {
    $('.ibv_vb_modal,.ibv_vb_modal_back').on('click', function () {
        // $('.tooltip').fadeOut('fast');
        $('#ibv_vb_date_send_answer_practice').MdPersianDateTimePicker('hide');
        $('#ibv_vb_date_publish_practice').MdPersianDateTimePicker('hide');
        // $('.select_time_practice_start').popover('hide');
    });
}

function dateTimeCalendarEventShow( id_click, id_show, date = new Date() ) {
    $( '#' + id_click ).MdPersianDateTimePicker({
        targetTextSelector: '#' + id_show,
        // targetDateSelector: '#ibv_mc_publish_time_calender_btn',
        placement: 'left',
        englishNumber: true,
        disabled: false,
        selectedDate: date, //new Date('2022, 00, 23, 11,50,45'),
        disableBeforeToday: true,
        disableAfterToday: false,
        modalMode: false,
        yearOffset: 0,
        enableTimePicker: true,
        onClickEvent: function() {
            homework_config.flag_edit = true; //when click back button show alert
        }
    }).on('show.bs.popover', function() {
        $(this).addClass('active');
        //todo: tooltip not work
        $('.mds-bootstrap-persian-datetime-picker-popover *[title]').tooltip();
        $('.mds-bootstrap-persian-datetime-picker-popover table button.btn-light').off('mouseup').on('mouseup', function(e) {
            $(this).tooltip('hide');
        });
        $('.mds-bootstrap-persian-datetime-picker-popover').off('click').on('click', function(e) {
            e.preventDefault();
        });
    }).on('hide.bs.popover', function() {
        $(this).removeClass('active');
    }).on('click', function(e) {
        e.stopPropagation();
    });
}

function publish_modal_events() {
    $('#ibv_vb_date_publish_content_maker').MdPersianDateTimePicker({
        targetTextSelector: '#ibv_vb_date_publish_content_maker_input',
        placement: 'bottom',
        englishNumber: true,
        disabled: false,
        selectedDate: undefined, //new Date('2018/9/30'),
        disableBeforeToday: true,
        disableAfterToday: false,
        modalMode: false,
        yearOffset: 0,
    }).on('show.bs.popover', function () {
        $(this).addClass('active');
        setTimeout(function () {
            //todo: tooltip not work
            $('.mds-bootstrap-persian-datetime-picker-popover *[title]').tooltip();
            $('.mds-bootstrap-persian-datetime-picker-popover table button.btn-light').off('mouseup').on('mouseup', function (e) {
                $(this).tooltip('hide');
            });
            $('.mds-bootstrap-persian-datetime-picker-popover').off('click').on('click', function (e) {
                e.preventDefault();
            });
        }, 200);
    }).on('hide.bs.popover', function () {
        $(this).removeClass('active');
    }).on('click', function (e) {
        e.stopPropagation();
    });

    mdtimepicker('#ibv_vb_time_publish_content_maker_input', {
        format: 'hh:mm',
        is24hour: true,
        events: {
            shown: function () {
                $('#ibv_vb_time_publish_content_maker_input').parent().addClass('active');
            },
            hidden: function () {
                $('#ibv_vb_time_publish_content_maker_input').parent().removeClass('active');
            }
        },
        btnCancelContent: 'لغو',
        btnOkContent: 'تایید',
    });

    let content_maker_modal_details_1 = $('.content-maker-modal-details');
    content_maker_modal_details_1.find('img').attr('src',$(this).parents('section').parent().find('img').attr('src'));
    content_maker_modal_details_1.find('h5').html($(this).parents('section').parent().find('.js_title').text());
    content_maker_modal_details_1.find('p').html($(this).parents('section').parent().find('.js_description').text());
}