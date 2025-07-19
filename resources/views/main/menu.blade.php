{{-- <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">

        <div class="d-flex justify-content-start">
                <!-- بخش جستجو -->

                    <div class="search-bar ms-auto">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search..." aria-label="Search"
                                aria-describedby="search-addon" id="ajaxSearch">
                            <button class="btn btn-outline-secondary" type="button" id="search-addon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-search" viewBox="0 0 16 16">
                                    <path
                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                </svg>
                            </button>
                        </div>
                        <!-- نتایج (مخفی در ابتدا) -->
                        <div id="ajaxResults"
                            style="display: none; position: absolute; z-index: 1000; background: white; border: 1px solid #ddd;border-radius: 25px">
                        </div>
                    </div>

                <div>
                    <ul class="navbar-nav">

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('show.reservation') }}">رزرو کردن</a>
                        </li>
                        <!-- Dropdown -->
                        <li class="nav-item">
                            <a class="nav-link ">
                                گزارش‌ها
                            </a>
                            <ul class="dropdown-menu">
                                <li> <a class="nav-link" href="{{ route('search.showList') }}">اقامتگران</a></li>
                                <li> <a class="nav-link" href="{{ route('search.ends.showList') }}">اقامتگران خروجی</a></li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('thakts.show') }}">آمار تخت ها</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('list') }}">لیست اقامتگران</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('main') }}">صفحه اصلی</a>
                        </li>


                    </ul>
                </div>
        </div>


    </div>
</nav> --}}
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <!-- بخش جستجو (چپ) -->
        <div class="d-flex justify-content-start align-items-center">
            <div class="search-bar">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search..." aria-label="Search"
                        aria-describedby="search-addon" id="ajaxSearch">
                    <button class="btn btn-outline-secondary" type="button" id="search-addon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                        </svg>
                    </button>
                </div>
                <!-- نتایج (مخفی در ابتدا) -->
                <div id="ajaxResults"
                    style="display: none; position: absolute; z-index: 1000; background: white; border: 1px solid #ddd;border-radius: 25px">
                </div>
            </div>
        </div>

        <!-- منو (راست) -->
        <div class="d-flex justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">جابجایی</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">رزرو کردن</a>
                </li>
                <!-- Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        گزارش‌ها
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">اقامتگران</a></li>
                        <li><a class="dropdown-item" href="#">اقامتگران خروجی</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">آمار تخت ها</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">لیست اقامتگران</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">صفحه اصلی</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
