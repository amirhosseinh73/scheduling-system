const Paginate = {
    offset    : 0, //page number, page numbers start from 1 and offset start from 0
    limit     : 5, //number of show items on each page
    max       : 8, //maximum of show total page numbers
    min       : 3, //minimum of page number show around active page
    number    : 0, //total page number. ceil ( count all data / limit )
    urlParams : () => { return "offset=" + Paginate.offset + "&limit=" + Paginate.limit; },
    route     : window.location.href,
    history   : window.location.href,
    request   : "GET",
    callback  : async () => {},
}

let PaginateDataCache = new Array();
let AllPackages       = new Array();
let AllHeads          = new Array();
let AllUsers          = new Array();

const RoutesAdmin = {
    //api
    login               : base_url + "/api/user/login",

    //packages
    packageCreate        : base_url + "/admin/api/package/create",
    packageRemove        : base_url + "/admin/api/package/remove",
    packageEdit          : base_url + "/admin/api/package/edit",
    packageList          : base_url + "/admin/api/package/list",
    packageCountPaginate : base_url + "/admin/api/package/paginate",

    //lessons: head
    lessonHeadList          : base_url + "/admin/api/lesson/head/list",
    lessonHeadCountPaginate : base_url + "/admin/api/lesson/head/paginate",
    lessonHeadCreate        : base_url + "/admin/api/lesson/head/create",
    lessonHeadRemove        : base_url + "/admin/api/lesson/head/remove",
    lessonHeadEdit          : base_url + "/admin/api/lesson/head/edit",
    //lessons: lesson
    lessonList              : base_url + "/admin/api/lesson/list",
    lessonCountPaginate     : base_url + "/admin/api/lesson/paginate",
    lessonCreate            : base_url + "/admin/api/lesson/create",
    lessonRemove            : base_url + "/admin/api/lesson/remove",
    lessonEdit              : base_url + "/admin/api/lesson/edit",
    lessonListHeadByPackage : base_url + "/admin/api/lesson/head-list",

    //license
    licenseList          : base_url + "/admin/api/license/list",
    licenseCountPaginate : base_url + "/admin/api/license/paginate",
    licenseCreate        : base_url + "/admin/api/license/create",
    licenseRemove        : base_url + "/admin/api/license/remove",
    licenseEdit          : base_url + "/admin/api/license/edit",

    //user
    userList          : base_url + "/admin/api/user/list",
    userCountPaginate : base_url + "/admin/api/user/paginate",
    userCreate        : base_url + "/admin/api/user/create",
    userRemove        : base_url + "/admin/api/user/remove",
    userEdit          : base_url + "/admin/api/user/edit",

    //view
    packageListView    : base_url + "/admin/package/list",
    lessonHeadListView : base_url + "/admin/lesson/head/list",
    lessonListView     : base_url + "/admin/lesson/list",
    licenseListView    : base_url + "/admin/license/list",
    userListView       : base_url + "/admin/user/list",
}

let ID_NAME = "";