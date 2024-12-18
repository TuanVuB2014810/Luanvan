@extends('layouts.app')

@section('content')
{{-- @php
   use App\helpers; 
@endphp --}}
{{-- <img src="{{ asset('storage/anh1.webp') }}" alt=""> --}}
<div class="container-fluid row">
    <div class="col-sm-2"></div>
    <section class="section_qlbaidang  col-sm-6">
    <h4 class="mt-5 py-2 px-2 col-12 text-center title">Cho thuê nhà trọ, phòng trọ đầy đủ tiện nghi</h4>
        <div class="bg-white text-dark mt-1 px-2 image-container" id="mainImageContainer">
            <!-- Khung hình chính -->
            <img class="rounded mx-auto d-block img_chinh" src="{{ asset('images/'.$post->image) }}" alt="Main Image"
                id="mainImage">
        </div>
        <div class="row mt-3 text-dark mt-1 px-2">
            <div class="slider-container col-12">
                <div class="slick-carousel">
                    @foreach($allimage as $image)
                    <div class="rounded mx-auto d-block thumbnail-container px-2"
                    onmouseover="showImage('{{ asset('images/' . trim($image->image)) }}')" onmouseout="resetImage()">
                    <img class="w-8 h-10" src="{{ asset('images/' . trim($image->image)) }}" width="120" height="120"
                        alt="Thumbnail">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-4 px-2 bg-white text-dark">
            <h6><strong>{{ $post->content }}</strong><br></h6>
            <p><b class="price">{{ $post->gia }}/tháng</b> - <b>{{ $post->dientich }} m²</b></p>
            <p><i class="fa-solid fa-location-dot fa-lg" style="color: #c5122a;"></i> <a class="url" href="{{ $googleMapsUrl }}" target="_blank">{{ $post->dia_chi }},
            {{ $post->huyen }}, {{ $post->tinh }}</a></p>
            <!-- map -->

            <div class="d-flex justify-content-between align-items-center">
            <p> <i class="fa-solid fa-clock fa-lg" style="color: #c5122a;"></i> Đăng {{ $time }}</p>
            <div class="d-flex d-flex align-items-center">
            <a href="javascript:void(0);" data-id="{{ $post->maphong }}" class="text-danger mx-2 icon-heart toggle-favorite">
                @if(Auth::check() && $listwish)
                    @if($listwish->yeuthich == 1)
                        <i class="fa-solid fa-heart px-1"></i> 
                    @else
                        <i class="fa-regular fa-heart px-1"></i>
                    @endif
                @else
                    <i class="fa-regular fa-heart px-1"></i>
                @endif
            </a>
                <p class="mb-0 ml-2">Yêu thích</p>
            </div>
            </div>
        </div>

        <div class="mt-1 px-4 bg-white text-dark">
            <h5 class="pt-2 "> <strong>Đặc điểm {{ $post->tenloai }} cho thuê</strong></h5>
            <div class="row px-5 ">
                <p class="col-sm-6">Diện tích: {{ $post->dientich }} m²</p>
                <p class="col-sm-6">Số phòng: {{ $post->sophong }}</p>
                <p class="col-sm-6">Đường xá</p>
                <p class="col-sm-6">Loại hình: {{ $post->tenloai }}</p>
                <p class="col-sm-6">Giá điện: {{ $post->gia_dien }}</p>
                <p class="col-sm-6">Giá nước: {{ $post->gia_nuoc }}</p>

            </div>

        </div>
        <div class="mt-1 px-2 bg-white text-dark px-4">
            <h5 class="pt-2"><strong>Mô tả chi tiết</strong></h5>
            <p>{!! $post->mota !!}</p>
            <p><strong>Liên hệ: </strong> {{ $post->phone}}</p>

        </div>

        <div class="rating-container mt-1 px-2 bg-white text-dark my-2 py-1">
        @if($msg = Session::get('msge'))
            <script>
               swal({
                title: "Thông báo", // Tiêu đề của thông báo
                text: "{{ $msg }}", // Nội dung thông báo lấy từ biến PHP
                icon: "success", // Biểu tượng thành công
                buttons: {
                    confirm: {
                        text: "Đồng ý",
                        value: true,
                        visible: true,
                        className: "btn btn-success",
                        closeModal: true
                    }
                }
            });
            </script>
        @endif
        <div class="row">
        <h4 class="p-3"><b>Đánh giá {{ $post->content }}</b></h4>
            <div class="col-lg-4">
                <div class="total_evalute" id="total_start">
                    <div class="px-2 text">{{ round($total_rating->average_rating, 1) }}</div>
                    <div class="rating-stars-show pt-2">
                        <span class="fa fa-star total_show py-1"></span>
                        <span class="fa fa-star total_show py-1"></span>
                        <span class="fa fa-star total_show py-1"></span>
                        <span class="fa fa-star total_show py-1"></span>
                        <span class="fa fa-star total_show py-1"></span>
                        
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const ratingStarsShow = document.getElementById('total_start');
                            const starsShow = ratingStarsShow.querySelectorAll('.total_show');
                            const ratingValue = parseFloat("{{ $total_rating->average_rating }}"); // Lấy giá trị rating từ PHP

                            showStars(ratingValue, starsShow); // Gọi hàm hiển thị sao

                            function showStars(rating, stars) {
                                const fullStars = Math.floor(rating); // Số nguyên của rating (số sao đầy)
                                const halfStar = (rating % 1 !== 0); // Kiểm tra nếu có nửa sao

                                stars.forEach((star, i) => {
                                    if (i < fullStars) {
                                        // Nếu sao là đầy
                                        star.classList.add('active');
                                        star.style.color = 'orange';
                                    } else if (halfStar && i === fullStars) {
                                        // Nếu có nửa sao
                                        star.classList.add('active');
                                        star.style.color = 'orange';
                                        star.classList.add('fa-star-half-alt'); // Thêm class nửa sao
                                    } else {
                                        // Những sao còn lại không được kích hoạt
                                        star.style.color = '#dddddd';
                                    }
                                });
                            }
                        });
                    </script>


                </div>
            </div>
            <div class="col-lg-8">
                <canvas id="playStoreRatingChart" data-maphong="{{$post->maphong}}"></canvas>
            </div>
            <div class="col-lg-1"></div>
        </div>
            <hr class="mt-5">
            <h3 class="text-center">Đánh Giá</h3>
            <form action="/danhgia-phongtro/{{ $post->phongtro_id }}" method="POST" id="ratingForm">
                @csrf
                @method('POST')

                <div class="rating-stars text-center" id="ratingStars">
                    <input type="hidden" name="star" id="star">
                    <span class="fa fa-star rating_star" data-index="1"></span>
                    <span class="fa fa-star rating_star" data-index="2"></span>
                    <span class="fa fa-star rating_star" data-index="3"></span>
                    <span class="fa fa-star rating_star" data-index="4"></span>
                    <span class="fa fa-star rating_star" data-index="5"></span>
                </div>

                <div class="form-group text-center">
                    <textarea id="comment" class="form-control danhgia_textarea" name="comment"
                        placeholder="Viết đánh giá của bạn..."></textarea>
                </div>

                <div class="form-group text-center d-flex justify-content-center">
                    <input type="submit" name="submit" class="btn btn-primary danhgia" value="Đánh giá" id="submitReview">
                </div>
            </form>


        </div>
        <section class="bg-white text-dark mb-3 section_evaluate px-3">

            <h4 class="text-center pt-2"><strong>Các đánh giá về {{ $post->tenloai }}</strong></h4>
         
            <div id="reviews">
                <!-- Các đánh giá hiện có sẽ được liệt kê tại đây -->
                @if(isset($evaluates))
                    @foreach($evaluates as $index => $evaluate)
                    <div>
                        <div href="" class="col-6 avatar-container li-avt ">
                            <div class="rounded-avatar">
                                @if(isset($evaluate->avt))
                                <img src="{{ asset('images/'.$evaluate->avt) }}" alt="Avatar">
                                @else
                                <img src="{{ asset('images/nen.png') }}" alt="Avatar">
                                @endif
                            </div>
                            <p class="col-6 mt-3"> <b>{{ $evaluate->name }}</b></p>
                        </div>
                        <div class="rating-stars-show" id="ratingStars_show_{{ $index }}">
                            <span class="fa fa-star show"></span>
                            <span class="fa fa-star show"></span>
                            <span class="fa fa-star show"></span>
                            <span class="fa fa-star show"></span>
                            <span class="fa fa-star show"></span>
                        </div>
                        <p>{{ $evaluate->comment }}</p>
                    </div>
                    <hr>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const ratingStarsShow = document.getElementById('ratingStars_show_{{ $index }}');
                            const starsShow = ratingStarsShow.querySelectorAll('.show');
                            const ratingValue = parseInt("{{ $evaluate->rating }}");
                            showStars(ratingValue);

                            function showStars(rating) {
                                starsShow.forEach((star, i) => {
                                    star.classList.toggle('active', i < rating);
                                    star.style.color = (i < rating) ? 'orange' : '#dddddd';
                                });
                            }
                        });
                    </script>
                    @endforeach
                @else 
                    <div class="text-center"> Chưa có đánh giá nào!!!</div>
                @endif
            </div>

           

        </section>

        </table>
    </section>
    <section class="col-sm-3">
        <div class="px-2 bg-white text-dark row" style="margin-top: 100px">
            <h5 class="col-12 mb-2 "><strong> Người cho thuê </strong></h5>
            <div href="" class="col-6 avatar-container li-avt ">
                <div class="rounded-avatar">
                    @if(isset($avatarUrl))
                    <img src="{{ asset('images/'.$post->avt) }}" alt="Avatar">
                    @else
                    <img src="{{ asset('images/nen.png') }}" alt="Avatar">
                    @endif
                </div>
                <p class="col-6 mt-3">{{ $post->tennguoi }}</p>
            </div>

            <a class="btn btn-outline-danger col-6 mb-3 mt-2 btn_profile_cum"
                href="/user/detailUser/{{ $post->user_id }}">Xem trang > </a>
            <p class="col-12"> Tỉnh thành: {{ $post->city }}</p>
            <p class="col-12"> Liên hệ: {{ $post->phone }}</p>
            <p class="col-12"> Tham gia: {{ $post->ngaytao }}</p>
            {{-- <a class="col-12 btn btn-success " href="/chat/{{ $post->user_id   }}">Chat với người đăng bài</a> --}}

        </div>

    </section>
    <div class="col-sm-1"></div>

    <div class="col-sm-2"></div>
    <section class="col-sm-8 bg-white text-dark">
        <h5 class="my-3 px-2"><strong> Các bài đăng khác của {{ $post->tennguoi }}</strong></h5>

        <div class="row d-flex justify-content-start mx-1">

            @foreach ($posts as $p)

            <div class="col-lg-3 cart-status">
                <a class="btn btn-light sp_a" href="/chitiet_baidang/{{ $p->maphong }}">
                    <img class="card-img-top-status  img-fluid" src="{{ asset('images/'.$p->image) }}" />
                </a>
                <div class="card-body card-body-status">
                    <p class="card-title">{{ $p->content }}</p>
                    <p class="card-text text-dt">{{ $p->dientich }} m²</p>
                    <h6 class="card-subtitle mb-2  text-price">{{ $p->gia }}</h6>
                </div>
            </div>

            @endforeach
        </div>

    </section>

    <div class="col-sm-2"></div>
    <div class="col-sm-2"></div>
    <section class="col-sm-8 bg-white text-dark mt-2">
        <h5 class="my-3 px-2"><strong> Mô giới cùng khu vực </strong></h5>
        <div class="row d-flex justify-content-start mx-1">
            @foreach ($userList as $p)

            <div class="col-sm-3 col-lg-3 cart-status">
                <a class="btn btn-light sp_a" href="/user/detailUser/{{ $p->user_id }}">
                    <img class="card-img-top-status img-fluid" src="{{ asset('images/'.$p->avt) }}" />
                </a>
                <div class="card-body card-body-status">
                    <p class="card-title text-center"><b>{{ $p->name }}</b></p>
                    <p class="card-text text-dt">Tỉnh thành:<b> {{ $p->city }}</b></p>
                    <a class="btn btn-outline-danger" href="/user/detailUser/{{ $p->user_id }}"> Liên hệ</a>
                </div>
            </div>

            @endforeach
        </div>
    </section>

    <div class="col-sm-2"></div>
    <div class="col-sm-2"></div>
    <section class="col-sm-8 bg-white text-dark mt-2">
        <h5 class="my-3 px-2"> Tin đăng cùng khu vực: <strong> {{ $post->huyen }}</strong></h5>
        <div class="row d-flex justify-content-start mx-1">
            @foreach ($postAddress as $p)

            <div class=" col-lg-3 cart-status">
                <a class="btn btn-light sp_a" href="/chitiet_baidang/{{ $p->maphong }}">
                    <img class="card-img-top-status  img-fluid" src="{{ asset('images/'.$p->image) }}" />
                </a>
                <div class="card-body card-body-status body_cart_post">
                    <p class="card-title">{{ $p->content }}</p>
                    <div class="card-details">
                        <div class="card-text text-dt">{{ $p->dientich }} m²</div>
                        <div class="card-subtitle text-price">{{ $p->gia }}</div>
                    </div>
                </div>
            </div>

            @endforeach
        </div>
    </section>

    <div class="col-sm-2"></div>

