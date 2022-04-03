            </div>
            <!-- End Page-content -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row dir-ltr text-right">
                        <div class="col-sm-6">
                            © BookMo. <script>document.write(new Date().getFullYear())</script>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-right d-none d-sm-block">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

</div>
<!-- end container-fluid -->
<!-- Theme assets -->
<script src="<?= base_url() ?>/assets/template/libs/jquery/jquery.min.js"></script>
<script src="<?= base_url() ?>/assets/template/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>/assets/template/libs/metismenu/metisMenu.min.js"></script>
<script src="<?= base_url() ?>/assets/template/libs/simplebar/simplebar.min.js"></script>
<script src="<?= base_url() ?>/assets/template/libs/node-waves/waves.min.js"></script>
<script src="<?= base_url() ?>/assets/template/libs/sweetalert2/sweetalert2.min.js"></script>

<!-- <script src="<?= base_url() ?>/assets/template/libs/select2/js/select2.min.js"></script> -->
<script src="<?= base_url() ?>/assets/template/js/app.js"></script>

<?php if ( isset( $js ) ) :?>

    <script src="<?= base_url() ?>/assets/project/js/config.js"></script>
    <script src="<?= base_url() ?>/assets/project/js/helper.js"></script>
    <script src="<?= base_url() ?>/assets/project/js/component/paginate.js"></script>

    <?php if ( in_array( "login", $js ) ): ?>
        <script src="<?= base_url() ?>/assets/project/js/page/login.js"></script>
    <?php endif;?>

    <?php if ( in_array( "dashboard", $js ) ): ?>

        <!-- apexcharts -->
        <script src="<?= base_url() ?>/assets/template/libs/apexcharts/apexcharts.min.js"></script>

        <!-- jquery.vectormap map -->
        <script src="<?= base_url() ?>/assets/template/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="<?= base_url() ?>/assets/template/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js"></script>

        <script src="<?= base_url() ?>/assets/template/js/pages/dashboard.init.js"></script>

    <?php endif;?>

    <?php if ( in_array( "package", $js ) ): ?>
        <script src="<?= base_url() ?>/assets/project/js/page/package.js"></script>
    <?php endif;?>

    <?php if ( in_array( "lesson_head", $js ) ): ?>
        <script src="<?= base_url() ?>/assets/project/js/page/lesson-head.js"></script>
    <?php endif;?>

    <?php if ( in_array( "lesson", $js ) ): ?>
        <script src="<?= base_url() ?>/assets/project/js/page/lesson.js"></script>
    <?php endif;?>

    <?php if ( in_array( "license", $js ) ): ?>
        <script src="<?= base_url() ?>/assets/project/js/page/license.js"></script>
    <?php endif;?>

    <?php if ( in_array( "user", $js ) ): ?>
        <script src="<?= base_url() ?>/assets/project/js/page/user.js"></script>
    <?php endif;?>

<?php endif;?>

</body>
</html>