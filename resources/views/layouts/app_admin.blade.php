<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://getbootstrap.com/docs/5.3/assets/css/docs.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nouislider@14.6.4/distribute/nouislider.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="shortcut icon" href="{{ asset('images/chungcu.svg') }}" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <title>Quản lý nhà trọ</title>

</head>

<body>
    <header class="container-fluid header_admin navbar-fixed-top">

        <nav class="navbar navbar-expand-sm navbar-dark  d-flex justify-content-around">

            <a href="{{ asset('/admin') }}" class="navbar-brand">Admin - Quản lý phòng trọ</a>

            <div class=" " id="collapsibleNavId">
                <ul class="navbar-nav">

                    @if(Auth::check())
                    <li class="nav-item navbarli">
                        <a href="{{ route('profileAdmin') }}" class="nav-link navbarli">
                            <i class="fa-regular fa-user"></i> Hello {{ Auth::user()->name }}
                        </a>
                    </li>
                    @else

                    <script>
                        window.location = "{{ route('login-admin') }}";
                    </script>
                    @endif

                    <li class="nav-item navbarli mx-2">
                        <a class="nav-link navbarli" href="{{ route('edit_profileAdmin_password') }}"><i
                                class="fa-solid fa-unlock-keyhole "></i> Mật khẩu</a>
                    </li>
                    <li class="nav-item navbarli ">
                        <a class="nav-link navbarli" href="{{ URL::to('admin/logout') }}"><i
                                class="fa-solid fa-arrow-right-from-bracket px-2 "></i>Đăng xuất </a>
                    </li>
                </ul>
            </div>
        </nav>

    </header>
    <script>
        // JavaScript để xác định trang hiện tại và cập nhật kiểu CSS cho liên kết tương ứng
        document.addEventListener('DOMContentLoaded', function() {
            // Lấy đường dẫn của trang hiện tại
            var currentPath = window.location.pathname;
            // Lặp qua tất cả các liên kết trong menu
            var links = document.querySelectorAll('.btn_menu');
            links.forEach(function(link) {
                // So sánh đường dẫn của liên kết với đường dẫn của trang hiện tại
                if (link.getAttribute('href') === currentPath) {
                    // Nếu trùng khớp, thêm lớp 'active' để nổi bật liên kết đó
                    link.classList.add('active');
                }
            });
        });
    </script>
    <main class="main_admin">
        <div class="container-fluid">
            <div class="row flex-nowrap">
                <div class="col-auto fixed-left col-md-3 col-xl-2 px-sm-2 px-4 menu ">
                    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 min-vh-100 menu_w">
                        <a
                            class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-dark text-dark   text-decoration-none">
                            <span class="fs-5 d-none d-sm-inline mx-3">Menu</span>
                        </a>
                        <ul class="nav nav-pills text-dark flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                            id="menu">
                            <div class="w-90"><a class="btn btn_menu" href="/admin/ql_loai"> Quản lý loại nhà trọ </a>
                            </div>
                            <div class="w-90"><a class="btn btn_menu" href="/admin/ql_phongtro"> Phòng trọ </a></div>
                            <div class="w-90"><a class="btn btn_menu" href="/admin/ql_dangbai">Quản lý bài đăng</a>
                            </div>
                            <div class="w-90"><a class="btn btn_menu" href="/admin/ql_user">Quản lý người dùng</a></div>
                            <div class="w-90"><a class="btn btn_menu" href="/admin/thong-ke">Thống kê</a></div>
                        </ul>

                        <hr>

                    </div>
                </div>
                <div class="col-sm m-5">

                    @yield('content')
                    @yield('danhsach_phongtro')

                </div>
            </div>
        </div>
    </main>
</body>
<script src="{{ asset('js/main.js') }}"> </script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>

</html>
