<section class="col-6 col-sm-6 blog-box<?= ( $page_name === "page" ? " col-xl-4" : "" )?>">
    <a href="<?= $url?>">
        <div class="blog-box-card">
            <img src="<?= $image?>" class="w-100 h-100 object-fit-cover"/>
            <h3 class="title"><?= $title?></h3>
            <div class="blog-box-description">
                <h3 class="title"><?= $title?></h3>
                <p class="description"><?= $excerpt?></p>
                <time class="date"><?= $publish_at->date?></time>
            </div>
        </div>
    </a>
</section>