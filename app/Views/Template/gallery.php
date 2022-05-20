<div class="cd-full-width">
    <div class="container-fluid js-tm-page-content" data-page-no="1" data-page-type="gallery">
        <div class="tm-img-gallery-container">
            <div class="tm-img-gallery gallery-one">
                <?php foreach ( $gallery[ "thumbnails" ] as $idx => $thumbnail ) :?>
                    <div class="grid-item">
                        <figure class="effect-sadie">
                            <img src="<?= $thumbnail?>" alt="Image" class="img-fluid tm-img">
                            <figcaption>
                                <!-- <h2 class="tm-figure-title">Image <span><strong>One</strong></span></h2> -->
                                <!-- <p class="tm-figure-description">Set true or false in HTML script tag for this page black and white.</p> -->
                                <a href="<?= $gallery[ "images" ][ $idx ] ?>">مشاهده کامل</a>
                            </figcaption>           
                        </figure>
                    </div>
                <?php endforeach;?>
            </div>                                 
        </div>
    </div>                                                    
</div>                    



