<article class="col-12 col-sm-8 col-lg-9 col-xl-10 align-content-center px-0">
    <div class="dashboard-main-container">
            <div class="col-12 h-100">
                <section class="row">
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
                    <form id="reservation_form" method="POST">
                        <div class="col-12 col-sm-9 h-100">
                            <div class="inside-container-right">
                                <?php
                                if ( exists( $booking_data ) ) :
                                    for ( $i = 0; $i < count( $booking_data ); $i++ ) :
                                        $booking = $booking_data[ $i ];
                                        $is_full = ( $booking->number_reserved === $booking->number_reserve );
                                        $extra_class = $is_full ? "full" : "";

                                        echo "";
                                    endfor;
                                endif;
                                ?>
                                <section class="appointment-card">
                                    <img src="../assets/image/doctor-1.jpg"/>
                                    <div>
                                        <h5 class="card-title">دکتر امین بازرگانی</h5>
                                        <p class="card-description-1">مشاور ازدواج</p>
                                        <span class="card-icon text-success fas fa-user-group"></span>
                                        <span class="card-icon text-danger fas fa-phone-volume"></span>
                                        <p class="card-description-2">
                                            <span>شنبه تا پنج شنبه</span>
                                            <abbr>08:45 - 11:30</abbr>
                                        </p>
                                        <p class="card-description-2">
                                            <span>شنبه تا پنج شنبه</span>
                                            <abbr>16:00 - 22:15</abbr>
                                        </p>
                                        <p class="card-description-3">
                                            <span>بیمه:</span>
                                            <abbr>نکمیلی</abbr>
                                            <abbr>تامین اجتماعی</abbr>
                                            <abbr>فولاد</abbr>
                                        </p>
                                    </div>
                                </section>
                            </div>
                        </div>
                        <div class="col-12 col-sm-3 px-0 h-100">
                            <div class="inside-container-left row mx-0">
                                <div class="col-12">
                                    <h4 class="title text-color-1 mt-3">دکتر امین بازرگانی</h4>
                                </div>
                                <div class="col-12 mt-4">
                                    <div class="row mx-0 align-items-center">
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
                                    </div>

                                    <div class="row mx-0 align-items-center mt-4">
                                        <div class="col ms-auto">
                                            <p class="description font-size-0-7 mb-0">ساعت خود را انتخاب کنید:</p>
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
                                    </div>

                                    <div class="row mx-0 align-items-center mt-4">
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
                                    </div>

                                    <div class="row mx-0 align-items-center mt-4">
                                        <div class="col ms-auto description mb-0 text-color-1"">
                                            <i class="fas fa-circle-info font-size-0-8 align-sub"></i>
                                            <abbr class="font-size-0-7">مبلغ قابل پرداخت:</abbr>
                                        </div>
                                        <div class="col-auto text-color-3 font-size-0-9">
                                            <span>180,000</span>
                                            <abbr>تومان</abbr>
                                        </div>
                                    </div>
                                    <div class="row mx-0 mb-3">
                                        <div class="col-12 px-1 my-1">
                                            <button type="button" class="btn btn-success font-size-0-7 w-100">ثبت و پرداخت</button>
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