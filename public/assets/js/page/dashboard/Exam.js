class Exam {
    get examCardParentSelector() {
        return document.getElementById( "exam_cards_parent" );
    }

    get examPageParentSelector() {
        return document.getElementById( "exam_page_parent" ).querySelector( "ol.ol-question" );
    }

    checkBoxHTML = ( question, answer ) => {
        return `<li class="answer-checkbox">
                    <input id="q_${ question.ID }_a_${ answer.ID }" name="q_${ question.ID }" type="checkbox"/>
                    <label for="q_${ question.ID }_a_${ answer.ID }">${ answer.answer }</label>
                </li>`;
    }

    radioHTML = ( question, answer ) => {
        return `<li class="answer-radio">
                    <input id="q_${ question.ID }_a_${ answer.ID }" name="q_${ question.ID }" type="radio"/>
                    <label for="q_${ question.ID }_a_${ answer.ID }">${ answer.answer }</label>
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

        return `<li>
                    <p>${ question.question }</p>
                    <div class="row">
                        <ol class="ol-selection">
                            ${ question_type( question, answer ) }
                        </ol>
                    </div>
                </li>`;
    }

    handlePageData = ( response ) => {
        response.data.forEach( question => {
            
            this.examPageParentSelector.insertAdjacentHTML( "beforeend", this.questionHTML( question ) );
        } );
    }

    loadPageData = () => {
        const fetch_data = {
            method: "get",
            data: {}
        };

        ajax_fetch( route.exam_page_data, this.handlePageData, fetch_data );
    }

    examHTML = ( exam ) => {
        return `<section class="appointment-card small">
                    <a href="${ route.exam_page + "?id=" + exam.ID }" class="link-absolute"></a>
                    <img src="${ exam.image }"/>
                    <div>
                        <h5 class="card-title">${ exam.title }</h5>
                        <p class="card-description-2 mt-4">
                            <span>تعداد سوالات</span>
                            <abbr>${ exam.questions_count }</abbr>
                        </p>
                        <p class="card-description-2">
                            <span>زمان</span>
                            <abbr>
                            ${ exam.time }
                            دقیقه
                            </abbr>
                        </p>
                        <p class="card-description-3 text-color-3 mt-4">برای شروع آزمون کلیک کنید.</p>
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
    }

    static run = () => {
        const exam = new Exam;
        exam.init();
    }
}

doc_ready( Exam.run );