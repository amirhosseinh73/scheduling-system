const docReadyFunctions = function () {
    createHandlerEventSubmit();
    getListPackages();

    Paginate.route    = RoutesAdmin.packageCountPaginate;
    Paginate.history  = RoutesAdmin.packageListView;
    Paginate.request  = "GET";
    Paginate.callback = getListPackages; // function name
    getPaginateData();
};

docReady(docReadyFunctions);

function createHandlerEventSubmit() {
    const submit = document.getElementById( "package_create" );

    if ( ! submit ) return;

    submit.addEventListener( "submit", event => {
        event.preventDefault();
        createHandler();
    } );
}

function createHandler() {
    const title       = document.getElementById( "title" ).value;
    const description = document.getElementById( "description" ).value;
    const grade       = document.getElementById( "grade" ).value;
    const price       = document.getElementById( "price" ).value;
    const discount    = document.getElementById( "discount" ).value;
    const image       = document.getElementById( "image" );
    const submit      = document.getElementById( "package_create" );

    if( image.files[0] && ! [ "image/jpeg", "image/png", "image/jpg" ].includes( image.files[0].type ) ) {
		submit.insertAdjacentHTML( "afterbegin", alertHtmlRtl( "alert_form", "danger", "فقط تصویر jpg و png اجازه دارید.", "height" ) );
        return;
    }

    const fetch_data = {
        method: "post",
        data: {
            title: title,
            description: description,
            grade: grade,
            price: price,
            discount: discount,
            image: image.files[0],
        }
    };

    function success_function( _data ) {
        const exist_alert = document.getElementById( "alert_form" );

        if ( exist_alert ) exist_alert.remove();

        submit.insertAdjacentHTML( "afterbegin", alertHtmlRtl( "alert_form", _data.type, _data.message, "height" ) );
        
        if ( _data.status === "success" ) {
            submit.reset();
            document.getElementById( "created_packages_list" ).insertAdjacentHTML( "beforeend", tableRowHtml( _data.data ) );
        }
    }

    ajaxFetch( RoutesAdmin.packageCreate, success_function, fetch_data );
}

async function getListPackages() {

    const table_list_body = document.getElementById( "list_packages" );

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
        // window.scrollTo(0,document.body.scrollHeight);
    }

    await ajaxFetch( RoutesAdmin.packageList + "?" + Paginate.urlParams() , success_function, fetch_data );
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

            getListPackages();
            getPaginateData();
        }
    }

    ajaxFetch( RoutesAdmin.packageRemove, success_function, fetch_data );
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

    const select_exist_edit_html = document.getElementById( "package_edit_html" );

    if ( select_exist_edit_html !== null ) {
        select_exist_edit_html.closest( "tr" ).remove();
    }

    //select all td in that row of edited
    const all_td = this.closest( "tr" ).getElementsByTagName( "td" ); //0 is number of row

    const id        = +this.getAttribute( "data-id" );
    let title       = all_td[1].innerText.trim();
    let description = all_td[2].innerText.trim();
    let grade       = all_td[3].innerText.trim();
    let price       = all_td[4].innerText.trim();
    let discount    = all_td[5].innerText.trim();

    this.closest( "tr" ).insertAdjacentHTML( "afterend", `<tr><td colspan="10"> ${editHtml().format(
        title,
        description,
        grade_num( grade ),
        grade,
        price,
        discount,
        id
        )} </td></tr>` );

    // btn cancel edit
    this.closest( "tbody" ).querySelector( ".btn-cancel-html" ).addEventListener( "click", () => {
        document.getElementById( "package_edit_html" ).closest( "tr" ).remove();
    } );

    //call input type text accept number event
    input_text_number();

    //submit form edit
    const submit = document.getElementById( "package_edit" );

    if ( ! submit ) return;

    submit.addEventListener( "submit", event => {
        event.preventDefault();
        editHandlerSubmit.call( this );
    } );
}

function editHtml() {
    return `<article id="package_edit_html" class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <h4 class="card-title mb-4">ویرایش پکیج</h4>
                    </div>
                    <div class="col-3">
                        <button type="button" class="btn btn-danger btn-block waves-effect waves-light btn-cancel-html">انصراف</button>
                    </div>
                </div>
                <form id="package_edit" enctype="multipart/form-data">
                    <div class="row align-items-end">
                        <div class="col-12 col-sm-6 mb-4">
                            <label for="title">عنوان</label>
                            <input id="title" type="text" class="form-control" placeholder="عنوان" value="{0}"/>
                        </div>
                        <div class="col-12 col-sm-6 mb-4">
                            <label for="description">توضیحات</label>
                            <textarea id="description" type="text" class="form-control">{1}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mb-4">
                            <label for="grade">پایه</label>
                            <select id="grade" class="form-control custom-select">
                                <option value="{2}">{3}</option>
                                <optgroup label="لیست پایه ها">
                                    <option value="1">Lower Primary</option>
                                    <option value="2">Upper Primary</option>
                                    <option value="3">Lower Secondary</option>
                                    <option value="4">Upper Secondary</option>
                                </optgroup>
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
                            <label for="price">قیمت</label>
                            <input id="price" type="text" data-type="number" class="form-control" placeholder="قیمت" value="{4}"/>
                        </div>
                        <div class="col-12 col-sm-3 mb-4">
                            <label for="discount">تخفیف</label>
                            <input id="discount" type="text" data-type="number" class="form-control" placeholder="تخفیف" value="{5}"/>
                        </div>

                        <div class="col-12 col-sm-6 mb-4">
                            <button data-edit-id="{6}" type="submit" class="btn btn-success waves-effect waves-light btn-block">
                                ثبت
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</article>`;
}

function editHandlerSubmit() {
    const title       = document.getElementById( "title" ).value;
    const description = document.getElementById( "description" ).value;
    const grade       = document.getElementById( "grade" ).value;
    const price       = document.getElementById( "price" ).value;
    const discount    = document.getElementById( "discount" ).value;
    const image       = document.getElementById( "image" );
    const submit      = document.getElementById( "package_edit" );
    const ID          = this.getAttribute( "data-id" );

    if( image.files[0] && ! [ "image/jpeg", "image/png", "image/jpg" ].includes( image.files[0].type ) ) {
		submit.insertAdjacentHTML( "afterbegin", alertHtmlRtl( "alert_form", "danger", "فقط تصویر jpg و png اجازه دارید.", "height" ) );
        return;
    }

    const fetch_data = {
        method: "post",
        data: {
            title: title,
            description: description,
            grade: grade,
            price: price,
            discount: discount,
            image: image.files[0],
            ID: ID,
        }
    };

    function success_function( _data ) {
        
        if ( _data.status === "success" ) {
            sweetAlertSuccess( _data.message );

            document.getElementById( "package_edit_html" ).closest( "tr" ).remove();

            PaginateDataCache[Paginate.offset] = [];

            getListPackages();
            getPaginateData();

        } else {
            sweetAlertError( _data.message );
        }
    }

    ajaxFetch( RoutesAdmin.packageEdit, success_function, fetch_data );
}