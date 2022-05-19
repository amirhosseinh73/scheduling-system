<article class="col align-content-center px-0 h-100">
    <div class="dashboard-main-container">
            <div class="col-12 h-100">
                <section class="row d-none">
                    <!-- <div class="col-12 col-sm-3">
                        <section class="search-box-parent">
                            <input type="text" class="custom-input-text" placeholder="نام متخصص خود را وارد کنید..."/>
                            <button type="button" class="btn-color-1 far fa-search"></button>
                        </section>
                    </div> -->
                    <div class="col-12 col-sm-3 me-3">
                        <section class="custom-select-box-parent">
                            <select class="custom-select-box">
                                <option value="none">نوع نوبت خود را انتخاب کنید.</option>
                                <option>تلفنی</option>
                                <option>حضوری</option>
                            </select>
                            <button type="button" class="btn-color-1 far fa-angle-down"></button>
                        </section>
                    </div>
                    <!-- <div class="col-12 col-sm-6 text-start">
                        <div class="row align-items-center">
                            <div class="col-12 col-sm-4">
                                <p class="text-dark-2 text-center font-size-0-7 mb-1">فیلتر تاریخ و زمان</p>
                            </div>
                            <div class="col-12 col-sm-4 font-size-0-7">
                                <span class="ms-2">از:</span>
                                <button type="button" class="btn-box-shadow dir-ltr">1400/02/03 08:30</button>
                            </div>
                            <div class="col-12 col-sm-4 font-size-0-7">
                                <span class="ms-2">تا:</span>
                                <button type="button" class="btn-box-shadow dir-ltr">1400/02/03 08:30</button>
                            </div>
                        </div>
                    </div> -->
                </section>

                <section class="dashboard-inside-container">
                    <form id="reservation_form" class="row h-100" method="POST">
                        <div class="col-6 col-sm-7 col-md-8 h-100">
                            <div class="inside-container-right">
                                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                    </symbol>
                                    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                    </symbol>
                                    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                    </symbol>
                                </svg>
                                <div class="alert alert-info alert-dismissible fade show pe-3" role="alert">
                                <svg class="bi flex-shrink-0 mx-1" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                                    لطفا دکتر مورد نظر حود را با توجه به تاریخ و نوع مشاوره انتخاب کنید
                                    <button type="button" class="btn-close font-size-0-6 p-2" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <!-- <p class='card-description-3'>
                                        <span>بیمه:</span>
                                        <abbr>نکمیلی</abbr>
                                        <abbr>تامین اجتماعی</abbr>
                                        <abbr>فولاد</abbr>
                                    </p> -->
                            </div>
                        </div>
                        <div class="col-6 col-sm-5 col-md-4 px-0 h-100">
                            <div class="inside-container-left row mx-0 d-none">
                                <div class="col-12">
                                    <h4 id="detail_name" class="title text-color-1 mt-3"></h4>
                                </div>
                                <div class="col-12">
                                    <!-- <div class="row mx-0 align-items-center">
                                        <div class="col ms-auto">
                                            <p class="description font-size-0-7 mb-0">روز خود را انتخاب کنید:</p>
                                        </div>
                                        <div class="col-auto ps-0 pe-1">
                                            <button type="button" class="btn-text fas fa-long-arrow-right text-dark-1"></button>
                                        </div>
                                        <div class="col-auto pe-0 ps-1">
                                            <button type="button" class="btn-text fas fa-long-arrow-left text-color-3"></button>
                                        </div>
                                    </div>
                                    <div class="row mx-0">
                                        <div class="col-6 px-1 my-1">
                                            <button type="button" class="btn-color-2 font-size-0-8 w-100">شنبه 09:30</button>
                                        </div>
                                        <div class="col-6 px-1 my-1">
                                            <button type="button" class="btn-color-2 font-size-0-8 w-100">شنبه 09:30</button>
                                        </div>
                                        <div class="col-6 px-1 my-1">
                                            <button type="button" class="btn-color-2 font-size-0-8 w-100">شنبه 09:30</button>
                                        </div>
                                        <div class="col-6 px-1 my-1">
                                            <button type="button" class="btn-color-1 font-size-0-8 w-100">شنبه 09:30</button>
                                        </div>
                                    </div> -->

                                    <!-- <div class="row mx-0 align-items-center mt-2">
                                        <div class="col ms-auto">
                                            <p class="description font-size-0-7 mb-0">ساعت خود را انتخاب کنید:</p>
                                        </div> -->
                                        <!-- <div class="col-auto ps-0 pe-1">
                                            <button type="button" class="btn-text fas fa-long-arrow-right text-dark-1"></button>
                                        </div>
                                        <div class="col-auto pe-0 ps-1">
                                            <button type="button" class="btn-text fas fa-long-arrow-left text-color-3"></button>
                                        </div> -->
                                    <!-- </div> -->
                                    <div id="more_detail" class="row mx-0">
                                        
                                    </div>
                                    <div id="choose_hour" class="row mx-0 choose-hour-booking">
                                        
                                    </div>

                                    <!-- <div class="row mx-0 align-items-center mt-4">
                                        <div class="col ms-auto">
                                            <p class="description font-size-0-7 mb-0">انتخاب بیمه:</p>
                                        </div>
                                    </div>
                                    <div class="row mx-0">
                                        <div class="col-6 px-1 my-1">
                                            <button type="button" class="btn-color-1 font-size-0-7 w-100">فولاد</button>
                                        </div>
                                        <div class="col-6 px-1 my-1">
                                            <button type="button" class="btn-color-2 font-size-0-7 w-100">تامین اجتماعی</button>
                                        </div>
                                        <div class="col-6 px-1 my-1">
                                            <button type="button" class="btn-color-2 font-size-0-7 w-100">تکمیلی</button>
                                        </div>
                                    </div> -->

                                    <div class="row mx-0 align-items-center mt-4">
                                        <div class="col ms-auto description mb-0 text-color-1"">
                                            <i class="fas fa-circle-info font-size-0-8 align-sub"></i>
                                            <abbr class="font-size-0-7">مبلغ قابل پرداخت:</abbr>
                                        </div>
                                        <div class="col-auto text-color-3 font-size-0-9">
                                            <span id="price_section"></span>
                                            <abbr>تومان</abbr>
                                        </div>
                                    </div>
                                    <div class="row mx-0 mb-3">
                                        <div class="col-12 px-1 my-1">
                                            <button type="submit" class="btn btn-success font-size-0-7 w-100">ثبت و پرداخت</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
</article>