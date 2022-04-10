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
    <?php if ( $page_name === "index" ) : ?>
        <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/css/page/dashboard.css" );?>" />
    <?php endif; ?>

    <script type="text/javascript">
        const base_url = "<?= base_url();?>";
    </script>
</head>
<body class="dashboard-body container-fluid">
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
                        <?= gender_text() . $user_info->lastname ?>
                    </p>
                </div>
                <div class="col-auto pe-1">
                    <img src="../assets/image/dashboard/male.jpg" class="profile-image"/>
                </div>
            </div>
        </div>
    </nav>

    <main class="container dashboard-main">
        <div class="row h-100">
            <aside class="col-8 col-sm-4 col-lg-3 col-xl-2 dashboard-side-nav">
                <button type="button" class="btn-color-3 fas fa-arrow-right py-1 btn-close-side-nav"></button>
                <span class="wallet-balance">
                    موجودی کیف پول:
                    <abbr>15000</abbr>
                </span>
                <ul class="side-nav-ul">
                    <li class="active">
                        <a href="dashboard.html">
                            <i class="far fa-dashboard"></i>
                            <span>پیش خوان</span>
                        </a>
                    </li>
                    <li>
                        <a href="dashboard-page-2.html">
                            <i class="far fa-calendar-check"></i>
                            <span>نوبت های گرفته شده</span>
                        </a>
                    </li>
                    <li>
                        <a href="dashboard-page-3.html">
                            <i class="far fa-calendar-edit"></i>
                            <span>ثبت نوبت جدید</span>
                        </a>
                    </li>
                    <li>
                        <a href="dashboard-page-4.html">
                            <i class="far fa-wallet"></i>
                            <span>کیف پول</span>
                        </a>
                    </li>
                    <li>
                        <a href="dashboard-page-5.html">
                            <i class="far fa-file-signature"></i>
                            <span>آزمون های آنلاین</span>
                        </a>
                    </li>
                    <li>
                        <a href="dashboard-page-6.html">
                            <i class="far fa-screen-users"></i>
                            <span>کارگاه های آنلاین</span>
                        </a>
                    </li>
                    <li>
                        <a href="dashboard-page-7.html">
                            <i class="far fa-question-circle"></i>
                            <span>پرسش و پاسخ</span>
                        </a>
                    </li>
                    <li>
                        <a href="dashboard-page-8.html">
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