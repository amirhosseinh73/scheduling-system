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

        this.sideNavProfileMenuSelector.style.left = - this.sideNavProfileMenuSelector.offsetWidth + "px";
        setTimeout( () => {
            this.sideNavProfileMenuSelector.remove();
        }, 300);
    }

    closeSideNav = () => {
        const body = document.body;

        body.addEventListener( "click", this.closeSideNavHandler );
    }

    init = () => {
        this.sideNavProfileClick();
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

$('#profile_user').off('click').on('click', function () {
    $('#profile_change_modal').addClass('active');
    $('.close_modal').off('click').on('click', function () {
        $('.ibv_vb_modal_back').click();
    });
});

$('.ibv_vb_modal_back,.ibv_vb_modal').off('click').on('click', function () {
    // TODO: clear all modal items
    $('.ibv_vb_modal').removeClass('active');
    $('.ibv_vb_modal_back').removeClass('active');
    $('#ibv_vb_search_list_books').val('');
});

$('.ibv_vb_modal,.ibv_vb_modal_back').on('click', function () {
    // $('.tooltip').fadeOut('fast');
    $('#ibv_vb_date_send_answer_practice').MdPersianDateTimePicker('hide');
    $('#ibv_vb_date_publish_practice').MdPersianDateTimePicker('hide');
    // $('.select_time_practice_start').popover('hide');
});

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