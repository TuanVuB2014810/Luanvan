<html lang="vn">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nouislider@14.6.4/distribute/nouislider.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
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
                    <ul class="navbar-nav me-4 mb-2 mb-lg-0 row col-lg-4 navbar_ul_search">
                        <li class="nav-item active col-lg-3 py-3 li_a trang_chu">
                            <a href="{{ route('index') }}" class="nav-link a_icon text-center"><i class="fa fa-house mx-1"></i>
                                Trang chủ</a>
                        </li>
                        <li class="nav-item col-lg-4 py-3 about ">
                            <a href="/about" class="nav-link a_icon text-center ">
                                <i class="fa fa-book mx-1"></i>Giới Thiệu
                            </a>
                        </li>
                    </ul>
                    <form action="/tim-kiem" class="col-lg-3 mt-3 d-flex justify-content-between" method="GET">
                            @csrf
                            <div class="input-group search_div w-100 m-2">
                                <input type="search" id="inputField1" class="form-control" name="query" placeholder="Tìm kiếm nhà trọ" 
                                    aria-label="Tìm kiếm" aria-describedby="button-addon2" autocomplete="off">
                                <input class="btn btn-outline-danger" name="timkiem_sp" type="submit" value="Tìm" id="button-addon2">
                            </div>
                            <div id="suggestion-box" class="dropdown-menu" style="display: none;"></div>
                        </form>
                    <ul class="d-flex navbar-nav me-auto mb-2 mb-lg-0 row col-lg-5 nav_manager_post">

                        <li class="nav-item col-lg-5 py-3  baidang">

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
<div id="chatbot-bubble">
    <i class="far fa-comment-dots"></i>
</div>

<!-- Cửa sổ chat -->
<div id="chat-window" style="display: none;">
    <div id="chat-header">
        Chatbot
        <span id="close-chat" style="cursor: pointer; float: right;">&times;</span>
    </div>
    <button onclick="clearChatHistory()">Xóa lịch sử trò chuyện</button>
    <div id="chat-content"></div>
    <div id="chat-input">
        <input type="text" id="userMessage" placeholder="Nhập tin nhắn..." />
        <button id="sendMessage"><i class="far fa-paper-plane"></i></button>
    </div>
</div>

<script>
    // Chức năng để hiển thị hoặc ẩn cửa sổ chat
    document.getElementById("chatbot-bubble").addEventListener("click", function () {
        var chatWindow = document.getElementById("chat-window");
        chatWindow.style.display = chatWindow.style.display === "none" || chatWindow.style.display === "" ? "flex" : "none";
    });

    // Chức năng đóng cửa sổ chat
    document.getElementById("close-chat").addEventListener("click", function () {
        document.getElementById("chat-window").style.display = "none";
    });

    // Chức năng gửi tin nhắn khi nhấn nút hoặc nhấn Enter
    document.getElementById("sendMessage").addEventListener("click", sendMessage);
    document.getElementById("userMessage").addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            sendMessage();
        }
    });

    function sendMessage() {
        var userMessageInput = document.getElementById("userMessage");
        var messageContent = userMessageInput.value.trim();

        if (messageContent) {
            // Hiển thị tin nhắn người dùng
            displayMessage(messageContent, "user-message");
            saveChatHistory();
            // Gọi API gửi tin nhắn đến server
            fetch('/api/chatbot/send-message', { // Cập nhật đường dẫn
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Thêm CSRF token
                },
                body: JSON.stringify({
                    sender: 'user', // Chỉnh sửa tên thuộc tính cho đúng với controller
                    message: messageContent // Chỉnh sửa tên thuộc tính cho đúng với controller
                })
            })
                .then(response => {
                    if (!response.ok) { // Kiểm tra nếu có lỗi trong phản hồi
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    // Hiển thị tin nhắn phản hồi từ chatbot
                    data.forEach(message => {
                        displayMessage(message.text, "bot-message");
                        saveChatHistory();
                        // Nếu có nút, hiển thị nút
                        if (message.buttons && message.buttons.length > 0) {
                            displayButtons(message.buttons);
                        }
                    });
                })
                .catch(error => console.error('Error:', error));

            // Xóa nội dung input sau khi gửi
            userMessageInput.value = '';
        }
    }

    // Hàm để hiển thị tin nhắn
    function displayMessage(message, messageType) {
    var chatContent = document.getElementById("chat-content");

    var messageElement = document.createElement("div");
    messageElement.classList.add("message", messageType);

    // Sử dụng linkify để chuyển đổi các URL thành liên kết
    messageElement.innerHTML = linkify(message);

    chatContent.appendChild(messageElement);

    // Tự động cuộn xuống dưới cùng
    chatContent.scrollTop = chatContent.scrollHeight;
}

