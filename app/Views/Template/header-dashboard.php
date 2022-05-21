<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no"/>
    <title><?= $title_head ?> | <?= $description_head ?></title>

    <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/css/lib/bootstrap.min.css?v=" . get_version() );?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/font/fontawesome/css/all.min.css?v=" . get_version() );?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/css/lib/sweetalert2.min.css?v=" . get_version() );?>" />

    <?php if( $page_name === "booking_index" ) : ?>
        <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/css/lib/mds.bs.datetimepicker.style.css?v=" . get_version() );?>" />
        <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/css/lib/mdtimepicker.css?v=" . get_version() );?>" />
    <?php endif; ?>

    <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/css/page/modal-alertify-calendar.css?v=" . get_version() );?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/css/page/dashboard.css?v=" . get_version() );?>" />

    <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/css/global/responsive.css?v=" . get_version() );?>" />

    <script type="text/javascript">
        const base_url = "<?= base_url();?>";
    </script>
</head>
<body class="dashboard-body container-fluid <?= $classes?>">

    <div class="cs-modal-back"></div>
    <article id="profile_change_modal" class="cs-modal cs-edit-profile-modal">
        <div class="cs-modal-inside">
            <section class="cs-modal-header">
                <p>ویرایش پروفایل</p>

                <button type="button" class="btn btn-color-3 rounded-circle mr-1 cs-close-modal">
                    <i class="fas fa-times align-middle"></i>
                </button>
            </section>
            <section class="cs-modal-body">
                <div class="row">
                    <div class="col-12 col-sm-auto">
                        <label for="choose_profile_image" class="profile-image">
                            <img id="profile_image" src="<?= $user_info->image ?>" class="w-100 h-100 object-fit-cover"/>
                        </label>
                        <label for="choose_profile_image" class="btn-color-4">تغییر عکس</label>
                        <input type="file" class="d-none" accept="image/*" id="choose_profile_image"/>
                    </div>
                    <div class="col-12 col-sm">
                        <form id="form_edit_profile">
                            <div class="row text-end align-items-center">
                                <div class="col-12 col-sm-6 mb-4">
                                    <label class="col-form-label">نام</label>
                                    <input id="firstname" type="text" class="form-control form-control-sm" value="<?= $user_info->firstname ?>" />
                                </div>
                                <div class="col-12 col-sm-6 mb-4">
                                    <label class="col-form-label">نام خانوادگی</label>
                                    <input id="lastname" type="text" class="form-control form-control-sm" value="<?= $user_info->lastname ?>" />
                                </div>
                                <div class="col-12 col-sm-6 mb-4">
                                    <label class="col-form-label">تلفن همراه</label>
                                    <input type="tel" class="form-control form-control-sm disabled" disabled readonly value="<?= $user_info->username ?>" />
                                </div>
                                <div class="col-12 col-sm-6 mb-4">
                                    <label class="col-form-label">ایمیل</label>
                                    <input id="email" type="text" class="form-control form-control-sm" value="<?= $user_info->email ?>" />
                                </div>
                                <div class="col-12 col-sm-6 mb-4">
                                    <label class="col-form-label d-block">جنسیت</label>
                                    <input class="form-check-input" type="radio" value="1" name="gender" id="gender_1" <?php if ( $user_info->gender ) echo "checked" ?> >
                                    <label class="form-check-label" for="gender_1">آقا</label>
                                    <input class="form-check-input me-5" type="radio" value="0" name="gender" id="gender_2" <?php if ( ! is_null( $user_info->gender ) && ! $user_info->gender ) echo "checked" ?>>
                                    <label class="form-check-label" for="gender_2">خانم</label>
                                </div>
                                <div class="col-12 col-sm-6 mb-4">
                                </div>
                                <div class="col-12 col-sm-6 mb-4">
                                    <label>رمز عبور جدید</label>
                                    <input id="password" type="password" class="form-control form-control-sm input-password" placeholder="*******"/>
                                </div>
                                <div class="col-12 col-sm-6 mb-4">
                                    <label>تکرار رمز عبور جدید</label>
                                    <input id="confirm_password" type="password" class="form-control form-control-sm input-password" placeholder="*******"/>
                                </div>
                                <div class="col-12 col-sm-6 mb-4">
                                <?php if ( ! exists( $user_info->email_verified_at ) ) echo "
                                <label>کد تایید ایمیل</label>
                                <input id='verify_code_email' type='text' class='form-control form-control-sm input-password' />
                                "; 
                                else "ایمیل شما قبلا تایید شده است." ?>
                                </div>

                                <div class="col-12 mb-2 text-start">
                                    <button type="submit" class="btn-color-1">ثبت تغییرات</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
            <section class="cs-modal-footer">
            </section>
        </div>
    </article>

    <nav class="row nav-header align-items-center">
        <div class="col-auto col-sm-auto d-none d-lg-block">
            <a href="<?= base_url();?>">
                <img src="<?= base_url( "/assets/image/logo.png" ); ?>" class="img-fluid logo" alt="logo"/>
            </a>
        </div>
        <div class="col col-sm ms-sm-auto nav-list-parent">
            <ul class="nav-list-ul">
                <li class="btn-toggle-navbar">
                    <button type="button" class="btn text-color-1 nav-btn-collapse">
                        <i class="fad fa-bars"></i>
                    </button>
                </li>
                <li>
                    <a href="<?= base_url() ?>">صفحه اصلی</a>
                </li>
                <li>
                    <a href="<?= base_url( "/page/blog" )?>">وبلاگ</a>
                </li>
                <li>
                    <a href="<?= base_url( "/page/about-us" )?>">درباره ما</a>
                </li>
                <li>
                    <a href="<?= base_url( "/page/contact-us" )?>">تماس با ما</a>
                </li>
            </ul>
        </div>
        
        <div class="col-auto col-sm-auto me-sm-auto">
            <div class="row nav-profile">
                <div class="col">
                    <p id="user_fullname_gender_nav">
                        <?= gender_text( $user_info ) . $user_info->lastname ?>
                    </p>
                </div>
                <div class="col-auto pe-1">
                    <img id="profile_image_nav" src="<?= $user_info->image ?>" class="profile-image"/>
                </div>
            </div>
        </div>
    </nav>

    <main class="container dashboard-main">
        <div class="row h-100">
            <aside class="col-8 col-sm-4 col-md-3 col-xl-2 dashboard-side-nav d-none d-lg-block">
                <!-- <button type="button" class="btn-color-3 fas fa-arrow-right py-1 btn-close-side-nav"></button>  -->
                <!-- <span class="wallet-balance">
                    موجودی کیف پول:
                    <abbr>15000</abbr>
                </span> -->
                <ul class="side-nav-ul">
                    <li <?php if ( $page_name === "index" ) echo "class='active'" ?>>
                        <a href="<?= base_url( "/dashboard" )?>">
                            <i class="far fa-dashboard"></i>
                            <span>پیشخوان</span>
                        </a>
                    </li>
                    <?php if ( ! $user_info->type_user ) : //doctor?>
                        <li <?php if ( $page_name === "booking_index" ) echo "class='active'" ?>>
                            <a href="<?= base_url( "/dashboard/booking" )?>">
                                <i class="far fa-calendar-edit"></i>
                                <span>ثبت نوبت جدید</span>
                            </a>
                        </li>
                        <li <?php if ( $page_name === "booking_turns" ) echo "class='active'" ?>>
                            <a href="<?= base_url( "/dashboard/booking/turns" )?>">
                                <i class="far fa-calendar-check"></i>
                                <span>نوبت های قبلی</span>
                            </a>
                        </li>
                        <li <?php if ( $page_name === "question_answer_index_doctor" ) echo "class='active'" ?>>
                            <a href="<?= base_url( "/dashboard/question-answer/doctor" )?>">
                                <i class="far fa-question-circle"></i>
                                <span>پرسش و پاسخ</span>
                            </a>
                        </li>
                    <?php elseif ( $user_info->type_user ) : //patient?>
                        <li <?php if ( $page_name === "reservation_index" ) echo "class='active'" ?>>
                            <a href="<?= base_url( "/dashboard/reserve" )?>">
                                <i class="far fa-calendar-edit"></i>
                                <span>گرفتن نوبت</span>
                            </a>
                        </li>
                        <li <?php if ( $page_name === "reservation_turns" ) echo "class='active'" ?>>
                            <a href="<?= base_url( "/dashboard/reserve/turns" )?>">
                                <i class="far fa-calendar-check"></i>
                                <span>نوبت های گرفته شده</span>
                            </a>
                        </li>
                        <li <?php if ( $page_name === "question_answer_index_patient" ) echo "class='active'" ?>>
                            <a href="<?= base_url( "/dashboard/question-answer/patient" )?>">
                                <i class="far fa-question-circle"></i>
                                <span>پرسش و پاسخ</span>
                            </a>
                        </li>
                    <?php endif;?>
                    <!-- <li>
                        <a href="javascript:void(0)" class="disabled">
                            <i class="far fa-wallet"></i>
                            <span>کیف پول</span>
                        </a>
                    </li> -->
                    <li <?php if ( $page_name === "exam_index" ) echo "class='active'" ?>>
                        <a href="<?= base_url( "/dashboard/exam" )?>">
                            <i class="far fa-file-signature"></i>
                            <span>آزمون های آنلاین</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="disabled">
                            <i class="far fa-screen-users"></i>
                            <span>کارگاه های آنلاین</span>
                        </a>
                    </li>
                    <!-- <li>
                        <a href="javascript:void(0)" class="disabled">
                            <i class="far fa-comments"></i>
                            <span>تیکت ها</span>
                        </a>
                    </li> -->
                    <li>
                        <a href="<?= base_url( "/logout" )?>">
                            <i class="far fa-power-off"></i>
                            <span>خروج</span>
                        </a>
                    </li>
                </ul>
            </aside>