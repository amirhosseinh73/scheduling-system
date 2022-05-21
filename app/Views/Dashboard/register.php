    <header class="header">
        <div class="image-back">
            <img src="../assets/image/login.jpg" class="w-100 h-100 object-fit-cover" alt="" />
        </div>
        <div class="header-description">
            <h1 class="title"><?= $title_head ?></h1>
            <p class="description">
           با ثبت نام در سامانه کیمیای مهر میتوانید از خدمات این مرکز، شامل نوبت دهی، آزمون های آنلاین و پرسش و پاسخ بهره مند شوید.
            </p>
        </div>
    </header>

    <main class="main container">
        <article>
            <form id="register_form" class="row" method="post" autocomplete="on">
                <section class="col-12 col-sm-6 mb-4">
                    <label class="col-form-label">نام</label>
                    <input id="first_name" type="text" class="form-control" placeholder="نام خود را وارد کنید."/>
                </section>
                <section class="col-12 col-sm-6 mb-4">
                    <label class="col-form-label">نام خانوادگی</label>
                    <input id="last_name" type="text" class="form-control" placeholder="نام خانوادگی خود را وارد کنید."/>
                </section>
                <section class="col-12 col-sm-6 mb-4">
                    <label class="col-form-label">تلفن همراه</label>
                    <input id="mobile" type="text" inputmode="numeric" data-type="number" class="form-control dir-ltr" placeholder="09*********"/>
                </section>

                <section class="col-12 col-sm-6 mb-4">
                    <label class="col-form-label mb-4">نوع کاربری خود را مشخص کنید.</label>
                    <input class="form-check-input" type="radio" value="1" name="type_user" id="type_user_1">
                    <label class="form-check-label" for="type_user_1">پزشک</label>
                    <input class="form-check-input me-5" type="radio" value="2" name="type_user" id="type_user_2">
                    <label class="form-check-label" for="type_user_2">مراجعه کننده</label>
                </section>

                <section class="col-12 mb-5">
                    <button type="submit" class="btn-login btn-click-color-1">ثبت نام</button>
                </section>

                <section class="col-12 pe-3">
                    <label class="form-check-label" for="register">قبلا ثبت نام کرده اید؟</label>
                    <a href="<?= base_url( "/login" ); ?>" id="register" class="text-color-1">وارد شوید</a>
                </section>
            </form>
        </article>
    </main>