</div>



<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

<script>
    function showImage(imageSrc) {
        document.getElementById('mainImage').src = imageSrc;
    }

    function resetImage() {
        document.getElementById('mainImage').src = "{{ asset('images/'.$post->image) }}";
    }
</script>
<script>
    $('.slick-carousel').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 5000,
        dots: true,
        infinite: false,
        responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.rating_star');
        const hiddenInputs = document.querySelectorAll('input[name="star"]');
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const index = Number(star.dataset.index);
                // Đặt giá trị cho các thẻ input ẩn
                hiddenInputs.forEach(hiddenInput => {
                    hiddenInput.value = index;
                });
                // Gọi hàm để tô màu sao
                updateStars(index);
            });
        });

        function updateStars(index) {
            stars.forEach((star, i) => {
                star.classList.toggle('active', i < index);
            });
        }
    });
    $(document).ready(function () {
    let selectedStar = 0;

    // Xử lý khi người dùng chọn sao
    $('.rating_star').on('click', function () {
        selectedStar = $(this).data('index');
        $('#star').val(selectedStar);  // Gán giá trị sao vào input ẩn

        // Làm nổi bật các sao đến mức sao được chọn
        $('.rating_star').removeClass('checked');
        for (let i = 1; i <= selectedStar; i++) {
            $(`.rating_star[data-index=${i}]`).addClass('checked');
        }
    });

    // Gửi form qua AJAX
    $('#ratingForm').on('submit', function (e) {
        e.preventDefault();

        const formData = {
            _token: $('input[name=_token]').val(),
            star: selectedStar,
            comment: $('#comment').val(),
        };

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function (response) {
                if (response.status === 'success') {
                    swal({
                        title: "Thành công", // Tiêu đề của thông báo
                        text: response.message, // Nội dung thông báo lấy từ response.message
                        icon: "success", // Biểu tượng thành công
                        buttons: {
                            confirm: {
                                text: "Đồng ý",
                                value: true,
                                visible: true,
                                className: "btn btn-success",
                                closeModal: true
                            }
                        }
                    });
                    $('#ratingForm')[0].reset(); // Reset lại form
                    $('.rating_star').removeClass('checked'); // Bỏ nổi bật các sao

                    // Thêm đánh giá mới vào đầu danh sách các đánh giá hiện có
                    let newReview = `
                        <div>
                            <div href="" class="col-6 avatar-container li-avt ">
                                <div class="rounded-avatar">
                                    <img src="/images/nen.png" alt="Avatar"> <!-- Giả sử người dùng không có avatar -->
                                </div>
                                <p class="col-6 mt-3"> <b>Bạn</b></p>
                            </div>
                            <div class="rating-stars-show" id="newRatingStars">
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>
                            <p>${formData.comment}</p>
                        </div>
                        <hr>
                    `;

                    $('#reviews').prepend(newReview); // Thêm đánh giá mới

                    // Hiển thị số sao cho đánh giá mới
                    const starsShow = document.querySelectorAll('#newRatingStars .fa-star');
                    showStars(selectedStar, starsShow);

                    // Cập nhật số sao trung bình và tổng số đánh giá sau khi đánh giá thành công
                    updateTotalRating();
                } else if (response.status === 'exists') {
                   swal({
                        title: "Cảnh báo", // Tiêu đề Cảnh báo
                        text: response.message, // Nội dung thông báo lấy từ response.message
                        icon: "warning", // Biểu tượng cảnh báo
                        buttons: {
                            confirm: {
                                text: "Đồng ý",
                                value: true,
                                visible: true,
                                className: "btn btn-warning",
                                closeModal: true
                            }
                        }
                    });
                } else if (response.status === 'unauthenticated') {
                   swal({
                    title: "Lỗi", // Tiêu đề lỗi
                    text: response.message, // Nội dung thông báo lấy từ response.message
                    icon: "warning", // Biểu tượng lỗi
                    buttons: {
                        confirm: {
                            text: "Đồng ý",
                            value: true,
                            visible: true,
                            className: "btn btn-warning",
                            closeModal: true
                        }
                    }
                });
                    window.location.href = '/login'; // Điều hướng tới trang đăng nhập
                }
            },
            error: function (error) {
                swal({
                    title: "Lỗi", // Tiêu đề lỗi
                    text: response.message, // Nội dung thông báo lấy từ response.message
                    icon: "error", // Biểu tượng lỗi
                    buttons: {
                        confirm: {
                            text: "Đồng ý",
                            value: true,
                            visible: true,
                            className: "btn btn-danger",
                            closeModal: true
                        }
                    }
                });
            }
        });
    });

    // Hàm hiển thị sao (bao gồm cả nửa sao)
    function showStars(rating, stars) {
        const fullStars = Math.floor(rating); // Số nguyên của rating
        const halfStar = (rating % 1 !== 0); // Kiểm tra nếu có nửa sao

        stars.forEach((star, i) => {
            star.classList.remove('fa-star', 'fa-star-half-alt', 'active'); // Xóa các lớp cũ

            if (i < fullStars) {
                star.classList.add('fa-star');
                star.classList.add('active');
                star.style.color = 'orange';
            } else if (halfStar && i === fullStars) {
                star.classList.add('fa-star-half-alt'); // Thêm lớp nửa sao
                star.style.color = 'orange';
            } else {
                star.classList.add('fa-star');
                star.style.color = '#dddddd';
            }
        });
    }

    // Hàm cập nhật tổng số sao và số lượng đánh giá
    function updateTotalRating() {
        const phongtro_id = '{{ $post->phongtro_id }}'; // Lấy ID của bài đăng

        $.ajax({
            url: `/get-total-rating/${phongtro_id}`,
            type: 'GET',
            success: function (data) {
                if (data.average_rating !== undefined && data.total_ratings !== undefined) {
                    $('#total_start .text').text(data.average_rating.toFixed(1));
                    $('#total_start .messeva').text(`${data.total_ratings} đánh giá`);

                    // Cập nhật hiển thị các sao
                    const starsShow = document.querySelectorAll('#total_start .fa-star');
                    showStars(data.average_rating, starsShow); // Gọi hàm showStars với giá trị mới
                }
            },
            error: function (error) {
                swal('Lỗi khi cập nhật tổng số đánh giá.');
            }
        });
    }
});



