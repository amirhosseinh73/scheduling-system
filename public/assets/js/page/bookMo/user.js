const docReadyFunctions = function () {
    ID_NAME = "user";

    createHandlerEventClick();
    getList();

    Paginate.route    = RoutesAdmin.userCountPaginate;
    Paginate.history  = RoutesAdmin.userListView;
    Paginate.request  = "GET";
    Paginate.callback = getList; // function name
    getPaginateData();
};

docReady(docReadyFunctions);

function createHandlerEventClick() {
    const btn_create_html = document.getElementById( "btn_" + ID_NAME + "_create" );

    if ( ! btn_create_html ) return;

    btn_create_html.addEventListener( "click", () => {
        createHandler();
    } );
}

function createHandler() {
    Paginate.request = "CLICK"; // chagne it from GET to CLICK for not appling previous and next paginate event

    const select_exist_create_html = document.getElementById( ID_NAME + "_create_html" );
    const select_exist_edit_html = document.getElementById( ID_NAME + "_edit_html" );

    if ( select_exist_create_html !== null ) select_exist_create_html.remove();
    if ( select_exist_edit_html !== null ) select_exist_edit_html.closest( "tr" ).remove();

    const btn_create_html = document.getElementById( "btn_" + ID_NAME + "_create" );

    btn_create_html.insertAdjacentHTML( "afterend", `${editOrCreateHtml( true ).format(
        "", //0 is data-edited-id for edit html
        "",
        "",
        "",
        "",
        )}` );

    //btn cancel create
    document.querySelector( ".btn-cancel-html" ).addEventListener( "click", () => {
        document.getElementById( ID_NAME + "_create_html" ).remove();
    } );

    //call input type text accept number event
    input_text_number();

    //call input type text accept number event
    input_text_number();

    //submit form create
    const submit = document.getElementById( ID_NAME + "_create" );

    if ( ! submit ) return;

    submit.addEventListener( "submit", event => {
        event.preventDefault();
        createHandlerSubmit.call( this );
    } );
}

function createHandlerSubmit() {
    const firstname = document.getElementById( "firstname" ).value;
    const lastname  = document.getElementById( "lastname" ).value;
    const email     = document.getElementById( "email" ).value;
    const password  = document.getElementById( "password" ).value;
    const status    = document.getElementById( "user_status" ).value;
    const gender    = document.getElementById( "gender" ).value;
    const age       = document.getElementById( "age" ).value;
    const is_admin  = document.getElementById( "is_admin" ).value;
    const image     = document.getElementById( "image" );
    const submit    = document.getElementById( ID_NAME + "_edit" );

    if( image.files[0] && ! [ "image/jpeg", "image/png", "image/jpg" ].includes( image.files[0].type ) ) {
		submit.insertAdjacentHTML( "afterbegin", alertHtmlRtl( "alert_form", "danger", "فقط تصویر jpg و png اجازه دارید.", "height" ) );
        return;
    }

    const fetch_data = {
        method: "post",
        data: {
            firstname: firstname,
            lastname: lastname,
            password: password,
            email: email,
            status: status,
            gender: gender,
            age: age,
            is_admin: is_admin,
            image: image.files[0],
        }
    };

    function success_function( _data ) {
        
        if ( _data.status === "success" ) {
            sweetAlertSuccess( _data.message );

            document.getElementById( ID_NAME + "_create_html" ).remove();

            PaginateDataCache[Paginate.offset] = [];

            getList();
            getPaginateData();

        } else {
            sweetAlertError( _data.message );
        }
    }

    ajaxFetch( RoutesAdmin.userCreate, success_function, fetch_data );
}

async function getList() {

    const table_list_body = document.getElementById( "list_" + ID_NAME );

    if ( ! table_list_body ) return;
    
    if ( Paginate.request === "GET" ) {
        if ( urlParam().has( "limit" ) ) Paginate.limit = urlParam().get( "limit" );
        if ( urlParam().has( "offset" ) ) Paginate.offset = urlParam().get( "offset" );
    }

    if ( typeof PaginateDataCache[Paginate.offset] != "undefined" && PaginateDataCache[Paginate.offset].length > 0 ) {
        success_status_function();
        return;
    }

    const fetch_data = {
        method: "get",
    };

    function success_function( _data ) {
        if ( _data.status === "success" ) {
            PaginateDataCache[Paginate.offset] = _data.data;
            success_status_function();
        }
    }

    function success_status_function() {
        table_list_body.innerHTML = "";
        if ( PaginateDataCache[Paginate.offset].length < 1 ) {
            document.querySelector( ".paginate-selector" ).querySelector( ".previous" ).querySelector( ".page-link" ).click();
        } //when delete item from last page and array offset is clear completly, must go to previous page
        table_list_body.insertAdjacentHTML( "beforeend", tableRowHtml( PaginateDataCache[Paginate.offset] ) );

        removeHandlerEventClick();
        editHandlerEventClick();
    }

    await ajaxFetch( RoutesAdmin.userList + "?" + Paginate.urlParams() , success_function, fetch_data );
}

