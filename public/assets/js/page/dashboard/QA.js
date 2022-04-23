class QA { //question and answer

    get deleteQASelector() {
        return document.getElementById( "delete_QA" );
    }

    deleteQAHandlerSuccess = () => {
        window.location.href = route.question_answer_index;
    }

    deleteQAHandler = () => {
        sweet_alert_confirm( {
            title: "توجه",
            message: "آیا از ادامه عملیات اطمینان دارید؟ این کار غیر قابل بازگردانی است!",
            type_2: "info"
        }, () => {
            const fetch_data = {
                method: "post",
                data: {
                    question_ID: url_param().get( "qa-id" )
                }
            };
    
            ajax_fetch( route.question_answer_delete, this.closeQAHandlerSuccess, fetch_data );
        } );
    }

    deleteQA = () => {
        this.deleteQASelector && this.deleteQASelector.addEventListener( "click", this.deleteQAHandler );
    }

    get closeQASelector() {
        return document.getElementById( "close_QA" );
    }

    closeQAHandlerSuccess = () => {
        window.location.reload();
    }

    closeQAHandler = () => {
        sweet_alert_confirm( {
            title: "توجه",
            message: "آیا از ادامه عملیات اطمینان دارید؟ این کار غیر قابل بازگردانی است!",
            type_2: "info"
        }, () => {
            const fetch_data = {
                method: "post",
                data: {
                    question_ID: url_param().get( "qa-id" )
                }
            };
    
            ajax_fetch( route.question_answer_close, this.closeQAHandlerSuccess, fetch_data );
        } );
    }

    closeQA = () => {
        this.closeQASelector && this.closeQASelector.addEventListener( "click", this.closeQAHandler );
    }

    get tableRowSelectorAll() {
        return document.querySelectorAll( "#table_QA_patient > tbody > tr" );
    }

    showQADetailHandler = ( event ) => {
        const QA_ID = event.target.closest( "tr" ).getAttribute( "data-id" );

        window.location.href = route.question_answer_show_detail + "?qa-id=" + QA_ID;
    }

    showQADetail = () => {
        this.tableRowSelectorAll.forEach( row => {
            row.addEventListener( "click", this.showQADetailHandler );
        } );
    }

    get tablaQASelector() {
        return document.getElementById( "table_QA_patient" );
    }

    showQAHTML = ( idx, question ) => {
        return `
        <tr data-id="${ question.ID }">
            <td>${ idx + 1 }</td>
            <td>${ question.created_at }</td>
            <td>${ question.question }</td>
            <td>${ question.status }</td>
            <td>${ question.show }</td>
            <td>${ question.updated_at }</td>
        </tr>`;
    }

    appendQAHandler = ( response ) => {
        if ( response.data.length < 1 ) return;

        data_store.question_answer_patient = response.data;

        data_store.question_answer_patient.forEach( ( row, index ) => {
            this.tablaQASelector.querySelector( "tbody" ).insertAdjacentHTML( "beforeend", this.showQAHTML( index, row ) );
        } );

        this.showQADetail();
    }

    appendQA = () => {
        const fetch_data = {
            method: "get",
            data: {}
        };

        ajax_fetch( route.question_answer_show, this.appendQAHandler, fetch_data );
    }

    showQA = () => {
        this.tablaQASelector && this.appendQA();
    }

    get submitQASelector() {
        return document.getElementById( "submit_QA" );
    }

    successAlert = ( response ) => {
        sweet_alert_message( response, () => {
            if ( response.status === "success" ) window.location.href = route.question_answer_index;
        } );
    }

    submitQAHandler = ( event ) => {
        const textarea_QA   = document.getElementById( "textarea_QA" ).value;
        const show_QA       = document.getElementById( "QA_publish_type_private" ).checked ? 0 : 1;

        const data_type = event.target.getAttribute( "data-type" );

        if ( textarea_QA.length < 10 ) {
            sweet_alert_message( {
                title: "توجه",
                message: Alert.error( 116 ),
                type_2: "info",
            } );

            return;
        }

        if ( ! data_type ) {
            sweet_alert_message( {
                title: "توجه",
                message: Alert.error( -1 ),
                type_2: "info",
            } );

            return;
        }

        const fetch_data = {
            method: "post",
            data: {
                question: textarea_QA,
                show    : show_QA,
                type    : 0,
                question_ID: url_param().get( "qa-id" ),      
            }
        };

        let submit_route = route.question_answer_submit;
        if ( data_type !== "question" && data_type === "answer" ) submit_route = route.question_answer_submit_answer;
        else submit_route = null;

        if ( ! submit_route ) {
            sweet_alert_message( {
                title: "توجه",
                message: Alert.error( -1 ),
                type_2: "info",
            } );

            return;
        }

        ajax_fetch( submit_route, this.successAlert, fetch_data );
    }

    submitQA = () => {
        this.submitQASelector && this.submitQASelector.addEventListener( "click", this.submitQAHandler );
    }

    get createQASelector() {
        return document.getElementById( "create_QA" );
    }

    goToCreatePage = () => {
        window.location.href = route.question_answer_create;
    }

    createQAHandler = () => {
        this.createQASelector && this.createQASelector.addEventListener( "click", this.goToCreatePage );
    }

    init = () => {
        this.createQAHandler();
        this.submitQA();
        this.showQA();
        this.closeQA();
        this.deleteQA();
    }

    static run = () => {
        const qa = new QA;

        qa.init();
    }
}

doc_ready( QA.run );