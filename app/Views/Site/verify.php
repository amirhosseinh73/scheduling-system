    <header class="header">
        <div class="image-back">
            <img src="../assets/image/login.jpg" class="w-100 h-100 object-fit-cover" alt="" />
        </div>
        <div class="header-description">
            <h1 class="title">ثبت نام</h1>
            <p class="description">
            با ثبت نام در سامانه کیمیای مهر میتوانید از خدمات این مرکز، شامل نوبت دهی، آزمون های آنلاین و پرسش و پاسخ بهره مند شوید.
            </p>
        </div>
    </header>

    <main class="main container">
        <article>
            <form id="verify_form" class="row" method="post" autocomplete="on">
                
                <section class="col-12 mb-4">
                    <label class="col-form-label">کد تایید</label>
                    <input id="verify_code" type="text" data-type="number" class="form-control dir-ltr" placeholder="******"/>
                </section>

                <section class="col-12 col-sm-6 mb-4">
                    <label class="col-form-label">رمز عبور</label>
                    <input id="password" type="text" class="form-control input-password" placeholder="حداقل 6 کاراکتر وارد کنید."/>
                </section>
                <section class="col-12 col-sm-6 mb-4">
                    <label class="col-form-label">تکرار رمز عبور</label>
                    <input id="confirm_password" type="text" class="form-control input-password" placeholder="رمز عبور خود را مجددا وارد نمایید."/>
                </section>

                <section class="col-12 mb-5">
                    <button type="submit" class="btn-login btn-click-color-1">تایید</button>
                </section>
            </form>
        </article>
    </main>