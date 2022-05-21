    <header class="header">
        <div class="image-back">
            <img src="../assets/image/login.jpg" class="w-100 h-100 object-fit-cover" alt="" />
        </div>
        <div class="header-description">
            <h1 class="title">ورود به حساب کاربری</h1>
            <p class="description">
                برای استفاده از خدمات رزرو نوبت و پیگیری سوالات، وارد حساب خود شوید.
            </p>
        </div>
    </header>

    <main class="main container">
        <article>
            <form id="login_form" class="row flex-column" method="post">
                <section class="col-12 mb-4">
                    <label class="col-form-label">
                        نام کاربری
                    </label>
                    <input id="username" type="text" inputmode="numeric" class="form-control" placeholder="تلفن همراه خود را وارد کنید."/>
                </section>
                <section class="col-12 mb-4">
                    <label class="col-form-label">
                        رمز عبور
                    </label>
                    <input id="password" type="password" class="form-control input-password" placeholder="رمز عبور خود را وارد کنید."/>
                </section>

                <section class="col-12 mb-5">
                    <a href="<?= base_url( "/recovery" )?>" class="forgot-password">
                        رمز عبور خود را فراموش کرده ام!
                    </a>
                </section>
                <section class="col-12 mb-2">
                    <input class="form-check-input" type="checkbox" value="" id="remember_me">
                    <label class="form-check-label" for="remember_me">
                        مرا به خاطر بسپار
                    </label>
                </section>

                <section class="col-12 mb-5">
                    <button type="submit" class="btn-login btn-click-color-1">
                        ورود
                    </button>
                </section>

                <section class="col-12 pe-3">
                    <label class="form-check-label" for="register">
                        حساب کاربری ندارید؟
                    </label>
                    <a href="<?= base_url("/register") ?>" id="register" class="text-color-1">
                        ثبت نام کنید
                    </a>
                </section>
            </form>
        </article>
    </main>