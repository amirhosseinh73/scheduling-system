    <header class="header">
        <div class="image-back">
            <img src="<?= $page->image ?>" class="w-100 h-100 object-fit-contain" alt="" />
            <img src="<?= $page->image ?>" class="image-back-transparency" alt="" />
        </div>
        <div class="header-description">
            <h1 class="title"><?= $title_head ?></h1>
            <p class="description"><?= $page->excerpt ?></p>
        </div>
    </header>

    <main class="main container">
        <article class="row mt-4">
            <section class="col-12">
                <h2 class="title big text-color-1 mt-3"><?= $page->title ?></h2>
                <p class="description mt-5 text-dark-3">
                    <?= $page->content ?>
                </p>
            </section>
        </article>
        <?php if ( exists( $faq ) ) : ?>
            <article class="row my-4">
                <div class="col-12">
                    <?= render_page( "Template/faq-accordion", [ "faq" => $faq ] )?>
                </div>
            </article>
        <?php endif;?>
        <?php if ( exists( $gallery ) ) : ?>
            <article class="row my-4">
                <div class="col-12">
                    <?= render_page( "Template/gallery", [ "gallery" => $gallery ] )?>
                </div>
            </article>
        <?php endif;?>
    </main>