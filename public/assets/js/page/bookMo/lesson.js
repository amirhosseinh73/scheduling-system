const docReadyFunctions = function () {
    createHandlerEventClick();
    getListLessons();

    Paginate.route    = RoutesAdmin.lessonCountPaginate;
    Paginate.history  = RoutesAdmin.lessonListView;
    Paginate.request  = "GET";
    Paginate.callback = getListLessons; // function name
    getPaginateData();
};

docReady(docReadyFunctions);

function createHandlerEventClick() {
    const btn_create_html = document.getElementById( "btn_lesson_create" );

    if ( ! btn_create_html ) return;

    btn_create_html.addEventListener( "click", () => {
        createHandler();
    } );
}

function createHandler() {
    Paginate.request = "CLICK"; // chagne it from GET to CLICK for not appling previous and next paginate event

    const select_exist_create_html = document.getElementById( "lesson_create_html" );
    const select_exist_edit_html = document.getElementById( "lesson_edit_html" );

    if ( select_exist_create_html !== null ) select_exist_create_html.remove();
    if ( select_exist_edit_html !== null ) select_exist_edit_html.closest( "tr" ).remove();

    const btn_create_html = document.getElementById( "btn_lesson_create" );

    btn_create_html.insertAdjacentHTML( "afterend", `${editOrCreateHtml( true ).format(
        "", //0 is data-edited-id for edit html
        "",
        "",
        "",
        "",
        "",
        )}` );

    //btn cancel create
    document.querySelector( ".btn-cancel-html" ).addEventListener( "click", () => {
        document.getElementById( "lesson_create_html" ).remove();
    } );

    //event for get list heads by package_ID
    createOrEditListHeadHandlerEvent();
    
    //submit form create
    const submit = document.getElementById( "lesson_create" );

    if ( ! submit ) return;

    submit.addEventListener( "submit", event => {
        event.preventDefault();
        createHandlerSubmit.call( this );
    } );
}

function createHandlerSubmit() {
    const title       = document.getElementById( "title" ).value;
    const description = document.getElementById( "description" ).value;
    const head_ID     = document.getElementById( "heads" ).value;
    const image       = document.getElementById( "image" );
    const URL         = document.getElementById( "url" ).value;
    const is_free     = document.getElementById( "is_free" ).value;

    if( image.files[0] && ! [ "image/jpeg", "image/png", "image/jpg" ].includes( image.files[0].type ) ) {
		submit.insertAdjacentHTML( "afterbegin", alertHtmlRtl( "alert_form", "danger", "فقط تصویر jpg و png اجازه دارید.", "height" ) );
        return;
    }
    const fetch_data = {
        method: "post",
        data: {
            title: title,
            description: description,
            head_ID: head_ID,
            image: image.files[0],
            URL: URL,
            is_free: is_free,
        }
    };

    function success_function( _data ) {
        
        if ( _data.status === "success" ) {
            sweetAlertSuccess( _data.message );

            document.getElementById( "lesson_create_html" ).remove();

            PaginateDataCache[Paginate.offset] = [];

            getListLessons();
            getPaginateData();

        } else {
            sweetAlertError( _data.message );
        }
    }

    ajaxFetch( RoutesAdmin.lessonCreate, success_function, fetch_data );
}

async function getListLessons() {

    const table_list_body = document.getElementById( "list_lessons" );

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

    let get_params = Paginate.urlParams();
    if ( Paginate.request === "GET" ) get_params = Paginate.urlParams() + "&list_package=true";
    
    await ajaxFetch( RoutesAdmin.lessonList + "?" + get_params , success_function, fetch_data );
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

            getListLessons();
            getPaginateData();
        }
    }

    ajaxFetch( RoutesAdmin.lessonRemove, success_function, fetch_data );
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

    const select_exist_edit_html = document.getElementById( "lesson_edit_html" );
    const select_exist_create_html = document.getElementById( "lesson_create_html" );

    if ( select_exist_edit_html !== null ) select_exist_edit_html.closest( "tr" ).remove();
    if ( select_exist_create_html !== null ) select_exist_create_html.remove();

    //select all td in that row of edited
    const all_td = this.closest( "tr" ).getElementsByTagName( "td" ); //0 is number of row

    const id          = +this.getAttribute( "data-id" );
    let title         = all_td[2].innerText.trim();
    let description   = all_td[3].innerText.trim();
    let head_title    = all_td[1].innerText.trim();
    let head_ID       = all_td[9].innerText.trim();
    // let is_free       = all_td[5].innerText.trim();
    let URL           = all_td[4].innerText.trim();

    this.closest( "tr" ).insertAdjacentHTML( "afterend", `<tr><td colspan="10"> ${editOrCreateHtml().format(
        id,
        title,
        description,
        head_ID,
        head_title,
        URL,
        )} </td></tr>` );

    //btn cancel edit
    this.closest( "tbody" ).querySelector( ".btn-cancel-html" ).addEventListener( "click", () => {
        document.getElementById( "lesson_edit_html" ).closest( "tr" ).remove();
    } );


    //submit form edit
    const submit = document.getElementById( "lesson_edit" );

    if ( ! submit ) return;

    submit.addEventListener( "submit", event => {
        event.preventDefault();
        editHandlerSubmit.call( this );
    } );
}

