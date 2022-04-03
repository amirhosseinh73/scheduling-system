<div class="account-pages mt-5 pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card overflow-hidden">
                    <div class="bg-login text-center">
                        <div class="bg-login-overlay"></div>
                        <div class="position-relative">
                            <h5 class="text-white font-size-20">خوش آمدید!</h5>
                            <p class="text-white-50 mb-0">جهت دسترسی به پنل مدیریت وارد شوید</p>
                            <a href="index.html" class="logo logo-admin mt-4">
                                <img src="<?= base_url() ?>/assets/template/images/logo-sm-dark.png" alt="" height="30">
                            </a>
                        </div>
                    </div>
                    <div class="card-body pt-5">
                        <div class="p-2">
                            <form class="form-horizontal" id="submit" action="">

                                <div class="form-group">
                                    <label for="username">نام کاربری</label>
                                    <input type="text" class="form-control" id="username" placeholder="نام کاربری را وارد کنید">
                                </div>

                                <div class="form-group">
                                    <label for="userpassword">رمز عبور</label>
                                    <input type="password" class="form-control" id="password" placeholder="رمز عبور را وارد کنید">
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="remember_me">
                                    <label class="custom-control-label" for="remember_me">به خاطر سپاری</label>
                                </div>

                                <div class="mt-3">
                                    <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">ورود</button>
                                </div>

                                <div class="mt-4 text-center">
                                    <a href="pages-recoverpw.html" class="text-muted"><i class="mdi mdi-lock mr-1"></i> رمز عبور خود را فراموش کرده اید؟</a>
                                </div>
                                
                            </form>
                        </div>

                    </div>
                </div>
                <div class="mt-5 text-center">
                    <p>حساب کاربری ندارید؟ <a href="pages-register.html" class="font-weight-medium text-primary"> ثبت نام کنید </a> </p>
                </div>

            </div>
        </div>
    </div>
</div>