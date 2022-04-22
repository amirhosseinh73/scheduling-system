class QA { //question and answer

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

    submitQAHandler = () => {
        const textarea_QA   = document.getElementById( "textarea_QA" ).value;
        const show_QA       = document.getElementById( "QA_publish_type_private" ).checked ? 0 : 1;

        if ( textarea_QA.length < 10 ) {
            sweet_alert_message( {
                title: "توجه",
                message: Alert.error( 116 ),
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
            }
        };

        ajax_fetch( route.question_answer_submit, this.successAlert, fetch_data );
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
    }

    static run = () => {
        const qa = new QA;

        qa.init();
    }
}

doc_ready( QA.run );