    <header class="header">
        <div class="image-back">
            <img src="../assets/image/login.jpg" class="w-100 h-100 object-fit-cover" alt="" />
        </div>
        <div class="header-description">
            <h1 class="title">ثبت نام</h1>
            <p class="description">
                برای استفاده از خدمات رزرو نوبت و پیگیری سوالات، وارد حساب خود شوید.
            </p>
        </div>
    </header>

    <main class="main container">
        <article>
            <form id="register_form" class="row" method="post" autocomplete="on">
                <section class="col-12 col-sm-6 mb-4">
                    <label class="col-form-label">
                        نام
                    </label>
                    <input id="first_name" type="text" class="form-control" placeholder="نام خود را وارد کنید."/>
                </section>
                <section class="col-12 col-sm-6 mb-4">
                    <label class="col-form-label">
                        نام خانوادگی
                    </label>
                    <input id="last_name" type="text" class="form-control" placeholder="نام خانوادگی خود را وارد کنید."/>
                </section>
                <section class="col-12 col-sm-6 mb-4">
                    <label class="col-form-label">
                        تلفن همراه
                    </label>
                    <input id="mobile" type="text" class="form-control dir-ltr" placeholder="09*********"/>
                </section>
                <section class="col-12 col-sm-6 mb-4">
                    <label class="col-form-label">
                        رمز عبور
                    </label>
                    <input id="password" type="text" class="form-control input-password" placeholder="حداقل 6 کاراکتر وارد کنید."/>
                </section>
                <section class="col-12 col-sm-6 mb-4">
                    <label class="col-form-label">
                        تکرار رمز عبور
                    </label>
                    <input id="confirm_password" type="text" class="form-control input-password" placeholder="رمز عبور خود را مجددا وارد نمایید."/>
                </section>

                <section class="col-12 mb-5">
                    <button type="submit" class="btn-login btn-click-color-1">
                        ثبت نام
                    </button>
                </section>

                <section class="col-12 pe-3">
                    <label class="form-check-label" for="register">
                        قبلا ثبت نام کرده اید؟
                    </label>
                    <a href="<?= base_url( "/login" ); ?>" id="register" class="text-color-1">
                        وارد شوید
                    </a>
                </section>
            </form>
        </article>
    </main>