</script>
<script>
    $(document).ready(function() {
        $('.toggle-favorite').on('click', function(e) {
            e.preventDefault();
            var postId = $(this).data('id');
            var heartIcon = $(this).find('i');

            $.ajax({
                url: "{{ route('add.favorite', ':id') }}".replace(':id', postId),
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status === 'success') {
                        if (response.yeuthich == 1) {
                            heartIcon.removeClass('fa-regular').addClass('fa-solid');
                        } else {
                            heartIcon.removeClass('fa-solid').addClass('fa-regular');
                        }
                    }
                }
            });
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Lấy mã phòng từ data-maphong của thẻ canvas
    const canvas = document.getElementById('playStoreRatingChart');
    const ctx = canvas.getContext('2d');
    const maPhong = canvas.dataset.maphong; // Lấy giá trị 'data-maphong'

    let chart; // Biến để lưu đối tượng biểu đồ

    // Hàm để gọi API và cập nhật dữ liệu cho biểu đồ
    function fetchAndUpdateChart() {
        // Gọi API với mã phòng trọ
        fetch(`/rating-data/${maPhong}`)
            .then(response => response.json())
            .then(data => {
                console.log(data); // Kiểm tra dữ liệu trả về từ API

                // Chuẩn bị dữ liệu cho biểu đồ
                const chartData = {
                    labels: ['5', '4', '3', '2', '1'],
                    datasets: [{
                        label: 'Số lượng đánh giá',
                        data: [
                            data.five_star || 0,
                            data.four_star || 0,
                            data.three_star || 0,
                            data.two_star || 0,
                            data.one_star || 0
                        ],
                        backgroundColor: 'orange',
                        borderColor: 'orange',
                        borderWidth: 1,
                        borderRadius: {
                            topLeft: 10,
                            bottomLeft: 10,
                            topRight: 10,
                            bottomRight: 10
                        },
                        borderSkipped: false,
                        barThickness: 12,
                        maxBarThickness: 12
                    }]
                };

                // Nếu biểu đồ đã tồn tại, cập nhật lại dữ liệu và làm mới
                if (chart) {
                    chart.data = chartData;
                    chart.update(); // Cập nhật lại biểu đồ
                } else {
                    // Cấu hình biểu đồ
                    const chartOptions = {
                        indexAxis: 'y',
                        layout: {
                            padding: {
                                top: 10,
                                bottom: 10,
                                left: 0,
                                right: 30
                            }
                        },
                        scales: {
                            x: {
                                display: false,
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                grid: {
                                    display: false
                                },
                                border: {
                                    display: false
                                },
                                ticks: {
                                    display: true,
                                    color: '#000',
                                    font: {
                                        size: 14,
                                        weight: 'bold'
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: true
                            },
                            datalabels: {
                                anchor: 'end',
                                align: 'right',
                                color: '#000',
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                },
                                formatter: (value) => `${value}`,
                                padding: {
                                    right: 5
                                }
                            }
                        }
                    };
                    Chart.register(ChartDataLabels);
                    // Khởi tạo biểu đồ nếu chưa có
                    chart = new Chart(ctx, {
                        type: 'bar',
                        data: chartData,
                        options: chartOptions
                    });
                }
            })
            .catch(error => console.error('API Error:', error));
    }

    // Gọi hàm lần đầu để hiển thị biểu đồ
    fetchAndUpdateChart();

    // Nếu bạn muốn cập nhật tự động sau một khoảng thời gian (ví dụ 5 giây)
    setInterval(fetchAndUpdateChart, 5000); // Cập nhật mỗi 5 giây
});
</script>



@endsection