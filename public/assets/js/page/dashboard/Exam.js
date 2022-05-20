class Exam {
    get examCardParentSelector() {
        return document.getElementById( "exam_cards_parent" );
    }

    get examPageParentSelector() {
        return document.getElementById( "exam_page_parent" );
    }

    get examPageQuestionOLSelector() {
        return this.examPageParentSelector.querySelector( "ol.ol-question" );
    }

    successAlert = ( response ) => {
        sweet_alert_message( response, () => {
            if ( response.status === "success" ) window.location.href = response.return_url;
        } );
    }

    submitExamHandler = ( event ) => {
        event.preventDefault();

        const select_all_question = this.examPageQuestionOLSelector.querySelectorAll( "li" );
        if ( ! select_all_question ) return;

        const all_questions_fetch_data = new Array;

        select_all_question.forEach( question => {
            const select_all_answer = question.querySelectorAll( "li" );
            if ( ! select_all_answer ) return;

            select_all_answer.forEach( answer => {
                answer = answer.querySelector( "input" );
                if ( ! answer.checked ) return;

                all_questions_fetch_data.push( {
                    question_ID: answer.dataset.idQuestion,
                    answer_ID: answer.dataset.idAnswer,
                    answer_text: answer.dataset.answerText,
                    exam_ID: question.dataset.examId
                } );
            } );
        } );

        console.log(all_questions_fetch_data);

        const fetch_data = {
            method: "post",
            data: {
                all_questions: JSON.stringify( all_questions_fetch_data ),
            }
        };

        ajax_fetch( route.exam_submit, this.successAlert, fetch_data );
    }

    submitExam = () => {
        this.examPageParentSelector.addEventListener( "submit", this.submitExamHandler )
    }

    checkBoxHTML = ( question, answer ) => {
        return `<li class="answer-checkbox">
                    <input id="q_${ question.ID }_a_${ answer.ID }" data-id-answer="${ answer.ID }" data-id-question="${ question.ID }" data-answer-text="${ answer.text }" name="q_${ question.ID }" type="checkbox"/>
                    <label for="q_${ question.ID }_a_${ answer.ID }">${ answer.text }</label>
                </li>`;
    }

    radioHTML = ( question, answer ) => {
        return `<li class="answer-radio">
                    <input id="q_${ question.ID }_a_${ answer.ID }" data-id-answer="${ answer.ID }" data-id-question="${ question.ID }" data-answer-text="${ answer.text }" name="q_${ question.ID }" type="radio"/>
                    <label for="q_${ question.ID }_a_${ answer.ID }">${ answer.text }</label>
                </li>`;
    }

    questionHTML = ( question, answer ) => {
        let question_type;
        switch( question.type ) {
            case "checkbox":
                question_type = this.checkBoxHTML;
                break;
            case "radio":
                question_type = this.radioHTML;
                break;
        }
        if ( ! question_type ) return;

        return `<li data-exam-id="${ question.exam_ID }">
                    <p>${ question.question }</p>
                    <div class="row">
                        <ol class="ol-selection">
                            ${
                                answer.map( answer_item => {
                                    return question_type( question, answer_item );
                                } ).join( "" )
                            }
                        </ol>
                    </div>
                </li>`;
    }

    handlePageData = ( response ) => {
        response.data.forEach( question => {

            this.examPageQuestionOLSelector.insertAdjacentHTML( "beforeend", this.questionHTML( question, question.answer ) );
        } );
    }

    loadPageData = () => {
        const ID = url_param().get( "id" );

        if ( ! ID ) return;

        const fetch_data = {
            method: "get",
            data: {}
        };

        ajax_fetch( route.exam_page_data + "?id=" + ID, this.handlePageData, fetch_data );
    }

    examHTML = ( exam ) => {
        return `<section class="appointment-card small">
                    <a href="${ route.exam_page + "?id=" + exam.ID }" class="link-absolute"></a>
                    <img src="${ exam.image }"/>
                    <div>
                        <h5 class="card-title">${ exam.title }</h5>
                        <p class="card-description-2">
                            <span>تعداد سوالات</span>
                            <abbr>${ exam.questions_count }</abbr>
                        </p>
                        <p class="card-description-2">
                            ${ exam.description }
                        </p>
                        <!--<p class="card-description-2">
                            <span>زمان</span>
                            <abbr>
                            ${ exam.time }
                            دقیقه
                            </abbr>
                        </p>-->
                        <p class="card-description-3 text-color-3">برای شروع آزمون کلیک کنید.</p>
                    </div>
                </section>`;
    }

    handleExamData = ( response ) => {
        response.data.forEach( exam => {
            this.examCardParentSelector.insertAdjacentHTML( "beforeend", this.examHTML( exam ) );
        });
    }

    loadExamData = () => {
        const fetch_data = {
            method: "get",
            data: {}
        };

        ajax_fetch( route.exam_data, this.handleExamData, fetch_data );
    }

    init = () => {
        this.examCardParentSelector && this.loadExamData();
        this.examPageParentSelector && this.loadPageData();
        this.examPageParentSelector && this.submitExam();
    }

    static run = () => {
        const exam = new Exam;
        exam.init();
    }
}

doc_ready( Exam.run );