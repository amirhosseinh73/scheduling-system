class QAPatient { //question and answer

    get deleteQASelector() {
        return document.getElementById( "delete_QA" );
    }

    deleteQAHandlerSuccess = ( response ) => {
        if ( response.status === "success" ) window.location.href = route.question_answer_index_patient;
        else sweet_alert_message( response );
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
    
            ajax_fetch( route.question_answer_delete_patient, this.closeQAHandlerSuccess, fetch_data );
        } );
    }

    deleteQA = () => {
        this.deleteQASelector && this.deleteQASelector.addEventListener( "click", this.deleteQAHandler );
    }

    get closeQASelector() {
        return document.getElementById( "close_QA" );
    }

    closeQAHandlerSuccess = ( response ) => {
        if ( response.status === "success" ) window.location.reload();
        else sweet_alert_message( response );
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
    
            ajax_fetch( route.question_answer_close_patient, this.closeQAHandlerSuccess, fetch_data );
        } );
    }

    closeQA = () => {
        this.closeQASelector && this.closeQASelector.addEventListener( "click", this.closeQAHandler );
    }

    get tablePrivateRowSelectorAll() {
        return document.querySelectorAll( "#table_QA_patient_private > tbody > tr" );
    }

    get tablePublicRowSelectorAll() {
        return document.querySelectorAll( "#table_QA_patient_public > tbody > tr" );
    }

    showQADetailHandler = ( event ) => {
        const QA_ID = event.target.closest( "tr" ).getAttribute( "data-id" );

        window.location.href = route.question_answer_show_detail_patient + "?qa-id=" + QA_ID;
    }

    showQADetail = () => {
        this.tablePrivateRowSelectorAll.forEach( row => {
            row.addEventListener( "click", this.showQADetailHandler );
        } );

        this.tablePublicRowSelectorAll.forEach( row => {
            row.addEventListener( "click", this.showQADetailHandler );
        } );
    }

    get tablaQAPrivateSelector() {
        return document.getElementById( "table_QA_patient_private" );
    }

    get tablaQAPublicSelector() {
        return document.getElementById( "table_QA_patient_public" );
    }

    showQAPrivateHTML = ( idx, question ) => {
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

    showQAPublicHTML = ( idx, question ) => {
        return `
        <tr data-id="${ question.ID }">
            <td>${ idx + 1 }</td>
            <td>${ question.created_at }</td>
            <td>${ question.question }</td>
            <td>${ question.status }</td>
            <td>${ question.updated_at }</td>
        </tr>`;
    }

    appendQAHandler = ( response ) => {
        if ( response.data.length < 1 ) return;

        data_store.question_answer_list_1 = response.data.private;
        data_store.question_answer_list_2 = response.data.public;

        data_store.question_answer_list_1.forEach( ( row, index ) => {
            this.tablaQAPrivateSelector.querySelector( "tbody" ).insertAdjacentHTML( "beforeend", this.showQAPrivateHTML( index, row ) );
        } );

        data_store.question_answer_list_2.forEach( ( row, index ) => {
            this.tablaQAPublicSelector.querySelector( "tbody" ).insertAdjacentHTML( "beforeend", this.showQAPublicHTML( index, row ) );
        } );

        this.showQADetail();
    }

    appendQA = () => {
        const fetch_data = {
            method: "get",
            data: {}
        };

        ajax_fetch( route.question_answer_show_patient, this.appendQAHandler, fetch_data );
    }

    showQA = () => {
        this.tablaQAPrivateSelector && this.tablaQAPublicSelector && this.appendQA();
    }

    get submitQASelector() {
        return document.getElementById( "submit_QA" );
    }

    successAlert = ( response ) => {
        sweet_alert_message( response, () => {
            if ( response.status === "success" ) window.location.href = route.question_answer_index_patient;
        } );
    }

    submitQAHandler = ( event ) => {
        const textarea_QA   = document.getElementById( "textarea_QA" ).value;
        const show_QA       = document.getElementById( "QA_publish_type_private" ).checked ? 0 : 1;

        const data_type = event.target.getAttribute( "data-type" );

        if ( textarea_QA.length < 2 ) {
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

        let submit_route = route.question_answer_submit_patient;
        if ( data_type !== "question" && data_type === "answer" ) submit_route = route.question_answer_submit_answer_patient;
        else if ( data_type !== "question" && data_type !== "answer" ) submit_route = null;

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
        window.location.href = route.question_answer_create_patient;
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
        const qa = new QAPatient;

        qa.init();
    }
}

doc_ready( QAPatient.run );