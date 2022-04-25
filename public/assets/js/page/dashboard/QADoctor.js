class QADoctor { //question and answer

    get deleteQASelector() {
        return document.getElementById( "delete_QA" );
    }

    deleteQAHandlerSuccess = () => {
        window.location.href = route.question_answer_index_doctor;
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
    
            ajax_fetch( route.question_answer_delete_doctor, this.closeQAHandlerSuccess, fetch_data );
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
    
            ajax_fetch( route.question_answer_close_doctor, this.closeQAHandlerSuccess, fetch_data );
        } );
    }

    closeQA = () => {
        this.closeQASelector && this.closeQASelector.addEventListener( "click", this.closeQAHandler );
    }

    get submitQASelector() {
        return document.getElementById( "submit_QA" );
    }

    successAlert = ( response ) => {
        sweet_alert_message( response, () => {
            if ( response.status === "success" ) window.location.href = route.question_answer_index_doctor;
        } );
    }

    submitQAHandler = ( event ) => {
        const textarea_QA   = document.getElementById( "textarea_QA" ).value;

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
                type    : 0,
                question_ID: url_param().get( "qa-id" ),      
            }
        };

        ajax_fetch( route.question_answer_submit_answer_doctor, this.successAlert, fetch_data );
    }

    submitQA = () => {
        this.submitQASelector && this.submitQASelector.addEventListener( "click", this.submitQAHandler );
    }

    get table1RowSelectorAll() {
        return document.querySelectorAll( "#table_QA_doctor_not_answered > tbody > tr" );
    }

    get table2RowSelectorAll() {
        return document.querySelectorAll( "#table_QA_doctor_already_answered > tbody > tr" );
    }

    showQADetailHandler = ( event ) => {
        const QA_ID = event.target.closest( "tr" ).getAttribute( "data-id" );

        window.location.href = route.question_answer_show_detail_doctor + "?qa-id=" + QA_ID;
    }

    showQADetail = () => {
        this.table1RowSelectorAll.forEach( row => {
            row.addEventListener( "click", this.showQADetailHandler );
        } );

        this.table2RowSelectorAll.forEach( row => {
            row.addEventListener( "click", this.showQADetailHandler );
        } );
    }

    get tablaQANotAnsweredSelector() {
        return document.getElementById( "table_QA_doctor_not_answered" );
    }

    get tablaQAAlreadyAnsweredSelector() {
        return document.getElementById( "table_QA_doctor_already_answered" );
    }

    showQAHTML = ( idx, question ) => {
        return `
        <tr data-id="${ question.ID }">
            <td>${ idx + 1 }</td>
            <td>${ question.created_at }</td>
            <td>${ question.question }</td>
            <td>${ question.fullname_patient }</td>
            <td>${ question.show }</td>
            <td>${ question.updated_at }</td>
        </tr>`;
    }

    appendQAHandler = ( response ) => {
        if ( response.data.length < 1 ) return;

        data_store.question_answer_list_1 = response.data.not_answered;
        data_store.question_answer_list_2 = response.data.already_answered;

        data_store.question_answer_list_1.forEach( ( row, index ) => {
            this.tablaQANotAnsweredSelector.querySelector( "tbody" ).insertAdjacentHTML( "beforeend", this.showQAHTML( index, row ) );
        } );

        data_store.question_answer_list_2.forEach( ( row, index ) => {
            this.tablaQAAlreadyAnsweredSelector.querySelector( "tbody" ).insertAdjacentHTML( "beforeend", this.showQAHTML( index, row ) );
        } );

        this.showQADetail();
    }

    appendQA = () => {
        const fetch_data = {
            method: "get",
            data: {}
        };

        ajax_fetch( route.question_answer_show_doctor, this.appendQAHandler, fetch_data );
    }

    showQA = () => {
        this.tablaQANotAnsweredSelector && this.tablaQAAlreadyAnsweredSelector && this.appendQA();
    }

    init = () => {
        this.showQA();
        this.submitQA();
        this.closeQA();
        this.deleteQA();
    }

    static run = () => {
        const qa = new QADoctor;

        qa.init();
    }
}

doc_ready( QADoctor.run );