<footer class="footer container-fluid">
        <div class="d-flex flex-column">
            <section class="row top">
                <div class="col-12 col-sm-5 col-md-5">
                    <div class="row footer-large-button">
                        <section class="col-6 col-sm-6" onclick="window.location.href=base_url + '/dashboard'">
                            <i class="fad fa-phone-volume"></i>
                            <p>مشاوره تلفنی</p>
                        </section>
                        <section class="col-6 col-sm-6" onclick="window.location.href=base_url + '/dashboard'">
                            <i class="fad fa-user-group"></i>
                            <p>مشاوره حضوری</p>
                        </section>
                        <section class="col-6 col-sm-6" onclick="window.location.href=base_url + '/dashboard'">
                            <i class="fad fa-earth"></i>
                            <p>مشاوره آنلاین</p>
                        </section>
                        <section class="col-6 col-sm-6" onclick="window.location.href=base_url + '/dashboard/exam'">
                            <i class="fad fa-file-invoice"></i>
                            <p>آزمون آنلاین</p>
                        </section>
                    </div>
                </div>
                <div class="col-12 col-sm-7 col-md-5 footer-list">
                    <h4 class="title">دسترسی سریع</h4>
                    <ul class="ul-list">
                        <li>
                            <a href="<?= base_url()?>">
                                صفحه اصلی
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url( "/page/gallery" )?>">
                                گالری تصاویر
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url( "/page/faq" )?>">
                                سوالات متداول
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url( "/page/about-us" )?>">
                                درباره ما
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url( "/page/contact-us" )?>">
                                تماس با ما
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-auto col-sm-auto col-md-2 text-start">
                    <a href="#">
                        <img src="../assets/image/enamad-1.png" class="img-fluid e-nemad"/>
                    </a>
                </div>
                <div class="col col-sm text-start mt-auto">
                    <ul class="ul-social">
                        <li>
                            <a href="#" class="fab fa-twitter"></a>
                        </li>
                        <li>
                            <a href="#" class="fab fa-facebook-f"></a>
                        </li>
                        <li>
                            <a href="#" class="fab fa-whatsapp"></a>
                        </li>
                        <li>
                            <a href="#" class="fab fa-telegram"></a>
                        </li>
                        <li>
                            <a href="#" class="fab fa-pinterest"></a>
                        </li>
                    </ul>
                </div>
            </section>
            <section class="row bottom">
                <div class="col-12 col-sm-8 text-center text-sm-end">
                    <i class="far fa-copyright"></i>
                    تمامی حقوق برای وبسایت کیمیای مهر محفوظ می باشد.
                </div>
                <div class="col-12 col-sm-4 text-center text-sm-start dir-ltr">
                    1399 - <?= jdate( "Y" ); ?>
                </div>
            </section>
        </div>
    </footer>
    <!-- scripts -->
    <script type="text/javascript" src="<?= base_url( "/assets/js/lib/bootstrap.bundle.min.js?v=" . get_version() )?>"></script>
    <script type="text/javascript" src="<?= base_url( "/assets/js/lib/swiper-bundle.min.js?v=" . get_version() )?>"></script>
    <script type="text/javascript" src="<?= base_url( "/assets/js/lib/sweetalert2.min.js?v=" . get_version() )?>"></script>
    <script type="text/javascript" src="<?= base_url( "/assets/js/global/config.js?v=" . get_version() )?>"></script>
    <script type="text/javascript" src="<?= base_url( "/assets/js/global/helper.js?v=" . get_version() )?>"></script>
    <script type="text/javascript" src="<?= base_url( "/assets/js/global/Alert.js?v=" . get_version() )?>"></script>

    <?php if ( $page_name === "index" ) : ?>
        <script type="text/javascript" src="<?= base_url( "/assets/js/page/index.js?v=" . get_version() )?>"></script>
    <?php elseif( $page_name === "register" ) : ?>
        <script type="text/javascript" src="<?= base_url( "/assets/js/page/Register.js?v=" . get_version() )?>"></script>
    <?php elseif( $page_name === "login" ) : ?>
        <script type="text/javascript" src="<?= base_url( "/assets/js/page/Login.js?v=" . get_version() )?>"></script>
    <?php elseif( $page_name === "page" ) : ?>
        <!-- <script src="https://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script> -->
        <script type="text/javascript" src="<?= base_url( "/assets/js/page/direction.js?v=" . get_version() )?>"></script>
    <?php endif; ?>
    <?php if( $page_name_2 === "gallery" ) : ?>
        <script type="text/javascript" src="<?= base_url( "/assets/js/gallery/jquery-1.11.3.min.js?v=" . get_version() )?>"></script>
        <script type="text/javascript" src="<?= base_url( "/assets/js/gallery/tether.min.js?v=" . get_version() )?>"></script>
        <script type="text/javascript" src="<?= base_url( "/assets/js/gallery/hero-slider-main.js?v=" . get_version() )?>"></script>
        <script type="text/javascript" src="<?= base_url( "/assets/js/gallery/jquery.magnific-popup.min.js?v=" . get_version() )?>"></script>

        <script>

            function adjustHeightOfPage(pageNo) {

                var pageContentHeight = 0;

                var pageType = $('div[data-page-no="' + pageNo + '"]').data("page-type");

                if( pageType != undefined && pageType == "gallery") {
                    pageContentHeight = $(".cd-hero-slider li:nth-of-type(" + pageNo + ") .tm-img-gallery-container").height();
                }
                else {
                    pageContentHeight = $(".cd-hero-slider li:nth-of-type(" + pageNo + ") .js-tm-page-content").height() + 20;
                }
               
                // Get the page height
                var totalPageHeight = $('.cd-slider-nav').height()
                                        + pageContentHeight
                                        + $('.tm-footer').outerHeight();

                // Adjust layout based on page height and window height
                if(totalPageHeight > $(window).height()) 
                {
                    $('.cd-hero-slider').addClass('small-screen');
                    $('.cd-hero-slider li:nth-of-type(' + pageNo + ')').css("min-height", totalPageHeight + "px");
                }
                else 
                {
                    $('.cd-hero-slider').removeClass('small-screen');
                    $('.cd-hero-slider li:nth-of-type(' + pageNo + ')').css("min-height", "100%");
                }
            }

            /*
                Everything is loaded including images.
            */
            $(window).load(function(){

                adjustHeightOfPage(1); // Adjust page height

                /* Gallery One pop up
                -----------------------------------------*/
                $('.gallery-one').magnificPopup({
                    delegate: 'a', // child items selector, by clicking on it popup will open
                    type: 'image',
                    gallery:{enabled:true}                
                });
				
                /* Collapse menu after click 
                -----------------------------------------*/
                $('#tmNavbar a').click(function(){
                    $('#tmNavbar').collapse('hide');

                    adjustHeightOfPage($(this).data("no")); // Adjust page height       
                });

                /* Browser resized 
                -----------------------------------------*/
                $( window ).resize(function() {
                    var currentPageNo = $(".cd-hero-slider li.selected .js-tm-page-content").data("page-no");
                    
                    // wait 3 seconds
                    setTimeout(function() {
                        adjustHeightOfPage( currentPageNo );
                    }, 1000);
                    
                });
        
                // Remove preloader (https://ihatetomatoes.net/create-custom-preloading-screen/)
                $('body').addClass('loaded');

                // Write current year in copyright text.
                $(".tm-copyright-year").text(new Date().getFullYear());
                           
            });
        </script> 
    <?php endif; ?>
</body>
</html>