// Hàm linkify để chuyển đổi URL trong chuỗi thành liên kết HTML
function linkify(text) {
    const urlPattern = /(https?:\/\/[^\s]+)/g;
    // Thay thế URL bằng "tại đây" và thêm liên kết
    return text.replace(urlPattern, '<a href="$1"  class ="cuoi"rel="noopener noreferrer">tại đây</a>');
}




    // Hàm để hiển thị các nút
    function displayButtons(buttons) {
        var chatContent = document.getElementById("chat-content");

        var buttonContainer = document.createElement("div");
        buttonContainer.classList.add("button-container");

        buttons.forEach(function (button) {
            var buttonWrapper = document.createElement("div");

            var buttonElement = document.createElement("button");
            buttonElement.textContent = button.title;
            buttonElement.classList.add("chat-button");

            buttonElement.addEventListener("click", function () {
                sendButtonMessage(button.payload);
            });

            buttonWrapper.appendChild(buttonElement);
            buttonContainer.appendChild(buttonWrapper);
        });

        chatContent.appendChild(buttonContainer);

        // Tự động cuộn xuống dưới cùng
        chatContent.scrollTop = chatContent.scrollHeight;
    }

    // Hàm để gửi tin nhắn khi người dùng nhấn nút
    function sendButtonMessage(payload) {
        displayMessage(payload, "user-message");
        saveChatHistory();
        fetch('/api/chatbot/send-message', { // Cập nhật đường dẫn
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Thêm CSRF token
            },
            body: JSON.stringify({
                sender: 'user', // Chỉnh sửa tên thuộc tính cho đúng với controller
                message: payload // Chỉnh sửa tên thuộc tính cho đúng với controller
            })
        })
            .then(response => response.json())
            .then(data => {
                data.forEach(message => {
                    displayMessage(message.text, "bot-message");
                    saveChatHistory();
                    if (message.buttons && message.buttons.length > 0) {
                        displayButtons(message.buttons);
                    }
                });
            })
            .catch(error => console.error('Error:', error));
    }
    function saveChatHistory() {
    const chatContent = document.getElementById("chat-content").innerHTML;
    localStorage.setItem("chatHistory", chatContent);
}

// Khôi phục cuộc trò chuyện từ localStorage
function loadChatHistory() {
    const savedChat = localStorage.getItem("chatHistory");
    if (savedChat) {
        document.getElementById("chat-content").innerHTML = savedChat;
    }
}
function clearChatHistory() {
    localStorage.removeItem("chatHistory");
    document.getElementById("chat-content").innerHTML = ""; // Xóa nội dung trong phần hiển thị
}
// // Tải lại lịch sử cuộc trò chuyện khi trang được mở lại
window.onload = loadChatHistory;
</script>
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
    // gợi ý tìm kiếm
   $(document).ready(function() {
    $('#inputField1').on('keyup', function() {
        var query = $(this).val();

        // Nếu query không rỗng
        if (query.length > 0) {
            $.ajax({
                url: '{{ route('search.suggestions') }}', 
                method: 'GET',
                data: { query: query },
                success: function(response) {
                    var suggestions = response.suggestions;

                    // Xóa các gợi ý cũ
                    $('#suggestion-box').empty();

                    // Nếu có gợi ý, hiển thị nó
                    if (suggestions.length > 0) {
                        $('#suggestion-box').show();
                        suggestions.forEach(function(suggestion) {
                            $('#suggestion-box').append('<a href="javascript:void(0);" class="dropdown-item suggestion-item">' + suggestion + '</a>');
                        });
                    } else {
                        $('#suggestion-box').hide();
                    }
                }
            });
        } else {
            $('#suggestion-box').hide();
        }
    });

    // Khi người dùng click vào một gợi ý, ô tìm kiếm sẽ tự động điền giá trị và gửi form
    $(document).on('click', '.suggestion-item', function() {
        var suggestion = $(this).text();
        $('#inputField1').val(suggestion); // Điền giá trị vào ô input
        $(this).closest('form').submit(); // Gửi form để tìm kiếm
    });
});


