<footer class="footer container-fluid">
        <div class="d-flex flex-column">
            <section class="row top">
                <div class="col-12 col-sm-5 col-md-5">
                    <div class="row footer-large-button">
                        <section class="col-6 col-sm-6">
                            <i class="fad fa-phone-volume"></i>
                            <p>مشاوره تلفنی</p>
                        </section>
                        <section class="col-6 col-sm-6">
                            <i class="fad fa-user-group"></i>
                            <p>مشاوره حضوری</p>
                        </section>
                        <section class="col-6 col-sm-6">
                            <i class="fad fa-earth"></i>
                            <p>مشاوره آنلاین</p>
                        </section>
                        <section class="col-6 col-sm-6">
                            <i class="fad fa-file-invoice"></i>
                            <p>آزمون آنلاین</p>
                        </section>
                    </div>
                </div>
                <div class="col-12 col-sm-7 col-md-5 footer-list">
                    <h4 class="title">خدمات مرکز</h4>
                    <ul class="ul-list">
                        <li>
                            <a href="#">مشاوره ازدواج</a>
                        </li>
                        <li>
                            <a href="#">مشاوره ازدواج</a>
                        </li>
                        <li>
                            <a href="#">مشاوره ازدواج</a>
                        </li>
                        <li>
                            <a href="#">مشاوره ازدواج</a>
                        </li>
                        <li>
                            <a href="#">مشاوره ازدواج</a>
                        </li>
                        <li>
                            <a href="#">مشاوره ازدواج</a>
                        </li>
                        <li>
                            <a href="#">مشاوره ازدواج</a>
                        </li>
                        <li>
                            <a href="#">مشاوره ازدواج</a>
                        </li>
                        <li>
                            <a href="#">مشاوره ازدواج</a>
                        </li>
                        <li>
                            <a href="#">مشاوره ازدواج</a>
                        </li>
                        <li>
                            <a href="#">مشاوره ازدواج</a>
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
    <script type="text/javascript" src="<?= base_url( "/assets/js/lib/bootstrap.bundle.min.js" )?>"></script>
    <script type="text/javascript" src="<?= base_url( "/assets/js/lib/swiper-bundle.min.js" )?>"></script>
    <script type="text/javascript" src="<?= base_url( "/assets/js/lib/sweetalert2.min.js" )?>"></script>
    <script type="text/javascript" src="<?= base_url( "/assets/js/global/config.js" )?>"></script>
    <script type="text/javascript" src="<?= base_url( "/assets/js/global/helper.js" )?>"></script>
    <script type="text/javascript" src="<?= base_url( "/assets/js/global/Alert.js" )?>"></script>

    <?php if ( $page_name === "index" ) : ?>
        <script type="text/javascript" src="<?= base_url( "/assets/js/page/index.js" )?>"></script>
    <?php elseif( $page_name === "register" ) : ?>
        <script type="text/javascript" src="<?= base_url( "/assets/js/page/Register.js" )?>"></script>
    <?php elseif( $page_name === "login" ) : ?>
        <script type="text/javascript" src="<?= base_url( "/assets/js/page/Login.js" )?>"></script>
    <?php endif; ?>
</body>
</html>