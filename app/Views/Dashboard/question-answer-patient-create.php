<article class="col align-content-center px-0 h-100">
    <div class="dashboard-main-container">
        <div class="col-12 h-100">
            <a href="<?= base_url( "/dashboard/question-answer/patient" )?>" class="btn-back fas fa-arrow-alt-right"></a>
            <section class="dashboard-inside-container scroll height-scroll-less mt-5">
                <div class="col-12 h-100">
                    <div class="inside-container-center px-2 align-items-center h-auto overflow-hidden">
                        <div class="col-12">
                            <h5 class="title text-black">پرسش خود را مطرح کنید.</h5>
                        </div>
                        <div class="col-12 mt-3">
                            <textarea id="textarea_QA" class="form-control" rows="10"></textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4">
                            <section class="row">
                                <div class="col-auto">
                                    <p class="title small mb-0">نحوه انتشار پرسش شما:</p>
                                </div>
                                <div class="col-2 ms-3">
                                    <div class="answer-radio">
                                        <input id="QA_publish_type_private" name="QA_publish_type" type="radio" checked/>
                                        <label for="QA_publish_type_private">خصوصی</label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="answer-radio">
                                        <input id="QA_publish_type_public" name="QA_publish_type" type="radio"/>
                                        <label for="QA_publish_type_public">عمومی</label>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-12 col-sm-3 me-auto text-start mt-4">
                            <button id="submit_QA" data-type="question" type="button" class="btn-color-1">ثبت سوال</button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</article>