<article class="col align-content-center px-0 h-100">
    <div class="dashboard-main-container">
        <div class="col-12 h-100">
            <section class="row">
                <div class="col-12 col-sm-3 me-auto text-start">
                    <button id="create_QA" type="button" class="btn-color-1">ثبت سوال جدید</button>
                </div>
            </section>
            <section class="dashboard-inside-container scroll height-scroll-less">
                <div class="accordion accordion-flush accordion-active-color-2" id="faq_accordion">
                    <section class="accordion-item">
                        <h2 class="accordion-header" id="faq_q_1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#faq_a_1" aria-expanded="false" aria-controls="faq_a_1">
                                <p class="mb-0 d-block w-100 text-center">پرسش های من</p>
                            </button>
                        </h2>
                        <div id="faq_a_1" class="accordion-collapse collapse show" aria-labelledby="faq_q_1" 
                            data-bs-parent="#faq_accordion">
                            <div class="accordion-body">
                                <table id="table_QA_patient_private" class="table table-responsive table-secondary table-striped table-bordered table-hover mb-0 font-size-0-8 table-pointer">
                                    <thead>
                                        <tr>
                                        <th scope="col">ردیف</th>
                                        <th scope="col">تاریخ ایجاد</th>
                                        <th scope="col">سوال</th>
                                        <th scope="col">وضعیت</th>
                                        <th scope="col">نمایش</th>
                                        <th scope="col">آخرین به روز رسانی</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>

                    <section class="accordion-item">
                        <h2 class="accordion-header" id="faq_q_2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#faq_a_2" aria-expanded="false" aria-controls="faq_a_2">
                                <p class="mb-0 d-block w-100 text-center">پرسش های عمومی کاربران</p>
                            </button>
                        </h2>
                        <div id="faq_a_2" class="accordion-collapse collapse" aria-labelledby="faq_q_2" 
                            data-bs-parent="#faq_accordion">
                            <div class="accordion-body">
                                <table id="table_QA_patient_public" class="table table-responsive table-secondary table-striped table-bordered table-hover mb-0 font-size-0-8 table-pointer">
                                    <thead>
                                        <tr>
                                        <th scope="col">ردیف</th>
                                        <th scope="col">تاریخ ایجاد</th>
                                        <th scope="col">سوال</th>
                                        <th scope="col">وضعیت</th>
                                        <th scope="col">آخرین به روز رسانی</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </section>
        </div>
    </div>
</article>