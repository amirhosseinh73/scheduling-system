class PopupIframe {
    static run( config = {} ) {
        const popupWindow = new PopupIframe();
        popupWindow.setConfig( config );
        popupWindow.show();

        return popupWindow.box;
    }

    static hide() {
        const popupWindow = new PopupIframe();
        popupWindow.close();
    }

    get container () {
        return document.querySelector('#ibv_popup_iframe_article');
    }
    get box() {
        return document.querySelector('#ibv_popup_iframe_box');
    }

    get header(){
        return document.querySelector('#ibv_popup_header');
    }

    get body() {
        return document.querySelector('#popup_body');
    }

    get closeButton() {
        return document.querySelector('#ibv_popup_btn_close');
    }
    get helpButton() {
        return document.querySelector('#ibv_popup_btn_help');
    }
    get fullscreenButton() {
        return document.querySelector('#ibv_popup_btn_fullscreen');
    };

    options = {
        url         : "",
        title       : "",

        //size
        width       : window.innerWidth,
        height      : window.innerHeight,
        minHeight   : 150,
        minWidth    : 200,

        //items
        has_header  : true,
        close       : true,
        help        : false,
        fullscreen  : true,
        save        : false,
        saveEvent   : () => {},

        draggable   : true,
        resizable   : true,
        
        type        : "iframe",//image | audio | video
    }

    constructor() {

        //position
        this.options = { 
            ...this.options, 
            ...{
            top        : ( window.innerHeight / 2 ) - ( this.options.height / 2 ),
            left       : ( window.innerWidth / 2 )  - ( this.options.width / 2 ),
            },
            isLoadingEnabled : false
        };
    }

    setConfig( options = {} ) {

        this.options = { ...this.options, ...options }
        
    }

    async _removeLoading(){
        const element = this.body.querySelector('.popup-fix-loading')
        if(!element) return this.options.isLoadingEnabled = false;

        const callbackStyle = () => $(element).css('opacity', 0);
        await this._addStyleWithTransition(element, callbackStyle);
        element.remove();
        
        this.options.isLoadingEnabled = false;
    }

    _enableLoading(){
        this.body.insertAdjacentHTML('afterbegin', this._generateLoadingHTML());

        const loadingElement = document.querySelector('.popup-fix-loading');
        //avoid batching reflows
        loadingElement.offsetWidth;

        loadingElement.style.opacity = '.86';
        this.options.isLoadingEnabled = true;

    }

  
    toggleLoading(){
        if( !this.options.isLoadingEnabled ) return this._enableLoading();
        if( this.options.isLoadingEnabled ) return this._removeLoading();
    }

    _generateLoadingHTML(){
        return`
            <div class="popup-fix-loading">&nbsp;</div>
        `
    }
    
    _generateArticleHTML(){
        return `<article id="ibv_popup_iframe_article" class="popup-art-box ${this.options.type}"></article>`
    }

    _generateMainBoxHTML(){
        return `<div id="ibv_popup_iframe_box" class="popup-window">
                   <div id="popup_body" class="body">
                      ${ this.selectPopupTypeHTML[this.options.type] }
                   </div>           
                </div>`
    }

    _generateBoxHeaderHTML() {
        return `<div id="ibv_popup_header" class="popup-window-header">
                    <p class="ml-auto">${ this.options.title }</p>
                </div>`
    }

    _generateCloseButtonHTML(){
        return `<button id="ibv_popup_btn_close" type="button" class="btn btn-white rounded-circle close_modal">
                    <i class="fas fa-times align-middle"></i>
                </button>`
    }

    _generateFullscreenButtonHTML(){
        return `<button id="ibv_popup_btn_fullscreen" type="button" class="btn btn-outline-white rounded-circle" data-action="open">
                    <i class="fas fa-expand align-middle"></i>
                </button>`
    }

    _generateHelpButtonHTML(){
        return `<button id="ibv_popup_btn_help" type="button" class="btn btn-outline-white rounded-circle">
                    <i class="fas fa-question align-middle"></i>
                </button>`
    }

    _generateSaveButtonHTML(){
        return `<button id="ibv_popup_btn_save" type="button" class="btn btn-outline-white rounded-circle">
                    <i class="fas fa-floppy-disk align-middle"></i>
                </button>`
    }

    renderHeader(){
        if ( this.options.has_header ){
            this.box.classList.add('has-header');
            this.box.insertAdjacentHTML('afterbegin', this._generateBoxHeaderHTML.call(this) );

            if ( this.options.close ){
                this.header.insertAdjacentHTML('beforeend', this._generateCloseButtonHTML.call(this) );
            }

            if ( this.options.fullscreen ) {
                this.header.querySelector( "p" ).insertAdjacentHTML('afterend', this._generateFullscreenButtonHTML.call(this) );

                this.fullscreenChangeHandler( "ibv_popup_btn_fullscreen" );
            }

            if ( this.options.help ){
                this.header.querySelector( "p" ).insertAdjacentHTML('afterend', this._generateHelpButtonHTML.call(this) );

                //TODO: help button event
            }

            if ( this.options.save ){
                this.header.querySelector( "p" ).insertAdjacentHTML('afterend', this._generateSaveButtonHTML.call(this));

            }
        }
    }

    show() {
        this.close(); // close if popup exist

        const body = window.document.body;

        body.insertAdjacentHTML('beforeend', this._generateArticleHTML.call(this) );


        this.container.insertAdjacentHTML('afterbegin', this._generateMainBoxHTML.call(this) );


        this.renderHeader();

        if ( this.options.draggable ){
            this.draggableEvent();
        }

        if ( this.options.resizable ){
            this.resizableEvent();
        }

        //popup-window style
        if ( this.options.width === window.innerWidth && this.options.height === window.innerHeight) this.box.classList.add('fullscreen');

        this.box.style.cssText = `
            width: ${this.options.width}px;
            height: ${this.options.height}px;
        `;

        this.container.offsetWidth; // add a delay between append html and add class for transition
        this.container.classList.add('popup-show');

        this.initEvents();

        this._addContentHtmlToOptions();
    }

    _addContentHtmlToOptions(){
        this.options.content = this.body.firstElementChild;
    }

    initEvents(){
        //close
        this.closeEvent();

        if ( ! this.options.has_header ) return;
        //close with button 
        if( this.options.close ) this.addCloseButtonEventHandler();

        //save
        if( this.options.save ) this.addSaveButtonEventHandler();

        //fullscreen
        if( this.options.fullscreen ) this.addFullscreenButtonEventHandler();

        //help
        if( this.options.help ) this.addClickHelpButtonEventHandler()
    }

    close() {
        if ( this.container ) {
            this.container.classList.add('popup-hide');
            setTimeout( () => this.container.remove(), 300 ); //css transition set 300ms
        };
    }

    closeEvent() {
        this.container.addEventListener( "click", () => {
            this.close(); // this -> class
        } );

        this.box.addEventListener( "click", function(e) {
            e.stopPropagation();
        } );
    }

    get selectPopupTypeHTML(){
        return {
            'iframe'  : `<iframe src="${ this.options.url }" class="box-item" ></iframe>`,
            "video"   : `<video src="${ this.options.url }" class="box-item" controls autoplay>
                            <source src="${ this.options.url }" type="video/mp4"/>
                        </video>`,
            "audio"   : `<audio src="${ this.options.url }" class="box-item" controls autoplay>
                            <source src="${ this.options.url }" type="audio/mpeg"/>
                        </audio>`,
            "image"   : `<img src="${ this.options.url }" class="box-item" />`,

        }
    }

    /**
     * 
     * @param {HtmlElement} elem element to add style with transition
     * @param {Function} styleCallBack callback function to run your styles
     * @param {String} transition 
     * @returns 
     */
    async _addStyleWithTransition(elem = this.box, styleCallBack, transition ='all .3s'){
       return new Promise(resolve => {
            const onTransitionEnd = () => {
                elem.removeEventListener('transitionend',onTransitionEnd);
                return resolve();
            };
            if(!elem) throw new Error('elem not found');

            elem.addEventListener('transitionend', onTransitionEnd);
            elem.style.transition = transition;
            styleCallBack();
        }).then(() => {
            elem.style.transition = 'unset';
        }).catch(err => {
            console.log(err);
        })
    }


    _rePositionBoxInOutOfWindow(){
        const box           = this.box;
        const boxWidth      = box.offsetWidth;
        const boxHeight     = box.offsetHeight;
        const containerWidth = this.container.offsetWidth;
        const containerHeight = this.container.offsetHeight;

        let dragged_pos = {
            left: parseInt($(box).css('left')),
            top: parseInt($(box).css('top'))
        };

        const rightOffset   = dragged_pos.left + boxWidth;
        const bottomOffset  = dragged_pos.top + boxHeight
        const maxRightPosition = containerWidth - boxWidth;
        const maxBottomPosition = containerHeight - boxHeight;
        

        if (dragged_pos.left < 0) {
            this._addStyleWithTransition(box, () => $(box).css('left', 0))
        } 
        if ( rightOffset > containerWidth) {
            this._addStyleWithTransition(box, () => $(box).css('left', maxRightPosition))
        }
        if (dragged_pos.top < 0) {
            this._addStyleWithTransition(box, () => $(box).css('top', 0))
        } 
        if (bottomOffset > containerHeight) {
            this._addStyleWithTransition(box, () => $(box).css('top', maxBottomPosition))
        }

    }

    draggableEvent() {
        this.box.classList.add( "draggable" );
        const _this = this;

        $( this.box ).draggable({
            handle: $('#ibv_popup_header'),
            start: function( event, ui ) {
                $( this ).find( ".body" ).css( {
                    "pointer-events": "none",
                } );
            },
            stop: function( event, ui ) {
                $( this ).find( ".body" ).css( {
                    "pointer-events": "initial",
                } );

                _this._rePositionBoxInOutOfWindow();
            }
        });
    }

    resizableEvent() {
        this.box.classList.add( "resizable" );
        const {minHeight, minWidth} = this.options;

        $(this.box).resizable( {
            minHeight,
            minWidth,
            maxHeight: window.innerHeight,
            maxWidth: window.innerWidth,
            start: function( event, ui ) {
                $( this ).parent().css( {
                    "pointer-events": "none",
                } );
            },
            stop: function( event, ui ) {
                $( this ).parent().css( {
                    "pointer-events": "initial",
                } );
            }
        } );
    }

    addCloseButtonEventHandler(){
        this.closeButton.addEventListener( "click", () => {
            this.close(); // this -> class
        } );
    }

    addSaveButtonEventHandler(){
        document.getElementById( "ibv_popup_btn_save" ).addEventListener( "click", this.options.saveEvent.bind(this) );

    }

    addFullscreenButtonEventHandler() {
        document.getElementById( "ibv_popup_btn_fullscreen" ).addEventListener( "click", e => {
            const btn = e.target.closest( "#ibv_popup_btn_fullscreen" );
            const action = btn.dataset.action;
            if ( action === "open" )
                this.openFullscreen();
            else if ( action === "close" )
                this.closeFullscreen();
        } );
    }

    
    addClickHelpButtonEventHandler(){

    }

    openFullscreen() {
        // select iframe with id
        this.requestOpenFullscreen( this.box );
    }

    closeFullscreen() {
        this.requestCloseFullscreen();
    }

    requestOpenFullscreen( selector ) {
        if ( selector.requestFullscreen ) selector.requestFullscreen();
        else if ( selector.webkitRequestFullscreen ) selector.webkitRequestFullscreen(); // Safari
        else if ( selector.msRequestFullscreen ) selector.msRequestFullscreen(); // IE11
    }

    requestCloseFullscreen() {
        if ( document.exitFullscreen ) document.exitFullscreen();
        else if ( document.webkitExitFullscreen ) document.webkitExitFullscreen(); // Safari
        else if ( document.msExitFullscreen ) document.msExitFullscreen(); // IE11
    }

    fullscreenChangeHandler( id ) {
        document.onfullscreenchange = function() {
            const selector = document.getElementById( id );
            let selector_child;

            if( selector.dataset.action === "open" ) {
                selector.dataset.action = "close";

                selector_child = selector.querySelector( ".fa-expand" );
                
                selector_child.classList.remove( "fa-expand" );
                selector_child.classList.add( "fa-compress" );
            } else if ( selector.dataset.action === "close" ) {
                selector.dataset.action = "open";

                selector_child = selector.querySelector( ".fa-compress" );
                
                selector_child.classList.add( "fa-expand" );
                selector_child.classList.remove( "fa-compress" );
            }
        }
    }
}

const popupWindow = new PopupIframe();