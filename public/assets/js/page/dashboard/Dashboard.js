class Dashboard {

    sideNavProfileHTML = () => {
        return `
        <div class="side-nav-profile">
            <ul>
                <li>
                    <button type="button" id="btn_side_nav_edit_profile">
                        <i class="fas fa-user"></i>
                        <abbr>ویرایش پروفایل</abbr>
                    </button>
                </li>
                <li>
                    <button type="button" id="btn_side_nav_logout">
                        <i class="fas fa-sign-out"></i>
                        <abbr>خروج</abbr>
                    </button>
                </li>
            </ul>
        </div>
        `;
    }

    get sideNavProfileMenuSelector() {
        return document.querySelector( ".side-nav-profile" );
    }

    sideNavProfileHandler = ( event ) => {
        event.stopPropagation();

        const body = document.body;

        const html = this.sideNavProfileHTML();
        body.insertAdjacentHTML( "beforeend", html );
        
        body.offsetWidth;
        this.sideNavProfileMenuSelector.style.left = 0;

        this.logoutEvent();
        this.closeSideNav();
    }

    get sideNavProfileSelector() {
        return document.querySelector( ".nav-profile" );
    }

    sideNavProfileClick = () => {
        this.sideNavProfileSelector.addEventListener( "click", this.sideNavProfileHandler );
    }

    get btnSideNavEditProfileSelector() {
        return document.getElementById( "btn_side_nav_edit_profile" );
    }

    get btnSideNavLogoutSelector() {
        return document.getElementById( "btn_side_nav_logout" );
    }

    logoutEvent = () => {
        this.btnSideNavLogoutSelector.addEventListener( "click", this.logoutEventHandler );
    }

    logoutEventHandler = () => {
        window.location.href = base_url + "/logout";
    }

    closeSideNavHandler = ( event ) => {
        if ( event.target.closest( ".side-nav-profile" ) ) return;

        this.sideNavProfileMenuSelector.style.left = - this.sideNavProfileMenuSelector.offsetWidth + "px";
        setTimeout( () => {
            this.sideNavProfileMenuSelector.remove();
        }, 300);
    }

    closeSideNav = () => {
        const body = document.body;

        body.addEventListener( "click", this.closeSideNavHandler );
    }

    init = () => {
        this.sideNavProfileClick();
    }

    static run = () => {
        const dashboard = new Dashboard;
        dashboard.init();
    }
}

init = () => {
    Dashboard.run();
}

doc_ready( init );