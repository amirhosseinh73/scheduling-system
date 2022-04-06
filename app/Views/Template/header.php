<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no"/>
    <title><?= $title_head ?> | <?= $description_head ?></title>

    <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/css/lib/bootstrap.min.css" );?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/css/lib/swiper-bundle.min.css" );?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/font/fontawesome/css/all.min.css" );?>" />
    <?php if ( $page_name === "index" ) : ?>
        <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/css/page/index.css" );?>" />
    <?php elseif ( $page_name === "blog" || $page_name === "page" ) : ?>
        <link rel="stylesheet" type="text/css" href="<?= base_url( "/assets/css/page/single.css" );?>" />
    <?php endif; ?>

    <script type="text/javascript">
        const base_url = "<?= base_url();?>";
    </script>
</head>
<body>
    
    <nav class="nav-absolute row flex-row-reverse flex-sm-row">
        <div class="col-12 col-sm-auto ms-sm-auto">
            <button type="button" class="btn text-color-7">
                <i class="fad fa-bars"></i>
            </button>
            <button type="button" class="btn text-color-7">
                <i class="fad fa-search"></i>
            </button>
        </div>
        <div class="col-12 col-sm-auto me-sm-auto">
            <a href="<?= base_url();?>">
                <img src="<?= base_url( "/assets/image/logo.png" ); ?>" class="img-fluid logo" alt="logo"/>
            </a>
        </div>
    </nav>