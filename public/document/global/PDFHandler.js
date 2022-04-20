import PDFWorker from 'pdfjs-dist/build/pdf.worker.entry';
import PDFJS from 'pdfjs-dist';

PDFJS.GlobalWorkerOptions.workerSrc = PDFWorker;

export default class PDFHandler {

    callbackRenderFirstPage = () => {};
    callbackRenderEachPage = () => {};

    DEFAULTSCALE = 0.5;
    MOVEOFFSET   = 0.08;
    ZOOMOFFSET   = 0.0001;

    currentPage = 0;
    totalPages  = 0;
    pdfDoc      = null;
    rendering    = false;
    currentScale = this.DEFAULTSCALE;

    constructor( config = {}, events = {} ) {
        //config
        if (typeof config.DEFAULTSCALE !== "undefined") this.DEFAULTSCALE = config.DEFAULTSCALE;
        if (typeof config.MOVEOFFSET !== "undefined")   this.MOVEOFFSET = config.MOVEOFFSET;
        if (typeof config.ZOOMOFFSET !== "undefined")   this.ZOOMOFFSET = config.ZOOMOFFSET;

        //events
        if ( typeof events.callbackRenderFirstPage === "function" ) this.callbackRenderFirstPage = events.callbackRenderFirstPage;
        if ( typeof events.callbackRenderEachPage === "function" )  this.callbackRenderEachPage  = events.callbackRenderEachPage;
    }

    get inputSelector() {
        return document.getElementById( "upload_pdf" );
    }

    get nextPage() {
        return document.getElementById( "next" );
    }

    get previousPage() {
        return document.getElementById( "previous" );
    }

    get firstPage() {
        return document.getElementById( "first" );
    }

    get lastPage() {
        return document.getElementById( "last" );
    }

    get totalPageInput() {
        return document.getElementById( "page_count" );
    }

    get currentPageInput() {
        return document.getElementById( "page_current" );
    }

    get preLoader() {
        return document.getElementById( "preloader" );
    }

    get canvas() {
        return document.getElementById( "canvasPDF" );
    }

    get container() {
        return document.querySelector( ".container-pdf" );
    }

    async showPDF( url ) {
        try{
            this.preLoader.style.display = "flex";

            const pdfDoc = await PDFJS.getDocument( { url : url } ).promise;
    
            this.pdfDoc = pdfDoc;
            this.totalPages = this.pdfDoc.numPages;
            
            this.preLoader.style.display = "none";
            this.totalPageInput.value = this.totalPages;
    
            this.showPage( 1, true );
    
        } catch( error ) {
            this.preLoader.style.display = "none";
            
            console.error( error.message );  
        }
        
    }

    showPage( page_number, is_first_page = false ) {

        const CANVAS = this.canvas;
        const CANVAS_CTX = CANVAS.getContext('2d');

        this.currentPage = page_number;
    
        this.canvas.style.display = "none";
        this.preLoader.style.display = "flex";
        this.currentPageInput.value = this.currentPage;
    
        this.pdfDoc.getPage( this.currentPage )
        .then( ( page ) => {
            this.rendering = true;

            const scale_required = CANVAS.width / page.getViewport(1).width;
    
            const viewport = page.getViewport( scale_required );
            CANVAS.height = viewport.height;
    
            const render_context = {
                canvasContext: CANVAS_CTX,
                viewport: viewport
            };
            
            page.render( render_context ).promise.then( () => {
                this.rendering = false;
                
                this.canvas.style.display = "inline";
                this.preLoader.style.display = "none";

                if ( is_first_page ) this.handleEventAfterRender();

                this.callbackRenderEachPage();
            });
        });
    }

    handleEventAfterRender() {
        this.setScaleAndOffset();

        this.previousPageHandler();
        this.firstPageHandler();
        this.nextPageHandler();
        this.lastPageHandler();

        this.scrollHandler();

        this.callbackRenderFirstPage();
    }

    previousPageHandler() {
        this.previousPage.addEventListener( "click", () => {
            if( this.currentPage === 1 ) return;
            if ( this.rendering ) return;

            this.currentPage--;
            this.showPage( this.currentPage );
        } );
    }

    firstPageHandler() {
        this.firstPage.addEventListener( "click", () => {
            if( this.currentPage === 1 ) return;
            if ( this.rendering ) return;
            
            this.currentPage = 1;
            this.showPage( this.currentPage );
        } );
    }

    nextPageHandler() {
        this.nextPage.addEventListener( "click", () => {
            if( this.currentPage === this.totalPages ) return;
            if ( this.rendering ) return;

            this.currentPage++;
            this.showPage( this.currentPage );
        } );
    }

    lastPageHandler() {
        this.lastPage.addEventListener( "click", () => {
            if( this.currentPage === this.totalPages ) return;
            if ( this.rendering ) return;
            
            this.currentPage = this.totalPages;
            this.showPage( this.currentPage );
        } );
    }
    
    setScaleAndOffset() {
        // const old_width = this.container.offsetWidth;
        // const old_height = this.container.offsetHeight;

        this.container.style.width      = this.canvas.offsetWidth + "px";
        this.container.style.height     = this.canvas.offsetHeight + "px";
        this.container.style.transform  = "scale( " + this.DEFAULTSCALE + " )";
        this.container.style.top        = ( ( document.body.offsetHeight - this.canvas.offsetHeight ) / 2) + "px";
        this.container.style.left       = ( ( document.body.offsetWidth - this.canvas.offsetWidth ) / 2) + "px";

    }

    scrollHandler() {
        document.body.addEventListener( "wheel" , this.scrollHandlerEvent.bind( this ) );
    }

    scrollHandlerEvent( e ) {

        if ( e.shiftKey && ! e.altKey ) this.moveHandlerY( e );
        else if ( e.shiftKey && e.altKey ) this.moveHandlerX( e );
        else if ( ! e.shiftKey ) this.zoomHandler( e );

    }

    zoomHandler( e ) {
        if ( e.target.classList.contains( "area-select" ) ) return; // for scroll something else like textarea

        let scale = - e.deltaY * this.ZOOMOFFSET;
        const current_scale = this.container.getBoundingClientRect().width / this.container.offsetWidth;

        scale = current_scale + scale;

        if ( scale < 0.1 || scale > 1.5 ) return;

        this.container.style.transform = "scale( " + scale + " )";

        this.currentScale = scale;
    }

    moveHandlerY( e ) {
        let top = - e.deltaY * this.MOVEOFFSET;
        const current_top = this.container.offsetTop;

        top = current_top + top;

        if ( top > this.container.offsetHeight || top < -this.container.offsetHeight ) return;

        this.container.style.top = top + "px";
    }

    moveHandlerX( e ) {
        let left = - e.deltaY * this.MOVEOFFSET;
        const current_left = this.container.offsetLeft;

        left = current_left + left;

        if ( left > this.container.offsetWidth || left < -this.container.offsetWidth ) return;

        this.container.style.left = left + "px";
    }
}