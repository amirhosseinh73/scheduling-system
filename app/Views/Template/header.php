<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no"/>
    <title><?= $title_head ?> | <?= $description_head ?></title>

    <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/css/lib/bootstrap.min.css?v=" . get_version() );?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/css/lib/swiper-bundle.min.css?v=" . get_version() );?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/font/fontawesome/css/all.min.css?v=" . get_version() );?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/css/lib/sweetalert2.min.css?v=" . get_version() );?>" />
    <?php if ( $page_name === "index" ) : ?>
        <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/css/page/index.css?v=" . get_version() );?>" />
        <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/css/page/blog.css?v=" . get_version() );?>" />
    <?php elseif ( $page_name === "blog" || $page_name === "page" ) : ?>

        <?php if ( $page_name_2 === "gallery" ) : ?>
            <link rel="stylesheet" href="<?= base_url( "/assets/css/gallery/hero-slider-style.css?v=" . get_version() )?>">                              
            <link rel="stylesheet" href="<?= base_url( "/assets/css/gallery/magnific-popup.css?v=" . get_version() )?>">                                 
            <link rel="stylesheet" href="<?= base_url( "/assets/css/gallery/templatemo-style.css?v=" . get_version() )?>">                                   
        <?php endif;?>

        <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/css/page/single.css?v=" . get_version() );?>" />
        <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/css/page/blog.css?v=" . get_version() );?>" />
    <?php elseif ( $page_name === "register" || $page_name === "login" ) : ?>
        <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/css/page/login.css?v=" . get_version() );?>" />
    <?php endif; ?>

    <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/css/global/responsive.css?v=" . get_version() );?>" />

    <script type="text/javascript">
        const base_url = "<?= base_url();?>";
    </script>
</head>
<body class="<?= $classes?>">
    
    <nav class="nav-absolute row align-items-center">
        <div class="col col-sm ms-sm-auto nav-list-parent">
            <!-- <button type="button" class="btn text-color-7">
                <i class="fad fa-search"></i>
            </button> -->
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
                <?php if( exists( $user_info ) ) : ?>
                    <li class="btn-outline-6 me-auto">
                        <a href="<?= base_url( "/dashboard" )?>">صفحه شخصی</a>
                    </li>
                    <li class="btn-color-6">
                        <a href="<?= base_url( "/logout" )?>">خروج</a>
                    </li>
                <?php else:?>
                    <li class="btn-outline-6 me-auto">
                        <a href="<?= base_url( "/login" )?>">ورود</a>
                    </li>
                    <li class="btn-color-6">
                        <a href="<?= base_url( "/register" )?>">ثبت نام</a>
                    </li>
                <?php endif;?>
            </ul>
        </div>
        <div class="col-auto col-sm-auto me-sm-auto logo-parent-nav">
            <a href="<?= base_url();?>">
                <img src="<?= base_url( "/assets/image/logo.png" ); ?>" class="img-fluid logo" alt="logo"/>
            </a>
        </div>
    </nav>