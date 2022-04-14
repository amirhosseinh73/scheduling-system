</div>
    </main>

    <footer class="dashboard-footer container-fluid">
        <div class="d-flex flex-column">
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
    <script type="text/javascript" src="<?= base_url( "/assets/js/lib/sweetalert2.min.js" )?>"></script>
    <script type="text/javascript" src="<?= base_url( "/assets/js/global/config.js" )?>"></script>
    <script type="text/javascript" src="<?= base_url( "/assets/js/global/helper.js" )?>"></script>
    <script type="text/javascript" src="<?= base_url( "/assets/js/global/Alert.js" )?>"></script>
    <script type="text/javascript" src="<?= base_url( "/assets/js/page/dashboard/Dashboard.js" )?>"></script>
    
    <?php if( $page_name === "booking_index" ) : ?>
        <script type="text/javascript" src="<?= base_url( "/assets/js/lib/mds.bs.datetimepicker.js" )?>"></script>
        <script type="text/javascript" src="<?= base_url( "/assets/js/lib/mdtimepicker.js" )?>"></script>
        <script type="text/javascript" src="<?= base_url( "/assets/js/page/dashboard/Booking.js" )?>"></script>
    <?php endif; ?>
</body>
</html>