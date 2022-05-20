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
            <?php 
                if ( exists( $blog->data ) && is_array( $blog->data ) ) :
                    foreach( $blog->data as $datum ) :
                        echo render_page( "Template/blog-card", (array)$datum );
                    endforeach;
                endif;
            ?>
        </article>
    </main>