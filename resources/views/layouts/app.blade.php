<html lang="vn">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nouislider@14.6.4/distribute/nouislider.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css" />
    <script src='https://cdn.jsdelivr.net/gh/vietblogdao/js/districts.min.js'></script>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    {{-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo/dist/echo.min.js"></script>
    <script src="{{ asset('js/bootstrap.js') }}"> </script> --}}

    <title>Nhà trọ</title>

</head>

<body>
    <header class="sticky-top navbar-fixed-top  fixed-top" id="header">
        <nav class="navbar navbar-expand-lg  " id="nav">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse row" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 row col-lg-7 navbar_ul_search">
                        <li class="nav-item active col-lg-3 py-3 li_a trang_chu">
                            <a href="{{ route('index') }}" class="nav-link a_icon text-center"><i class="fa fa-house mx-1"></i>
                                Trang chủ</a>
                        </li>
                        <li class="nav-item col-lg-3 py-3 about ">
                            <a href="/about" class="nav-link a_icon text-center ">
                                <i class="fa fa-book mx-1"></i>Giới Thiệu
                            </a>
                        </li>
                        <form action="/tim-kiem" class="col-lg-5" action="" method="POST">

                            @csrf
                            @method('POST')
                            <div class="input-group search_div w-100 m-2">
                                <input type="search" id="inputField1" class="form-control" name="tukhoa"
                                    placeholder="Tìm kiếm nhà trọ" aria-label="Recipient's username"
                                    aria-describedby="button-addon2" autocomplete="off">
                                <input class="btn btn-outline-danger" name="timkiem_sp" type="submit" value="Tìm"
                                    id="button-addon2">
                            </div>
                            <div id="suggestion-box" class="dropdown-menu" style="display: none;">
                                <!-- resources/views/search/suggestions.blade.php -->

                            </div>

                        </form>

                    </ul>
                    <ul class="d-flex navbar-nav me-auto mb-2 mb-lg-0 row col-lg-5 nav_manager_post">

                        <li class="nav-item col-lg-5 py-3 mx-1 baidang">

                            <a href="{{ route('bai_dang') }}" class="nav-link a_icon  li_a text-center">
                                <i class="fa-solid fa-list mx-1"></i>
                                <span>Bài đăng</span>
                            </a>

                        </li>

                        <li class="nav-item col-lg-6 py-3 profile_nav">

                            @if(Auth::check())
                            <div class="dropdown " id="drop_profile">
                                <a href="" class="btn btn-light dropdown-toggle avatar-container li-avt " type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="rounded-avatar">
                                        @if(isset($avatarUrl))
                                        <img src="{{ asset('images/'.$avatarUrl) }}" alt="Avatar">
                                        @else
                                        <img src="{{ asset('images/nen.png') }}" alt="Avatar">
                                        @endif
                                    </div>
                                    <p class="mt-3 text-truncate"> {{ Auth::user()->name}}</p>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="/profile">
                                            <p><i class="fa-regular fa-user" style="color: #1d3490;"></i> Thông tin</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/wishList">

                                            <p><i class="fa-regular fa-heart" style="color: #e6461e;"></i> Yêu thích</p>
                                        </a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('logout') }}"><i
                                                class="fa-solid fa-arrow-right-from-bracket a_icon"
                                                style="color: #aaadb1;"></i> Đăng xuất</a></li>
                                </ul>
                            </div>
                            @else
                            <a href="/login" class="btn btn-light nav_tk"><i class="fa-solid fa-right-to-bracket"></i>
                                Đăng nhập</a>

                            @endif

                        </li>
                    </ul>

                </div>
            </div>
        </nav>

    </header>

    <main>
        @yield('content')
    </main>
    <footer class=" py3" id="footer">
        <div class="row text-while">
            <div class="col-sm ">
                <h4 class="">Liên Hệ</h4>
                 <hr>
                <p><b>Địa chỉ: </b> Đường 3/2, Ninh kiều, Cần Thơ</p>
                <p><b>Số Điện Thoại: </b> 0779893046</p>
                <p><b>Email: </b> tuanvu19042002@gmail.com</p>
                <p><b>Giờ mở cửa: </b> từ thứ 2 đến chủ nhật 7h30 đến 20h</p>

            </div>
            <div class="col-sm " id="footer-center">
                <h4 class="">Về cửa hàng</h4>
                 <hr>
                <p><a href="/" class="nav-link">Trang chủ</a></p>
                <p><a href="/ql_dangbai" class="nav-link">Quản lý bài đăng</a></p>
                <p><a href="/about" class="nav-link">Giới thiệu</a> </p>
            </div>
            <div class="col-sm " id="footer-center">
                <h4 class="">Liên kết</h4>
                 <hr>
                <p><a href="/index" class="nav-link"><i class="fa-brands fa-facebook fa-lg"
                            style="color: #e2e2e4;"></i> Facebook</a></p>
                
                <p><a href="/about" class="nav-link"><i class="fa-brands fa-instagram fa-lg"
                            style="color: #e2e2e4;"></i> Instagram</a> </p>
                           
                       
            </div>
        </div>

    </footer>
</body>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>  --}}
{{-- <script src="{{ asset('node_modules/nouislider/dist/nouislider.min.js') }}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/nouislider@14.6.4/distribute/nouislider.min.js"></script>
{{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

{{-- <script src="node_modules/slick-carousel/slick/slick.min.js"></script> --}}
<script src="{{ asset('js/main.js') }}"> </script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var path = window.location.pathname;
        var homeLink = document.querySelector('.trang_chu');
        var aboutLink = document.querySelector('.about');
        var post = document.querySelector('.baidang');
        homeLink.classList.remove('active');
        aboutLink.classList.remove('active');
        post.classList.remove('active');
        if (path === '/') {
            homeLink.classList.add('active');
        } else if (path === '/about') {
            aboutLink.classList.add('active');
        } else if (path === '/ql_dangbai') {
            post.classList.add('active');
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('#inputField1').keyup(function() {
            var query = $(this).val();
            if (query != '') {
                $.ajax({
                    url: "{{ route('search.suggestions') }}",
                    method: "GET",
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#suggestion-box').empty();
                        var suggestions = data.suggestions;
                        if (suggestions.length > 0) {
                            var suggestionList = '<ul>';
                            suggestions.forEach(function(suggestion) {
                                suggestionList += '<li class="px-2">' + suggestion + '</li>';
                            });
                            suggestionList += '</ul>';
                            $('#suggestion-box').append(suggestionList);
                            $('#suggestion-box').fadeIn();
                        } else {
                            $('#suggestion-box').fadeOut();
                        }
                    }
                });
            } else {
                $('#suggestion-box').fadeOut();
            }
        });
        $(document).on('click', 'li', function() {
            $('#inputField1').val($(this).text());
            $('#suggestion-box').fadeOut();
        });
    });
</script>

</html>