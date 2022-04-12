<article class="col-12 col-sm-8 col-lg-9 col-xl-10 align-content-center px-0">
    <?php if ( ! exists( $booking_data ) ) :?>
        <div class="dashboard-main-container">
            <div class="col-12 h-100">
                <section class="row">
                    <div class="col-12 col-sm-3 me-auto text-start">
                        <button type="button" class="btn-color-1">ثبت نوبت جدید</button>
                    </div>
                </section>

                <section class="dashboard-inside-container row align-content-center">
                    <p class="title text-dark-2 col-12 m-0 text-center">هنوز نوبتی ثبت نشده است.</p>  
                </section>
            </div>
        </div>
    <?php else: ?>
        <div class="dashboard-main-container">
            <div class="col-12 h-100">
                <section class="row">
                    <div class="col-12 col-sm-3">
                        <section class="search-box-parent">
                            <input type="text" class="custom-input-text" placeholder="نام متخصص خود را وارد کنید..."/>
                            <button type="button" class="btn-color-1 far fa-search"></button>
                        </section>
                    </div>
                    <div class="col-12 col-sm-3 me-3">
                        <section class="custom-select-box-parent">
                            <select class="custom-select-box">
                                <option value="none">فیلتر</option>
                                <option>تلفنی</option>
                                <option>حضوری</option>
                            </select>
                            <button type="button" class="btn-color-1 far fa-angle-down"></button>
                        </section>
                    </div>
                    <div class="col-12 col-sm-3 me-auto text-start">
                        <button type="button" class="btn-color-1">تیکت جدید</button>
                    </div>
                </section>

                <section class="dashboard-inside-container row">
                    <div class="col-12 h-100">
                        <table class="table table-responsive table-secondary table-striped table-bordered table-hover mb-0 font-size-0-8">
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
                                <tr>
                                    <th scope="row">2</th>
                                    <td class="dir-ltr">1400/08/05</td>
                                    <td>
                                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                                    </td>
                                    <td>
                                        <span class="text-warning">بسته شده</span>
                                    </td>
                                    <td class="dir-ltr">
                                        1400/08/05 16:57
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    <?php endif; ?>
</article>