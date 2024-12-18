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
    <script src="https://cdn.jsdelivr.net/npm/plotly.js-dist@2.20.0/dist/plotly.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    

    <!-- Tải jQuery trước -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/gh/vietblogdao/js/districts.min.js"></script>
    
    <!-- Tải Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Tải DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- Tải DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <title>Quản lý nhà trọ</title>
</head>

<body>
    <header class="container-fluid header_admin navbar-fixed-top ">

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
                            <span class="d-none d-sm-inline mx-3 running-border1" style="font-size: 1.75rem !important; ">Menu</span>
                        </a>
                        <ul class="nav nav-pills text-dark flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                            id="menu">
                            <div class="w-90"><a class="btn btn_menu" href="/admin/ql_loai"> Quản lý loại nhà trọ </a>
                            </div>
                            <div class="w-90"><a class="btn btn_menu" href="/admin/ql_phongtro"> Phòng trọ </a></div>
                            <div class="w-90"><a class="btn btn_menu" href="/admin/ql_dangbai">Quản lý bài đăng</a>
                            </div>
                            <div class="w-90"><a class="btn btn_menu" href="/admin/ql_user">Quản lý người dùng</a></div>
                            <div class="w-90"><a class="btn btn_menu" href="/admin/ql_danhgia">Quản lý đánh giá</a></div>
                            <div class="w-90"><a class="btn btn_menu" href="/admin/thong-ke">Thống kê</a></div>
                        </ul>

                        <hr>

                    </div>
                </div>
                <div class="col-sm-9" style="margin: 20px auto">

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
<!-- Tải jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<!-- Tải DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    // Lấy tất cả các phần tử toggle mật khẩu
    const togglePasswordToggles = document.querySelectorAll('.toggle-password-toggle');

    togglePasswordToggles.forEach(toggle => {
        toggle.addEventListener('click', function () {
            // Tìm input kế bên của toggle
            const passwordField = this.previousElementSibling;
            const eyeIcon = this.querySelector('i');

            // Kiểm tra trạng thái hiện tại của input
            if (passwordField.type === 'password') {
                // Hiển thị mật khẩu
                passwordField.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                // Ẩn mật khẩu
                passwordField.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    });
</script>
<script>
    function delete_dt(url, Id) {
    // Hiển thị hộp thoại xác nhận với SweetAlert
    swal({
        title: "Bạn có thật sự muốn xóa?",
        text: "Thao tác này không thể hoàn tác!",
        icon: "warning",
        buttons: ["Hủy", "Xóa"],
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            // Gửi yêu cầu AJAX để xóa
            $.ajax({
                url: url, // Đường dẫn API
                type: 'DELETE', // Phương thức xóa
                data: {
                    _token: '{{ csrf_token() }}', // Token CSRF để bảo mật
                },
                success: function (response) {
                    if (response.success) {
                        // Xóa hàng HTML khỏi giao diện
                        $(`#user-row-${Id}`).fadeOut('slow', function () {
                            $(this).remove();
                        });

                        // Hiển thị thông báo thành công
                        swal("Thành công", response.success, "success");
                    }
                },
                error: function (xhr) {
                    // Hiển thị lỗi từ server
                    swal("Lỗi", xhr.responseJSON?.error || "Đã xảy ra lỗi. Không thể xóa.", "error");
                }
            });
        }
    });
}
</script>
</html>