</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
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
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const ratingItems = document.querySelectorAll('.btn');

    ratingItems.forEach(function(item) {
        const ratingStars = item.querySelectorAll('.rating_star');
        const averageRating = parseFloat(item.getAttribute('data-rating'));  // Lấy giá trị trung bình từ data-attribute

        // Hàm để tô màu các sao
        function highlightStars(rating) {
            const fullStars = Math.floor(rating);  // Số sao đầy
            const halfStar = (rating % 1) >= 0.5;  // Kiểm tra sao nửa nếu có

            // Lặp qua từng sao để tô màu
            ratingStars.forEach((star, index) => {
                if (index < fullStars) {
                    // Tô sao đầy màu cam
                    star.style.color = 'orange';
                } else if (index === fullStars && halfStar) {
                    star.classList.remove('fa-star', 'fa-star-o');
                    star.classList.add('fa-star-half-alt');
                    star.style.color = 'orange';   // Có thể thay đổi màu nếu cần
                } else {
                    // Tô sao trống màu xám
                    star.style.color = '#dddddd';
                }
            });
        }

        // Tô màu các sao khi trang được tải
        highlightStars(averageRating);
    });
});

</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const ratingItems = document.querySelectorAll('.rating-stars-show');

    ratingItems.forEach(function(item) {
        const ratingStars = item.querySelectorAll('.rating_star');
        const averageRating = parseFloat(item.getAttribute('data-rating')); // Lấy giá trị trung bình từ data-attribute

        // Hàm để tô màu các sao
        function highlightStars(rating) {
            const fullStars = Math.floor(rating); // Số sao đầy
            const halfStar = (rating % 1) >= 0.5; // Kiểm tra sao nửa nếu có

            // Lặp qua từng sao để tô màu
            ratingStars.forEach((star, index) => {
                if (index < fullStars) {
                    star.style.color = 'orange'; // Tô màu sao đầy
                } else if (index === fullStars && halfStar) {
                    star.classList.remove('fa-star', 'fa-star-o');
                    star.classList.add('fa-star-half-alt'); // Tô sao nửa
                    star.style.color = 'orange';
                } else {
                    star.style.color = '#dddddd'; // Tô màu sao trống
                }
            });
        }

        // Tô màu các sao khi trang được tải
        if (!isNaN(averageRating)) {
            highlightStars(averageRating);
        }
    });
});

function confirmAjaxAction(event, message) {
    event.preventDefault(); // Ngăn hành động mặc định của thẻ <a>
    const url = event.target.closest('a').dataset.url; // Lấy URL từ thuộc tính `data-url`

    Swal.fire({
        title: 'Xác nhận',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            // Gửi AJAX request
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}', // Gửi token bảo mật
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Thành công',
                        text: response.message || 'Cập nhật thành công!',
                        icon: 'success'
                    }).then(() => {
                        location.reload(); // Reload lại trang nếu cần
                    });
                },
                error: function(error) {
                    Swal.fire({
                        title: 'Lỗi',
                        text: error.responseJSON.message || 'Đã xảy ra lỗi. Vui lòng thử lại.',
                        icon: 'error'
                    });
                }
            });
        }
    });
}

</script>

</html>