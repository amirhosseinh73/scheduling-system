<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no"/>
    <title><?= $title_head ?> | <?= $description_head ?></title>

    <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/css/lib/bootstrap.min.css" );?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/font/fontawesome/css/all.min.css" );?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/css/lib/sweetalert2.min.css" );?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/css/page/dashboard.css" );?>" />

    <script type="text/javascript">
        const base_url = "<?= base_url();?>";
    </script>
</head>
<body class="dashboard-body container-fluid">

<div class="ibv_vb_modal_back"></div>
    <article id="profile_change_modal" class="ibv_vb_modal edit_profile_modal">
        <div class="ibv_vb_modal_inside">
            <section class="ibv_vb_modal_header">
                <p>ویرایش پروفایل</p>

                <button type="button" class="btn btn-white rounded-circle mr-1 close_modal">
                    <i class="fas fa-times align-middle"></i>
                </button>
            </section>
            <section class="ibv_vb_modal_body d-flex flex-column justify-content-around">
                <div class="ibv_vb_profile_page scrollable">
                    <div class="ibv_vb_profile_page_col">
                        <input id="user_image_profile" type="file" class="d-none"
                            value=""/>
                        <img id="user_image_profile_img" class="vb_profile_image"
                            data-src=""
                            src=""/>
                        <button type="button"
                                class="ibv_vb_custom-button practice-add change_profile_image_button w-100">
                            ویرایش عکس
                        </button>
                    </div>
                    <div class="ibv_vb_profile_page_col">
                        <div class="row mb-4 w-100">
                            <div class="col">
                                <input id="user_first_name" type="text" value="<?= $user_info->first_name ?>" required
                                    class="ibv_vb_custom-input color-text no-padding"
                                    placeholder=""/>
                            </div>
                            <div class="col pl-0">
                                <input id="user_last_name" type="text" value="<?= $user_info->last_name ?>" required
                                    class="ibv_vb_custom-input color-text no-padding"
                                    placeholder=""/>
                            </div>
                        </div>
                        <input type="hidden" name="user_email" value=""/>
                        <div class="row mb-4 w-100">
                            <div class="col">
                                <input id="nat_code" type="text" value=""
                                    class="ibv_vb_custom-input color-text disabled no-padding" readonly="readonly"/>
                            </div>

                            <div class="col pl-0">
                                <input id="user_tel" type="tel" value="" minlength="11"
                                    maxlength="11" required class="ibv_vb_custom-input color-text no-padding"
                                    placeholder=""/>
                            </div>
                        </div>
                        <div class="row mb-4 w-100">
                            <div class="col">
                                <input id="user_password" type="password" minlength="6"
                                    class="ibv_vb_custom-input color-text no-padding no-padding"
                                    placeholder=""/>
                            </div>
                            <div class="col pl-0">
                                <input id="user_repeat_password" type="password" minlength="6"
                                    class="ibv_vb_custom-input color-text no-padding no-padding"
                                    placeholder=""/>
                            </div>
                        </div>

                        <button type="button" id="ibv_vb_save_change"
                                class="ibv_vb_custom-button green btn-submit-check text-center mt-2 mt-sm-5">
                            ثبت تغییرات
                            <i class="fas fa-check"></i>
                        </button>
                    </div>
                </div>
            </section>
            <section class="ibv_vb_modal_footer">
            </section>
        </div>
    </article>

    <nav class="row flex-row-reverse flex-sm-row nav-header align-items-center">
        <div class="col-12 col-sm-auto">
            <a href="<?= base_url();?>">
                <img src="<?= base_url( "/assets/image/logo.png" ); ?>" class="img-fluid logo" alt="logo"/>
            </a>
        </div>
        <div class="col-12 col-sm ms-sm-auto nav-list-parent">
            <button type="button" class="btn text-color-7 nav-btn-collapse">
                <i class="fad fa-bars"></i>
            </button>
            <!-- <button type="button" class="btn text-color-7">
                <i class="fad fa-search"></i>
            </button> -->
            <ul class="nav-list-ul">
                <li>
                    <a href="<?= base_url() ?>">صفحه اصلی</a>
                </li>
                <li>
                    <a href="<?= base_url( "/category/blog" )?>">وبلاگ</a>
                </li>
                <li>
                    <a href="<?= base_url( "/page/about-us" )?>">درباره ما</a>
                </li>
                <li>
                    <a href="<?= base_url( "/page/contact-us" )?>">تماس با ما</a>
                </li>
            </ul>
        </div>
        
        <div class="col-12 col-sm-auto me-sm-auto">
            <div class="row nav-profile">
                <div class="col">
                    <p>
                        <?= gender_text( $user_info ) . $user_info->lastname ?>
                    </p>
                </div>
                <div class="col-auto pe-1">
                    <img src="<?= $user_info->image ?>" class="profile-image"/>
                </div>
            </div>
        </div>
    </nav>

    <main class="container dashboard-main">
        <div class="row h-100">
            <aside class="col-8 col-sm-4 col-lg-3 col-xl-2 dashboard-side-nav">
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
                    <li <?php if ( $page_name === "booking_index" ) echo "class='active'" ?>>
                        <a href="<?= base_url( "/dashboard/booking" )?>">
                            <i class="far fa-calendar-edit"></i>
                            <span>ثبت نوبت جدید</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="disabled">
                            <i class="far fa-calendar-check"></i>
                            <span>نوبت های گرفته شده</span>
                        </a>
                    </li>
                    <!-- <li>
                        <a href="dashboard-page-4.html" class="disabled">
                            <i class="far fa-wallet"></i>
                            <span>کیف پول</span>
                        </a>
                    </li> -->
                    <li>
                        <a href="dashboard-page-5.html" class="disabled">
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
                    <li>
                        <a href="dashboard-page-7.html" class="disabled">
                            <i class="far fa-question-circle"></i>
                            <span>پرسش و پاسخ</span>
                        </a>
                    </li>
                    <li>
                        <a href="dashboard-page-8.html" class="disabled">
                            <i class="far fa-comments"></i>
                            <span>تیکت ها</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url( "/logout" )?>">
                            <i class="far fa-power-off"></i>
                            <span>خروج</span>
                        </a>
                    </li>
                </ul>
            </aside>