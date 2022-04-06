    <header class="header">
        <div class="image-back">
            <img src="<?= $blog->image ?>" class="w-100 h-100 object-fit-contain" alt="" />
            <img src="<?= $blog->image ?>" class="image-back-transparency" alt="" />
        </div>
        <div class="header-description">
            <h1 class="title"><?= $title_head ?></h1>
            <p class="description"><?= $blog->excerpt ?></p>
        </div>
    </header>

    <main class="main container">
        <article class="row">
            <div class="col-12 single-blog-top">
                <div class="row">
                    <section class="col-12 col-md-6">
                        <h1 class="title big text-color-1"><?= $blog->title ?></h1>
                    </section>
                    <section class="col-12 col-md-6 single-blog-top-details">
                        <section class="row single-blog-top-details-border mx-0">
                            <div class="col-12 text-start single-blog-top-icon">
                                <span id="view_number"><?= $blog->view ?></span>
                                <i class="far fa-eye"></i>
                            </div>
                        </section>
                        <section class="row mx-0 align-items-center">
                            <div class="col-6">
                                <ul class="single-blog-social">
                                    <li>
                                        <a target="_blank" href="http://www.facebook.com/sharer.php?u=<?= $blog->url ?>" class="fab fa-facebook-f"></a>
                                    </li>
                                    <li>
                                        <a target="_blank" href="https://twitter.com/share?url=<?= $blog->url ?>" class="fab fa-twitter"></a>
                                    </li>
                                    <li>
                                        <a target="_blank" href="https://telegram.me/share?url=<?= $blog->url ?>" class="fab fa-telegram-plane"></a>
                                    </li>
                                    <li>
                                        <a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=<?= $blog->url ?>" class="fab fa-linkedin-in"></a>
                                    </li>
                                    <li>
                                        <a target="_blank" href="https://instagram.com?url=<?= $blog->url ?>" class="fab fa-instagram"></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-6 single-blog-top-icon">
                                <time id="publish_date" class="dir-ltr"><?= $blog->publish_at->date ?></time>
                                <i class="far fa-clock"></i>
                            </div>
                        </section>
                    </section>
                </div>
            </div>
        </article>
        <article class="row mt-4">
            <div class="col-12 single-blog-content">
                <div><?= $blog->content ?></div>

                <section class="single-blog-tags">
                    <span class="tag-icon far fa-tags"></span>
                    <?php if ( exists( $blog->tag ) && is_array( $blog->tag ) ) :
                        foreach( $blog->tag as $tag ) :
                            echo "<span class='tag'>
                                    <i class='far fa-hashtag ml-1'></i>
                                    <a>$tag</a>
                                </span>";
                        endforeach;
                    endif; ?>
                </section>
            </div>
        </article>
    </main>