function removeHandlerEventClick() {
    const btn_remove = document.getElementsByClassName( "btn-remove" );

    if ( ! btn_remove ) return;


    btn_remove.forEach( _btn => {
        _btn.addEventListener( "click", function() {
            sweetAlertConfirm( removeHandler.bind( this ) );
        } );  
    } );
}

function removeHandler() {
    Paginate.request = "CLICK"; // chagne it from GET to CLICK for not appling previous and next paginate event

    const ID               = this.getAttribute( "data-id" );
    const deleted_row_item = this.closest( ".table-item-parent" );

    const fetch_data = {
        method: "post",
        data: {
            ID: ID,
        }
    };

    function success_function( _data ) {
        if ( _data.status === "success" ) {
            sweetAlertSuccess( _data.message );
            deleted_row_item.remove();

            PaginateDataCache[Paginate.offset] = [];

            getList();
            getPaginateData();
        }
    }

    ajaxFetch( RoutesAdmin.userRemove, success_function, fetch_data );
}

function editHandlerEventClick() {
    const btn_edit = document.getElementsByClassName( "btn-edit" );

    if ( ! btn_edit ) return;

    btn_edit.forEach( _btn => {
        _btn.addEventListener( "click", function() {
            editHandler.call( this );
        } );  
    } );
}

function editHandler() {
    Paginate.request = "CLICK"; // chagne it from GET to CLICK for not appling previous and next paginate event

    const select_exist_edit_html = document.getElementById( ID_NAME + "_edit_html" );
    const select_exist_create_html = document.getElementById( ID_NAME + "_create_html" );

    if ( select_exist_edit_html !== null ) select_exist_edit_html.closest( "tr" ).remove();
    if ( select_exist_create_html !== null ) select_exist_create_html.remove();

    //select all td in that row of edited
    const all_td = this.closest( "tr" ).getElementsByTagName( "td" ); //0 is number of row

    const id      = +this.getAttribute( "data-id" );
    let firstname = all_td[1].innerText.trim();
    let lastname  = all_td[2].innerText.trim();
    let email     = all_td[3].innerText.trim();
    let status    = all_td[4].innerText.trim();
    let gender    = all_td[5].innerText.trim();
    let age       = all_td[6].innerText.trim();
    let is_admin  = all_td[7].innerText.trim();

    switch ( gender ) {
        case "آقا" :
            gender = "male";
            break;
        case "خانم" :
            gender = "female";
            break;
    }

    switch ( status ) {
        case "فعال" :
            status = "true";
            break;
        case "غیر فعال" :
            status = "false";
            break;
    }

    switch ( is_admin ) {
        case "بله" :
            is_admin = "true";
            break;
        case "خیر" :
            is_admin = "false";
            break;
    }
    
    // .format is a method created by me in helper.js, replace {} in string in order to number like {0}, {1}, {2}
    this.closest( "tr" ).insertAdjacentHTML( "afterend", `<tr><td colspan="14"> ${editOrCreateHtml( false, status, is_admin, gender ).format(
        id,
        firstname,
        lastname,
        email,
        age,
        )} </td></tr>` );

    //btn cancel edit
    this.closest( "tbody" ).querySelector( ".btn-cancel-html" ).addEventListener( "click", () => {
        document.getElementById( ID_NAME + "_edit_html" ).closest( "tr" ).remove();
    } );

    //call input type text accept number event
    input_text_number();

    //call input type text accept number event
    input_text_number();

    //submit form edit
    const submit = document.getElementById( ID_NAME + "_edit" );

    if ( ! submit ) return;

    submit.addEventListener( "submit", event => {
        event.preventDefault();
        editHandlerSubmit.call( this );
    } );
}

