    <header class="header">
        <div class="image-back">
            <img src="../assets/image/login.jpg" class="w-100 h-100 object-fit-cover" alt="" />
        </div>
        <div class="header-description">
            <h1 class="title">بازیابی رمز عبور</h1>
            <p class="description">
                با وارد کردن شماره همراه خود، در صورتی که شماره شما در سیستم ثبت شده باشد، رمز عبور جدید برای شما ارسال خواهد شد.
                لطفا بعد از ورود به سیستم نسبت به تغییر رمز عبور خود اقدام نمایید.
            </p>
        </div>
    </header>

    <main class="main container">
        <article>
            <form id="recovery_form" class="row flex-column" method="post">
                <section class="col-12 mb-4">
                    <label class="col-form-label">
                        شماره همراه
                    </label>
                    <input id="mobile" type="text" inputmode="numeric" class="form-control" placeholder="تلفن همراه خود را وارد کنید."/>
                </section>

                <section class="col-12 mb-5">
                    <button type="submit" class="btn-login btn-click-color-1">
                        بازیابی
                    </button>
                </section>

                <section class="col-12 pe-3 text-center">
                    <a href="<?= base_url("/login") ?>" class="btn-color-2 ms-3 text-center d-inline-block text-black">
                        ورود
                    </a>
                    <a href="<?= base_url("/register") ?>" class="btn-color-4 text-center d-inline-block text-black">
                        ثبت نام
                    </a>
                </section>
            </form>
        </article>
    </main>