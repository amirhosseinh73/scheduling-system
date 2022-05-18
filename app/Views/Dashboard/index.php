<article class="col px-0">
    <div class="dashboard-main-container align-content-center">
        <h6 class="title text-dark-2 col-12 m-0 text-center">
            <?= type_user_text( $user_info ); ?>
            <abbr id="user_fullname_gender"><?= gender_text( $user_info ) . $user_info->lastname; ?></abbr>
        </h6>
        <p class="title text-dark-2 col-12 m-0 text-center">خوش آمدید!</p>
    </div>
</article>