function editOrCreateHtml( is_create = false, status = "true", is_admin = "false", gender = "male" ) {
    let html = `<article id="${ ID_NAME }_${ is_create ? 'create' : 'edit' }_html" class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <h4 class="card-title mb-4">
                            ${ is_create ?
                                'ایجاد' 
                                :
                                'ویرایش' }
                            کاربر
                        </h4>
                    </div>
                    <div class="col-3">
                        <button type="button" class="btn btn-danger btn-block waves-effect waves-light btn-cancel-html">انصراف</button>
                    </div>
                </div>
                <form id="${ ID_NAME }_${ is_create ? 'create' : 'edit' }" enctype="multipart/form-data" autocomplete="off">
                    <div class="row align-items-end">
                        <div class="col-12 col-sm-6 mb-4">
                            <label for="firstname">نام</label>
                            <input id="firstname" type="text" class="form-control" placeholder="نام" value="{1}"/>
                        </div>
                        <div class="col-12 col-sm-6 mb-4">
                            <label for="lastname">نام خانوادگی</label>
                            <input id="lastname" type="text" class="form-control" placeholder="نام خانوادگی" value="{2}"/>
                        </div>
                        <div class="col-12 col-sm-6 mb-4">
                            <label for="email">ایمیل</label>
                            <input id="email" type="text" class="form-control" placeholder="ایمیل" value="{3}"/>
                        </div>
                        <div class="col-12 col-sm-6 mb-4">
                            <label for="password">رمز عبور</label>
                            <input id="password" type="text" class="form-control" placeholder="${
                                is_create ?
                                'رمز عبور' 
                                :
                                'در صورتی که رمز را نمیخواهید تغییر دهید، اینجا را خالی رها کنید.' 
                            }" value="" autocomplete="off"/>
                        </div>
                        <div class="col-12 col-sm-3 mb-4">
                            <label for="user_status">
                                وضعیت
                            </label>
                            <select id="user_status" class="form-control custom-select">
                                <option ${ status === "true" ? "selected" : "" } value="true">فعال</option>
                                <option ${ status === "false" ? "selected" : "" } value="false">غیرفعال</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-3 mb-4">
                            <label for="is_admin">
                                ادمین
                            </label>
                            <select id="is_admin" class="form-control custom-select">
                                <option ${ is_admin === "true" ? "selected" : "" } value="true">بله</option>
                                <option ${ is_admin === "false" ? "selected" : "" } value="false">خیر</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-3 mb-4">
                            <label for="gender">
                                جنسیت
                            </label>
                            <select id="gender" class="form-control custom-select">
                                <option ${ gender === "male" ? "selected" : "" } value="male">آقا</option>
                                <option ${ gender === "female" ? "selected" : "" } value="female">خانم</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-3 mb-4">
                            <label for="age">سن</label>
                            <input id="age" type="text" data-type="number" class="form-control" placeholder="سن" value="{4}"/>
                        </div>
                        <div class="col-12 col-sm-6 mb-4">
                            <label for="image">عکس</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image">
                                <label class="custom-file-label" for="image">انتخاب فایل</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mb-4">
                            <button data-edit-id="{0}" type="submit" class="btn btn-success waves-effect waves-light btn-block">
                                ثبت
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</article>`;
    return html;
}

function editHandlerSubmit() {
    const ID        = this.getAttribute( "data-id" );
    const firstname = document.getElementById( "firstname" ).value;
    const lastname  = document.getElementById( "lastname" ).value;
    const email     = document.getElementById( "email" ).value;
    const password  = document.getElementById( "password" ).value;
    const status    = document.getElementById( "user_status" ).value;
    const gender    = document.getElementById( "gender" ).value;
    const age       = document.getElementById( "age" ).value;
    const is_admin  = document.getElementById( "is_admin" ).value;
    const image     = document.getElementById( "image" );
    const submit    = document.getElementById( ID_NAME + "_edit" );

    if( image.files[0] && ! [ "image/jpeg", "image/png", "image/jpg" ].includes( image.files[0].type ) ) {
		submit.insertAdjacentHTML( "afterbegin", alertHtmlRtl( "alert_form", "danger", "فقط تصویر jpg و png اجازه دارید.", "height" ) );
        return;
    }

    const fetch_data = {
        method: "post",
        data: {
            ID: ID,
            firstname: firstname,
            lastname: lastname,
            password: password,
            email: email,
            status: status,
            gender: gender,
            age: age,
            is_admin: is_admin,
            image: image.files[0],
        }
    };

    function success_function( _data ) {
        
        if ( _data.status === "success" ) {
            sweetAlertSuccess( _data.message );

            document.getElementById( ID_NAME + "_edit_html" ).closest( "tr" ).remove();

            PaginateDataCache[Paginate.offset] = [];

            getList();
            getPaginateData();

        } else {
            sweetAlertError( _data.message );
        }
    }

    ajaxFetch( RoutesAdmin.userEdit, success_function, fetch_data );
}