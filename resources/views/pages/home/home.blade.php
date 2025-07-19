@extends('Main.app')


@section('body')
<div class="wrapper">
    <!-- Sidebar -->

    <div class="content">
        <!-- Topbar -->

        <!-- Page Content -->
        <div class="container-fluid px-4 mt-4">

            <!-- Stats Row -->
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card primary">
                        <div class="card-body">
                            <div class="label">تعداد اقامتگران</div>
                            <div class="number">142</div>
                            <i class="fas fa-users fa-2x text-primary mt-2"></i>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card success">
                        <div class="card-body">
                            <div class="label">تخت‌های خالی</div>
                            <div class="number">28</div>
                            <i class="fas fa-bed fa-2x text-success mt-2"></i>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card warning">
                        <div class="card-body">
                            <div class="label">سررسیدها</div>
                            <div class="number">15</div>
                            <i class="fas fa-calendar-times fa-2x text-warning mt-2"></i>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card danger">
                        <div class="card-body">
                            <div class="label">بدهی‌ها</div>
                            <div class="number">7</div>
                            <i class="fas fa-exclamation-triangle fa-2x text-danger mt-2"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ردیف سررسید ها و رزرو ها و شبانه ها -->
            <div class="row">
                <!-- Due Dates -->
                <div class="col-lg-7">
                    <div class="card ">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span class="span-sarrsed">سررسیدها</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr class="tr-sarrsed">
                                            <th>#</th>
                                            <th>اتاق</th>
                                            <th>تخت / کل</th>
                                            <th>نام</th>
                                            <th>تلفن</th>
                                            <th>سررسید</th>
                                            <th>مانده</th>
                                            <th>توضیحات</th>
                                            <th>عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>210</td>
                                            <td>2 <i class="fa-solid fa-grip-lines-vertical"></i> 2</td>
                                            <td>مصطفی ساغریان</td>
                                            <td>0903-536-4999</td>
                                            <td>1404/4/26</td>
                                            <td><span class="badge status-badge bg-warning">0</span></td>
                                            <td style="max-width: 250px;">
                                                <span class="badge rounded-pill text-bg-info">250 شسیببدهکار</span>
                                                <span class="badge rounded-pill text-bg-info">250 شسیبشسیببدهکار</span>
                                                <span class="badge rounded-pill text-bg-info">250 بدهکار</span>
                                                <span class="badge rounded-pill text-bg-info">250 بدهکار</span>
                                                <span class="badge rounded-pill text-bg-info">250 بدهکار</span>
                                                <span class="badge rounded-pill text-bg-info">250 بدهکار</span>
                                                <span class="badge rounded-pill text-bg-info">250 بدهکار</span>
                                            </td>
                                            <td>
                                                <a href="#" class="text-primary action-btn">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reservations & Nightly -->
                <div class="col-lg-5">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span class='span-rezerve'>رزروها</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr class="tr-rezerve">
                                            <th>#</th>
                                            <th>اتاق</th>
                                            <th>تخت / کل</th>
                                            <th>نام</th>
                                            <th>تلفن</th>
                                            <th>سررسید</th>
                                            <th>مانده</th>
                                            <th>توضیحات</th>
                                            <th>عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>108</td>
                                            <td>زند</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>1404/4/24</td>
                                            <td>
                                                <a href="#" class="text-primary action-btn">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span class="span-shabaneh">شبانه‌ها</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr class="tr-shabaneh">
                                            <th>#</th>
                                            <th>اتاق</th>
                                            <th>تخت / کل</th>
                                            <th>نام</th>
                                            <th>تلفن</th>
                                            <th>سررسید</th>
                                            <th>مانده</th>
                                            <th>توضیحات</th>
                                            <th>عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>108</td>
                                            <td>زند</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>1404/4/24</td>
                                            <td>
                                                <a href="#" class="text-primary action-btn">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ردیف های تخت خالی و خروجی ها -->
            <div class="row mt-4">
                <!-- Exits -->
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span class="span-exit">خروجی‌ها</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr class="tr-exit">
                                            <th>#</th>
                                            <th>اتاق</th>
                                            <th>تخت / کل</th>
                                            <th>نام</th>
                                            <th>تلفن</th>
                                            <th>سررسید</th>
                                            <th>مانده</th>
                                            <th>توضیحات</th>
                                            <th>عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>210</td>
                                            <td>2/2</td>
                                            <td>مصطفی ساغریان</td>
                                            <td>0903-536-4999</td>
                                            <td>1404/4/26</td>
                                            <td><span class="badge status-badge bg-warning">0</span></td>
                                            <td style="max-width: 250px;">sdf</td>
                                            <td>
                                                <a href="#" class="text-primary action-btn">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vacancies -->
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span class="span-empty">تخت‌های خالی</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr class="tr-empty">
                                            <th>#</th>
                                            <th>اتاق</th>
                                            <th>تعداد تخت</th>
                                            <th>شماره تخت</th>
                                            <th>عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>101</td>
                                            <td>4</td>
                                            <td>1,2,3,4</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary">
                                                    <i class="fas fa-plus"></i> افزودن
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>105</td>
                                            <td>2</td>
                                            <td>1,2</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary">
                                                    <i class="fas fa-plus"></i> افزودن
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>201</td>
                                            <td>3</td>
                                            <td>1,2,3</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary">
                                                    <i class="fas fa-plus"></i> افزودن
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- فرم - مدارک - توضیحات -->
            <div class="row mt-4">
                <!-- Documents -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>مدارک</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>اتاق</th>
                                            <th>نام</th>
                                            <th>تلفن</th>
                                            <th>سررسید</th>
                                            <th>توضیح</th>
                                            <th>عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>108</td>
                                            <td>زند</td>
                                            <td>1404/4/24</td>
                                            <td></td>
                                            <td style="max-width: 250px;"></td>
                                            <td>
                                                <a href="#" class="text-success action-btn">
                                                    <i class="fas fa-check-circle"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Forms -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>فرم‌ها</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>اتاق</th>
                                            <th>نام</th>
                                            <th>تلفن</th>
                                            <th>سررسید</th>
                                            <th>توضیح</th>
                                            <th>عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>303</td>
                                            <td></td>
                                            <td>عبدالرضا وزیری</td>
                                            <td>1404/4/1</td>
                                            <td style="max-width: 250px;"></td>
                                            <td>
                                                <a href="#" class="text-success action-btn">
                                                    <i class="fas fa-check-circle"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Debts -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>بدهی‌ها</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>اتاق</th>
                                            <th>نام</th>
                                            <th>تلفن</th>
                                            <th>سررسید</th>
                                            <th>توضیح</th>
                                            <th>عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>303</td>
                                            <td></td>
                                            <td>عبدالرضا وزیری</td>
                                            <td>1404/4/1</td>
                                            <td style="max-width: 250px;"></td>
                                            <td>
                                                <a href="#" class="text-primary action-btn">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
@endsection
