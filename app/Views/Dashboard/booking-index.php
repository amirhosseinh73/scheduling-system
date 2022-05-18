<article class="col align-content-center px-0 h-100">
    <div class="dashboard-main-container">
            <div class="col-12 h-100">
                <section class="row d-none">
                    <div class="col-12 col-sm-3 me-auto text-start">
                        <button type="button" class="btn-color-1">ثبت نوبت جدید</button>
                    </div>
                </section>

                <section class="dashboard-inside-container scroll">
                    <form id="booking_form" method="POST">
                        <section class="row align-items-center mb-5">
                            <div class="col-12 col-sm-5 col-md-4 col-xl-3 mb-2 mb-sm-0">
                                <p class="title small mb-0">نوع نوبت خود را انتخاب کنید:</p>
                            </div>
                            <div class="col-3 col-md-3 col-xl-2">
                                <div class="answer-radio">
                                    <input id="booking_type_meeting" name="booking_type" type="radio" checked/>
                                    <label for="booking_type_meeting">حضوری</label>
                                </div>
                            </div>
                            <div class="col-3 col-md-3 col-xl-2">
                                <div class="answer-radio">
                                    <input id="booking_type_phone" name="booking_type" type="radio"/>
                                    <label for="booking_type_phone">تلفنی</label>
                                </div>
                            </div>
                        </section>
                        <section class="row align-items-center mb-5">
                            <div class="col-12 col-sm-5 col-md-4 col-xl-3 mb-2 mb-sm-0">
                                <p class="title small mb-0">نوع مشاوره را انتخاب کنید:</p>
                            </div>
                            <div class="col-10 col-sm-5 col-md-4 col-xl-3 me-md-3">
                                <section class="custom-select-box-parent">
                                    <select id="booking_kind_advise" class="custom-select-box">
                                        <option value="مشاوره ازدواج">مشاوره ازدواج</option>
                                        <option value="مشاوره بالینی">مشاوره بالینی</option>
                                        <option value="مشاوره فردی">مشاوره فردی</option>
                                        <option value="مشاوره کودک">مشاوره کودک</option>
                                    </select>
                                    <button type="button" class="btn-color-1 far fa-angle-down"></button>
                                </section>
                            </div>
                        </section>
                        <section class="row align-items-center mb-5">
                            <div class="col-12 col-sm-5 col-md-4 col-xl-3 mb-2 mb-sm-0">
                                <p class="title small mb-0">هزینه ویزیت خود را وارد کنید:</p>
                            </div>
                            <div class="col me-sm-3">
                                <input id="booking_price" type="text" class="text-center dir-ltr form-control form-control-sm d-inline-block w-auto" placeholder="10000"/>
                                <span class="font-size-0-9 me-2"> تومان </span>
                            </div>
                        </section>
                        <section class="row align-items-center mb-3 mb-sm-5">
                            <div class="col-12 col-sm-5 col-md-4 col-xl-3 mb-2 mb-sm-0">
                                <p class="title small mb-0">تاریخ مورد نظرتان را انتخاب کنید:</p>
                            </div>
                            <div class="col-5 col-sm-3 col-md-3 col-xl-2">
                                <button id="booking_choose_date" type="button" class="btn-color-2">انتخاب تاریخ</button>
                            </div>
                            <div class="col-5 col-sm-3 col-md-3 col-xl-2">
                                <input id="booking_choose_date_append" type="text" class="text-center disabled dir-ltr form-control form-control-sm" readonly value="<?= tr_num( jdate("Y/m/d"), "en" ) ?>"/>
                            </div>
                        </section>
                        <section class="row align-items-center mb-3">
                            <div class="col-12 col-sm-5 col-md-4 col-xl-3 mb-2 mb-sm-0">
                                <p class="title small mb-0">ساعت حضور در مطب را انتخاب کنید:</p>
                            </div>
                            <div class="col-5 col-sm-3 col-md-3 col-xl-2">
                                <button id="booking_start_time" type="button" class="btn-color-2">انتخاب ساعت</button>
                            </div>
                            <div class="col-5 col-sm-3 col-md-3 col-xl-2">
                                <input id="booking_start_time_append" type="text" class="text-center disabled dir-ltr form-control form-control-sm" readonly value="<?= date("H:i") ?>"/>
                                <!-- <input type="time" class="dir-ltr form-control form-control-sm"/> -->
                            </div>
                        </section>
                        <section class="row align-items-center mb-3 mb-sm-5">
                            <div class="col-12 col-sm-5 col-md-4 col-xl-3 mb-2 mb-sm-0">
                                <p class="title small mb-0">ساعت خروج از مطب را انتخاب کنید:</p>
                            </div>
                            <div class="col-5 col-sm-3 col-md-3 col-xl-2">
                                <button id="booking_end_time" type="button" class="btn-color-2">انتخاب ساعت</button>
                            </div>
                            <div class="col-5 col-sm-3 col-md-3 col-xl-2">
                                <input id="booking_end_time_append" type="text" class="text-center disabled dir-ltr form-control form-control-sm" readonly value="<?= date("H:i") ?>"/>
                            </div>
                        </section>
                        <section class="row align-items-center mb-5">
                            <div class="col-12 col-sm-5 col-md-4 col-xl-3 mb-2 mb-sm-0">
                                <p class="title small mb-0">زمانی که برای هر بیمار صرف میکنید چند دقیقه است؟</p>
                            </div>
                            <div class="col-3 col-sm-2 col-md-2 col-xl-2">
                                <input id="booking_time_each_patient" type="text" data-type="number" class="text-center dir-ltr form-control form-control-sm" placeholder="30"/>
                            </div>
                            <div class="col-12 col-sm-3 col-md-3 col-xl-2 mt-3 mt-sm-0 mb-2 mb-sm-0 text-sm-start px-sm-1">
                                <p class="title small mb-0">تعداد بیماران قابل رزرو</p>
                            </div>
                            <div class="col-3 col-sm-2 col-md-2 col-xl-2">
                                <input id="booking_number_total_patient" type="text" class="text-center disabled dir-ltr form-control form-control-sm" value="0"/>
                            </div>
                        </section>
                        <section class="row align-items-center">
                            <div class="col-7 col-sm-3 me-auto ms-auto ms-sm-0">
                                <button type="submit" class="btn-color-3 w-100">ثبت</button>
                            </div>
                        </section>
                    </form>
                </section>
            </div>
        </div>
</article>