<article class="col-12 col-sm-8 col-lg-9 col-xl-10 align-content-center px-0">
    <div class="dashboard-main-container">
            <div class="col-12 h-100">
                <section class="row">
                    <div class="col-12 col-sm-3 me-auto text-start">
                        <button type="button" class="btn-color-1">ثبت نوبت جدید</button>
                    </div>
                </section>

                <section class="dashboard-inside-container">
                    <form>
                        <section class="row align-items-center mb-5">
                            <div class="col-3">
                                <p class="title small mb-0">نوع نوبت خود را انتخاب کنید:</p>
                            </div>
                            <div class="col-2">
                                <div class="answer-radio">
                                    <input id="booking_type_meeting" name="booking_type" type="radio" checked/>
                                    <label for="booking_type_meeting">حضوری</label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="answer-radio">
                                    <input id="booking_type_phone" name="booking_type" type="radio"/>
                                    <label for="booking_type_phone">تلفنی</label>
                                </div>
                            </div>
                        </section>
                        <section class="row align-items-center mb-5">
                            <div class="col-3">
                                <p class="title small mb-0">تاریخ مورد نظرتان را انتخاب کنید:</p>
                            </div>
                            <div class="col-2">
                                <button id="booking_choose_date" type="button" class="btn-color-2">انتخاب تاریخ</button>
                            </div>
                            <div class="col-2">
                                <input id="booking_choose_date_append" type="text" class="text-center disabled dir-ltr form-control form-control-sm" readonly value="<?= jdate("Y-m-d") ?>"/>
                            </div>
                        </section>
                        <section class="row align-items-center mb-3">
                            <div class="col-3">
                                <p class="title small mb-0">ساعت حضور در مطب را انتخاب کنید:</p>
                            </div>
                            <div class="col-2">
                                <button id="booking_start_time" type="button" class="btn-color-2">انتخاب ساعت</button>
                            </div>
                            <div class="col-2">
                                <input id="booking_start_time_append" type="text" class="text-center disabled dir-ltr form-control form-control-sm" readonly value="<?= date("H:i") ?>"/>
                                <!-- <input type="time" class="dir-ltr form-control form-control-sm"/> -->
                            </div>
                        </section>
                        <section class="row align-items-center mb-5">
                            <div class="col-3">
                                <p class="title small mb-0">ساعت خروج از مطب را انتخاب کنید:</p>
                            </div>
                            <div class="col-2">
                                <button id="booking_end_time" type="button" class="btn-color-2">انتخاب ساعت</button>
                            </div>
                            <div class="col-2">
                                <input id="booking_end_time_append" type="text" class="text-center disabled dir-ltr form-control form-control-sm" readonly value="<?= date("H:i") ?>"/>
                            </div>
                        </section>
                        <section class="row align-items-center mb-5">
                            <div class="col-3">
                                <p class="title small mb-0">زمانی که برای هر بیمار صرف میکنید چند دقیقه است؟</p>
                            </div>
                            <div class="col-2">
                                <input type="text" class="text-center dir-ltr form-control form-control-sm" placeholder="40"/>
                            </div>
                            <div class="col-2">
                                <p class="title small mb-0">تعداد بیماران قابل رزرو</p>
                            </div>
                            <div class="col-2">
                                <input type="text" class="text-center disabled dir-ltr form-control form-control-sm" value="10"/>
                            </div>
                        </section>
                        <section class="row align-items-center">
                            <div class="col-12 col-sm-3 me-auto">
                                <button type="button" class="btn-color-3 w-100">ثبت</button>
                            </div>
                        </section>
                    </form>
                </section>
            </div>
        </div>
</article>