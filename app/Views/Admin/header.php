<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title_head ?> | <?= $description_head ?></title>

    <!-- Theme assets -->
    <link href="<?= base_url() ?>/assets/template/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>/assets/template/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>/assets/template/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css">

    <!-- <link href="<?= base_url() ?>/assets/template/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css"> -->
    <link href="<?= base_url() ?>/assets/template/css/app.css" rel="stylesheet" type="text/css">

	<meta name="theme-color" content="#283D92">

    <!-- dashboard -->
    <?php if ( isset( $css ) ) :?>

        <link href="<?= base_url() ?>/assets/project/css/style.css" id="style" rel="stylesheet" type="text/css">

        <?php if ( in_array( "dashboard", $css ) ): ?>
            <link href="<?= base_url() ?>/assets/template/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css">
        <?php endif;?>

    <?php endif;?>
    <script type="text/javascript">
        const base_url = "<?= base_url()?>";
    </script>
</head>
<body data-layout="detached" data-topbar="colored">
<?php if ( ! exists( $user_info ) || ! is_object( $user_info ) ) return;?>
    <div class="container-fluid">
        <!-- Begin page -->
        <div id="layout-wrapper">

            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="container-fluid">
                        <div class="float-right">

                            <div class="dropdown d-inline-block">
                                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="rounded-circle header-profile-user" src="<?= base_url( IMAGE_DIR_PROFILE . $user_info->image ) ?>" alt="Header Avatar">
                                    <span class="d-none d-xl-inline-block ml-1"><?= $user_info->firstname?></span>
                                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <!-- item-->
                                    <a class="dropdown-item" href="#"><i class="bx bx-user font-size-16 align-middle mr-1"></i>پروفایل</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="<?= base_url( "api/user/logout" ) ?>">
                                        <i class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i>
                                        خروج
                                    </a>
                                </div>
                            </div>

                        </div>
                        <div>
                            <!-- LOGO -->
                            <div class="navbar-brand-box">
                                <a href="index.html" class="logo logo-dark">
                                    <span class="logo-sm">
                                        <img src="<?= base_url() ?>/assets/template/images/logo-sm.png" alt="" height="20">
                                    </span>
                                    <span class="logo-lg">
                                        <img src="<?= base_url() ?>/assets/template/images/logo-dark.png" alt="" height="17">
                                    </span>
                                </a>

                                <a href="index.html" class="logo logo-light">
                                    <span class="logo-sm">
                                        <img src="<?= base_url() ?>/assets/template/images/logo-sm.png" alt="" height="20">
                                    </span>
                                    <span class="logo-lg">
                                        <img src="<?= base_url() ?>/assets/template/images/logo-light.png" alt="" height="19">
                                    </span>
                                </a>
                            </div>

                            <button type="button" class="btn btn-sm px-3 font-size-16 header-item toggle-btn waves-effect" id="vertical-menu-btn">
                                <i class="fa fa-fw fa-bars"></i>
                            </button>

                            <!-- App Search-->
                            <form class="app-search d-none d-lg-inline-block">
                                <div class="position-relative">
                                    <input type="text" class="form-control" placeholder="جستجو ...">
                                    <span class="bx bx-search-alt"></span>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
            </header>
            
            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div class="h-100">

                    <div class="user-wid text-center py-4">
                        <div class="user-img">
                            <img src="<?= base_url( IMAGE_DIR_PROFILE . $user_info->image ) ?>" alt="" class="avatar-md mx-auto rounded-circle">
                        </div>

                        <div class="mt-3">

                            <a href="#" class="text-dark font-weight-medium font-size-16 line-height-h"><?= $user_info->firstname ?></a>
                            <p class="text-body mt-1 mb-0 font-size-13"> <?= $user_info->email ?> </p>

                        </div>
                    </div>

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <?= view( "admin/nav-right" ); ?>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
            <div class="page-content">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="page-title mb-0 font-size-18"><?= $title_head?></h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item active"><?= $description_head?></li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->