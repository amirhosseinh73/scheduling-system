function docReady(fn) {
    // see if DOM is already available
    if (document.readyState === "complete" || document.readyState === "interactive") {
        // call on next available tick
        setTimeout(fn, 1);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

/**
 * @param {string} _url
 * @param {function} _successFn
 * @param {object} _data { method, headers, data }
 */
async function ajaxFetch( _url, _successFn, _data ) {
    document.body.insertAdjacentHTML( "beforeend", html_loading() );
    const form_data = new FormData();
    if ( _data.method.toUpperCase() === "POST" ) {
        for ( const key in _data.data ) {
            form_data.append( key , _data.data[key] );
        }
    }
    return fetch( _url , {
        method:  _data.method,
        // headers: _data.headers,
       ...( ( _data.method.toUpperCase() === "POST" ) && { body: form_data } ),
    } )
    .then( ( response ) => response.json() )
        //Then with the data from the response in JSON...
    .then( ( data ) => {
        document.getElementById( "preloader" ).remove();
        return _successFn( data );
    } )
        //Then with the error genereted...
    .catch( ( error ) => {
        document.getElementById( "preloader" ).remove();
        console.error( 'Error:', error );
    } );
}

function alertHtmlLtr( _id = "", _type = "danger", _message = "", _effect = "opacity" ) {
    return `<div id="${_id}" class="alert alert-${_type} dir-ltr text-right transition-alert-${_effect}">
    ${_message}
    </div>`;
}

function alertHtmlRtl( _id = "", _type = "danger", _message = "", _effect = "opacity" ) {
    return `<div id="${_id}" class="alert alert-${_type} text-left transition-alert-${_effect}">
    ${_message}
    </div>`;
}

/**
 * @param {array|object} _data array of object
 * @returns {string} html
 */
function tableRowHtml( _data ) {
    if ( ! _data ) return;
    if ( typeof _data === "object" ) {
        for ( const key in _data ) {
            if ( key === "all_packages" ) {
                AllPackages = _data[key];
                continue;
            }
            if ( key === "all_heads" ) {
                AllHeads = _data[key];
                continue;
            }
            if ( key === "all_users" ) {
                AllUsers = _data[key];
                continue;
            }
        }
        delete _data.all_packages;
        delete _data.all_heads;
        delete _data.all_users;
        _data = Object.values(_data);
    }
    return _data.map( ( _value, _index, _array ) => {
        let html = "";
        let ID;
        html += `<tr class="table-item-parent"><td>${_index + 1}</td>`;
        for ( const _key in _value ) {
            if ( _key === "ID" ) {
                ID = _value[_key];
                continue;
            };
            if ( _key === "image" ) html += `<td><img width="75" height="75" src="${_value[_key]}" /></td>`;
            else if ( _key === "package_ID" || _key === "head_ID" ) html += `<td class="d-none" data-key="${_key}">${_value[_key]}</td>`;
            //for active packages in license
            else if ( _value[_key] instanceof Array ) {
                html += `<td data-key="${_key}">`;
                _value[_key].forEach( value => {
                    html += `<span data-id="${value.ID}" class="badge badge-secondary mx-1">${value.name}</span>`;
                } );
                html +=`</td>`;
            }
            else html += `<td data-key="${_key}">${_value[_key]}</td>`;
        }
        html += `<td>
        <button type="button" class="btn btn-info waves-effect waves-light btn-block btn-edit" data-id="${ID}">ویرایش</button>
        <button type="button" class="btn btn-danger waves-effect waves-light btn-block btn-remove" data-id="${ID}">حذف</button>
        </td>
        </tr>`;
        return html;
    } ).join('\n');
}


function urlParam() {
    return new URLSearchParams(window.location.search);
}

function historyURL( _data ) {
    window.history.pushState({"html":_data.html,"pageTitle":_data.pageTitle},"", _data.url);
}

function sweetAlertConfirm( _callback = () => {} ) {
    Swal.fire({
        title: "آیا اطمینان دارید؟",
        text: "قادر به بازگردانی این عمل نخواهید بود!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: "بله!",
        cancelButtonText: 'انصراف',
    }).then(function (result) {
        if (result.value) {
            _callback();
        }
    });
}

function sweetAlertSuccess( message = "عملیات با موفقیت انجام شد." ) {
    Swal.fire({
        title: "موفقیت!",
        text: message,
        type: "success",
        confirmButtonText: 'باشه',
    });
}

function sweetAlertError( message = "متاسافنه عملیات انجام نشد!" ) {
    Swal.fire({
        title: "خطا!",
        text: message,
        type: "error",
        confirmButtonText: 'باشه',
    });
}

if (!String.prototype.format) {
    String.prototype.format = function() {
      var args = arguments;
      return this.replace(/{(\d+)}/g, function(match, number) { 
        return typeof args[number] != 'undefined'
          ? args[number]
          : match
        ;
      });
    };
}

function grade_num( grade ) {
    switch ( grade.toUpperCase() ) {
        case "LOWER PRIMARY":
            return 1;
        case "UPPER PRIMARY":
            return 2;
        case "LOWER SECONDARY":
            return 3;
        case "UPPER SECONDARY":
            return 4;
        default:
            return "";
    }
}

function input_text_number() {
    const input = document.querySelectorAll( "input[type='text'][data-type='number']" );
    
    input.forEach( item => {
        item.addEventListener( "keyup", function( event ) {
            if (event.which === 116) window.location.reload();

            if ( (event.which < 48 || event.which > 57)) {
                //  && event.which !== 190
                // event.preventDefault();
                // return false;
                this.value = this.value.replace(/[^\d]+/g,'');
            }
        } );
    } );
}

docReady( function() {
    input_text_number();
} );

function html_loading() {
    return `<div id="preloader" style="opacity: 70%">
        <div id="status">
            <div class="spinner-chase">
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
            </div>
        </div>
    </div>`;
}