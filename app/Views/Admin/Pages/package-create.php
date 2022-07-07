<article class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">ایجاد پکیج</h4>

                <form id="package_create" enctype="multipart/form-data">
                    <div class="row align-items-end">
                        <div class="col-12 col-sm-6 mb-4">
                            <label for="title">عنوان</label>
                            <input id="title" type="text" class="form-control" placeholder="عنوان"/>
                        </div>
                        <div class="col-12 col-sm-6 mb-4">
                            <label for="description">توضیحات</label>
                            <textarea id="description" type="text" class="form-control" placeholder="توضیحات" ></textarea>
                        </div>
                        <div class="col-12 col-sm-6 mb-4">
                            <label for="grade">پایه</label>
                            <select id="grade" class="form-control custom-select">
                                <option value="none">انتخاب</option>
                                <optgroup label="لیست پایه ها">
                                    <option value="1">Lower Primary</option>
                                    <option value="2">Upper Primary</option>
                                    <option value="3">Lower Secondary</option>
                                    <option value="4">Upper Secondary</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6 mb-4">
                            <label for="image">عکس</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image">
                                <label class="custom-file-label" for="image">انتخاب فایل</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-3 mb-4">
                            <label for="price">قیمت</label>
                            <input id="price" type="text" data-type="number" class="form-control" placeholder="قیمت"/>
                        </div>
                        <div class="col-12 col-sm-3 mb-4">
                            <label for="discount">تخفیف</label>
                            <input id="discount" type="text" data-type="number" class="form-control" placeholder="تخفیف"/>
                        </div>

                        <div class="col-12 col-sm-6 mb-4">
                            <button type="submit" class="btn btn-success waves-effect waves-light btn-block">
                                ثبت
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</article>

<article class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">لیست پکیج های ایجاد شده</h4>

                <div class="table-responsive">
                    <table class="table table-centered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">عنوان</th>
                                <th scope="col">توضیحات</th>
                                <th scope="col">پایه</th>
                                <th scope="col">قیمت</th>
                                <th scope="col">تخفیف</th>
                                <th scope="col">تصویر</th>
                                <th scope="col">زمان ایجاد</th>
                            </tr>
                        </thead>
                        <tbody id="created_packages_list">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</article>