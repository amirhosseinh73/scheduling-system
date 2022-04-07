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

    <main class="main">
        <article class="container mt-4">
            <div class="row">
                <section class="col-12 col-sm-5 col-md-4 col-lg-3">
                    <div class="row">
                        <div class="col-6 col-sm-12">
                            <img src="../assets/image/footer.jpg" class="page-about-image-thumbnail page-about-image-1" alt=""/>
                        </div>
                    </div>
                </section>
                <section class="col-12 col-sm-7 col-md-8 col-lg-9">
                <h2 class="title big text-color-1 mt-3">
                        <?= $page->sub_title ?>
                    </h2>
                    <div class="mt-5 text-dark-3 description">
                        <?= $page->content ?>
                    </div>
                </section>
            </div>
        </article>
        <article class="mt-5 page-contact-us-contact-info">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="row align-items-end mx-0">
                            <div class="col-12 col-sm-6 p-0">
                                <img src="../assets/image/contact-us-vector.png" class="vector"/>
                            </div>
                            <div class="col-12 col-sm-6 contact-info">
                                <h3 class="title text-color-1 big">مرکز مشاوره کیمیای مهر</h3>
                                <ul class="addresses-list">
                                    <li>
                                        <i class="fas fa-map-marker-alt"></i>
                                        <a target="_blank" href="https://maps.google.com/?q=<?= $metadata->address ?>"><?= $metadata->address ?></a>
                                    </li>
                                    <li>
                                        <i class="fas fa-mobile"></i>
                                        <a target="_blank" href="tel:<?= $metadata->mobile ?>"><?= $metadata->mobile ?></a>
                                    </li>
                                    <li>
                                        <i class="fas fa-phone"></i>
                                        <a target="_blank" href="tel:<?= $metadata->phone ?>"><?= $metadata->phone ?></a>
                                    </li>
                                    <li>
                                        <i class="fas fa-envelope-open"></i>
                                        <a target="_blank" href="mailto:<?= $metadata->email ?>"><?= $metadata->email ?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        <article class="mt-5 container">
            <div class="row">
                <div class="col-12">
                    <div class="page-contact-us-map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d602.6127162398151!2d51.370037697819456!3d32.63229780108916!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2s!4v1649331498485!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </article>
        <article class="container mt-5 mb-4">
            <div class="row">
                <div class="col-12 col-sm-5">
                    <h4 class="title medium text-color-1">سوالات متداول</h4>
                    <p class="description">
                        اگر در جایی به مشکلی خوردید یا ابهامی برایتان وجود دارد، میتوانید پاسخ سوال خود را در اینجا بیابید.
                    </p>
                    <p class="description">
                        اگر پاسخ سوال خود را نیافتید برای ما در پنل کاربری خود تیکت ارسال نمایید.
                    </p>

                    <button type="button" class="btn-color-3 me-auto mb-5">
                        مشاهده همه سوالات
                    </button>
                </div>
                <div class="col-12 col-sm-7">
                    <div class="accordion accordion-flush" id="faq_accordion">
                        <?php
                        if ( exists( $faq ) && is_array( $faq ) ) :
                            foreach( $faq as $idx => $qa ) :
                                echo "
                                <section class='accordion-item'>
                                    <h2 class='accordion-header' id='faq_q_$idx'>
                                        <button class='accordion-button " . ( $idx !== 0 ? 'collapsed' : '' ) . "' type='button' data-bs-toggle='collapse' 
                                        data-bs-target='#faq_a_$idx' aria-expanded='false' aria-controls='faq_a_$idx'>$qa->question</button>
                                    </h2>
                                    <div id='faq_a_$idx' class='accordion-collapse collapse " . ( $idx !== 0 ? '' : 'show' ) . "' aria-labelledby='faq_q_$idx' 
                                    data-bs-parent='#faq_accordion'>
                                        <div class='accordion-body'>$qa->answer</div>
                                    </div>
                                </section>";
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </article>
    </main>