function editOrCreateHtml( is_create = false ) {
    let html = `<article id="lesson_${ is_create ? 'create' : 'edit' }_html" class="row">
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
                            درس
                        </h4>
                    </div>
                    <div class="col-3">
                        <button type="button" class="btn btn-danger btn-block waves-effect waves-light btn-cancel-html">انصراف</button>
                    </div>
                </div>
                <form id="lesson_${ is_create ? 'create' : 'edit' }" enctype="multipart/form-data">
                    <div class="row align-items-end">
                        <div class="col-12 col-sm-6 mb-4">
                            <label for="title">عنوان</label>
                            <input id="title" type="text" class="form-control" placeholder="عنوان" value="{1}"/>
                        </div>
                        <div class="col-12 col-sm-6 mb-4">
                            <label for="description">توضیحات</label>
                            <textarea id="description" type="text" class="form-control">{2}</textarea>
                        </div>`;
                        if ( is_create ) { html += `<div class="col-12 col-sm-3 mb-4">
                            <label for="packages">
                                انتخاب پکیج
                            </label>
                            <select id="packages" class="form-control custom-select">
                                <optgroup label="لیست پکیج ها">`;
                            AllPackages.forEach( value => {
                                html += `<option value="${value.ID}">${value.title}</option>`;
                            } );
                            html += `
                                </optgroup>
                            </select>
                        </div>`;
                        }

                        html += `<div class="col-12 ${ is_create ? 'col-sm-3' : 'col-sm-6' } mb-4">
                            <label for="heads">
                                انتخاب سرفصل
                            </label>
                            <select id="heads" class="form-control custom-select">
                                ${ is_create ? '<option value="none">انتخاب کنید</option>' : '<option value="{3}">{4}</option>' }
                                <optgroup label="لیست سرفصل ها">`;

                        if ( ! is_create ) {
                            AllHeads.forEach( value => {
                                html += `<option value="${value.ID}">${value.title}</option>`;
                            } );
                        }

                        html += `</optgroup>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6 mb-4">
                            <label for="image">عکس</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image">
                                <label class="custom-file-label" for="image">انتخاب فایل</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-3 mb-4">
                            <label for="url">لینک</label>
                            <input id="url" type="text" class="form-control" placeholder="لینک" value="{5}"/>
                        </div>
                        <div class="col-12 col-sm-3 mb-4">
                            <label for="is_free">
                                رایگان
                            </label>
                            <select id="is_free" class="form-control custom-select">
                                <option value="false">خیر</option>
                                <option value="true">بله</option>
                            </select>
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
    const title       = document.getElementById( "title" ).value;
    const description = document.getElementById( "description" ).value;
    const head_ID     = document.getElementById( "heads" ).value;
    const ID          = this.getAttribute( "data-id" );
    const image       = document.getElementById( "image" );
    const URL         = document.getElementById( "url" ).value;
    const is_free     = document.getElementById( "is_free" ).value;

    if( image.files[0] && ! [ "image/jpeg", "image/png", "image/jpg" ].includes( image.files[0].type ) ) {
		submit.insertAdjacentHTML( "afterbegin", alertHtmlRtl( "alert_form", "danger", "فقط تصویر jpg و png اجازه دارید.", "height" ) );
        return;
    }

    const fetch_data = {
        method: "post",
        data: {
            title: title,
            description: description,
            head_ID: head_ID,
            ID: ID,
            image: image.files[0],
            URL: URL,
            is_free: is_free,
        }
    };

    function success_function( _data ) {
        
        if ( _data.status === "success" ) {
            sweetAlertSuccess( _data.message );

            document.getElementById( "lesson_edit_html" ).closest( "tr" ).remove();

            PaginateDataCache[Paginate.offset] = [];

            getListLessons();
            getPaginateData();

        } else {
            sweetAlertError( _data.message );
        }
    }

    ajaxFetch( RoutesAdmin.lessonEdit, success_function, fetch_data );
}

function createOrEditListHeadHandlerEvent() {
    const packages_select_box = document.getElementById( "packages" );

    packages_select_box.addEventListener( "change", function() {
        const package_ID = this.value;
        console.log(package_ID);
        const fetch_data = {
            method: "post",
            data: {
                package_ID: package_ID,
            }
        };
    
        function success_function( _data ) {
            console.log(_data);
            if ( _data.status === "success" ) {
    
                const append_options_parent = document.getElementById( "heads" ).querySelector( "optgroup" );

                append_options_parent.innerHTML = "";
                _data.data.forEach( value => {
                    append_options_parent.insertAdjacentHTML( "beforeend", `<option value="${value.ID}">${value.title}</option>` );
                } );
    
            } else {
                sweetAlertError( _data.message );
            }
        }
    
        ajaxFetch( RoutesAdmin.lessonListHeadByPackage, success_function, fetch_data );
    } );
}