<article class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">لیست مجوز ها</h4>

                <button id="btn_license_create" type="button" class="btn btn-success px-5 waves-effect waves-light mb-4 ml-auto d-block">ایجاد</button>
                
                <div class="table-responsive">
                    <table class="table table-centered table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">کد</th>
                                <th scope="col">محدودیت استفاده</th>
                                <th scope="col">تعداد استفاده شده</th>
                                <th scope="col">لیست پکیج ها</th>
                                <th scope="col">لیست کاربرانی که حق استفاده دارند</th>
                                <th scope="col">لیست کاربرانی که استفاده کرده اند</th>
                                <th scope="col">وضعیت</th>
                                <th scope="col">زمان ایجاد</th>
                                <th scope="col">زمان آخرین به روز رسانی</th>
                                <th scope="col">عملیات</th>
                            </tr>
                        </thead>
                        <tbody id="list_license">
                            
                        </tbody>
                    </table>

                </div>

                <div class="mt-3 paginate-selector">
                    <ul class="pagination pagination-rounded justify-content-center mb-0">
                        <li class="page-item previous">
                            <a class="page-link" href="javascript:void(1)">قبلی</a>
                        </li>

                        <li class="page-item next">
                            <a class="page-link" href="javascript:void(1)">بعدی</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</article>