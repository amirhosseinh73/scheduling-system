<ul class="metismenu list-unstyled" id="side-menu">
    <li class="menu-title">منو</li>

    <li>
        <a href="<?= base_url( "admin/dashboard" ) ?>" class="waves-effect">
            <i class="mdi mdi-airplay"></i>
            <span>داشبورد</span>
        </a>
    </li>

    <li>
        <a href="javascript:void(0)" class="has-arrow waves-effect">
            <i class="mdi mdi-package"></i>
            <span>پکیج ها</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="<?= base_url( "admin/package/list" ) ?>">لیست</a></li>
            <li><a href="<?= base_url( "admin/package/create" ) ?>">ایجاد</a></li>
        </ul>
    </li>

    <li>
        <a href="javascript:void(1)" class="has-arrow waves-effect">
            <i class="mdi mdi-package-down"></i>
            <span>درس ها</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="<?= base_url( "admin/lesson/head/list" ) ?>">سرفصل ها</a></li>
            <li><a href="<?= base_url( "admin/lesson/list" ) ?>">درس ها</a></li>
        </ul>
    </li>

    <li>
        <a href="<?= base_url( "admin/license/list" ) ?>" class="waves-effect">
            <i class="mdi mdi-license"></i>
            <span>مجوز ها</span>
        </a>
    </li>

    <li>
        <a href="<?= base_url( "admin/user/list" ) ?>" class="waves-effect">
            <i class="mdi mdi-contacts"></i>
            <span>کاربران</span>
        </a>
    </li>

</ul>