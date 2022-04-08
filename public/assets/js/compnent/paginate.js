//start paginate
/**
 * @description start paginate function reusable
 * @param {number} _page_number 
 * @returns {string} html
 */
 function paginateHtml( _page_number ) {
    let html = "";
    let active = 0;
    if ( urlParam().has( "offset" ) ) active = +urlParam().get( "offset" );
    if ( _page_number > Paginate.max ) {

        if ( active > Paginate.min ) {
            html += `<li class="page-item page-number">
                <a class="page-link" href="javascript:void(1)">1</a>
            </li>`;

            html += '<li class="page-item page-number-dot"> ... </li>';
        }
        
        //prev page numbers
        if ( active > 0 ) {
            for ( let i = active - Paginate.min; i < active ; i++ ) {
                if ( i < 0 ) continue;
                html += `<li class="page-item page-number">
                    <a class="page-link" href="javascript:void(1)">${i + 1}</a>
                </li>`;
            }
        }

        //next page numbers
        let j = 0;
        for ( let i = active; i < _page_number; i++ ) {
            j++;
            html += `<li class="page-item page-number ${ active === i ? 'active' : '' }">
                <a class="page-link" href="javascript:void(1)">${i + 1}</a>
            </li>`;

            if ( j > Paginate.min ) break;
        }

        if ( active + 1 < _page_number - Paginate.min ) {
            html += '<li class="page-item page-number-dot"> ... </li>';
            html += `<li class="page-item page-number">
                <a class="page-link" href="javascript:void(1)">${_page_number}</a>
            </li>`;
        }
    } else {
        for ( let i = 0; i < _page_number; i++ ) {
            html += `<li class="page-item page-number ${ active === i ? 'active' : '' }">
                <a class="page-link" href="javascript:void(1)">${i + 1}</a>
            </li>`;
        }
    }
    return html;
}

function getPaginateData() {
    const paginate = document.querySelector( ".paginate-selector" );

    if ( ! paginate ) return;
    
    const fetch_data = {
        method: "get",
    };

    function success_function( _data ) {
        if ( _data.status === "success" ) {
            const total_items = +_data.data;
            Paginate.number   =  Math.ceil( total_items / Paginate.limit );
            
            paginateHandler();
        }
    }

    ajaxFetch( Paginate.route, success_function, fetch_data );
}

function paginateHandler() {
    const paginate = document.querySelector( ".paginate-selector" );
    
    if ( ! paginate ) return;

    const old_page_numbers = paginate.querySelectorAll( ".page-number" );
    const old_dot = paginate.querySelectorAll( ".page-number-dot" );
    if ( old_page_numbers.length > 0 ) {
        old_page_numbers.forEach( _element => {
            _element.remove(); 
        } );
    }
    if ( old_dot.length > 0 ) {
        old_dot.forEach( _element => {
            _element.remove(); 
        } );
    }
    
    paginate.querySelector( ".previous" ).insertAdjacentHTML( "afterend", paginateHtml( Paginate.number ) );

    //because of removing paginates, and append again, then must be call events again
    paginateHandlerEventClick();
}

function paginateHandlerEventClick() {
    const page_number = document.querySelector( ".paginate-selector" ).querySelectorAll( ".page-item.page-number" );

    if ( ! page_number ) return;

    //page umbers
    page_number.forEach( ( _value, _index, _array ) => {
        _value.querySelector( ".page-link" ).addEventListener( "click", async function () {
            const number = +this.innerHTML;
            Paginate.offset = number - 1;// -1 for offset start from 0
            await paginateInsideEvent();
        } );
    } );

    if ( Paginate.request !== "GET" ) return; //return for avoid trigger multiple events next and previous, previous and next written in HTML but page numbers remove and append by javascript

    //previous
    const previous = document.querySelector( ".paginate-selector" ).querySelector( ".previous" );
    if ( ! previous ) return;

    previous.querySelector( ".page-link" ).addEventListener( "click", async function () {
        const number = +this.closest( ".pagination" ).querySelector( ".active" ).querySelector( ".page-link" ).innerHTML;
        Paginate.offset = number - 1 - 1;// -1 for offset start from 0, -1 for previous page
        await paginateInsideEvent();
    } );

     //next
     const next = document.querySelector( ".paginate-selector" ).querySelector( ".next" );
     if ( ! next ) return;
 
     next.querySelector( ".page-link" ).addEventListener( "click", async function () {
         const number = +this.closest( ".pagination" ).querySelector( ".active" ).querySelector( ".page-link" ).innerHTML;
         Paginate.offset = number - 1 + 1;// -1 for offset start from 0, +1 for next page
         await paginateInsideEvent();
     } );
}

async function paginateInsideEvent() {
    if ( Paginate.offset > Paginate.number - 1 || Paginate.offset < 0 ) return;

    Paginate.request = "CLICK";
    await Paginate.callback();

    const data_url = {
        url: Paginate.history + "?" + Paginate.urlParams(),
    };
    historyURL( data_url );

    paginateHandler();
}
//end paginate