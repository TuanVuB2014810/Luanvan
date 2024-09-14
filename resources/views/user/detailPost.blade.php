@extends('layouts.app')

@section('content')
{{-- @php
   use App\helpers; 
@endphp --}}
{{-- <img src="{{ asset('storage/anh1.webp') }}" alt=""> --}}
<div class="container-fluid row">

    <h4 class="mt-5 py-2 px-2 col-12 text-center title">Cho thuê nhà trọ, phòng trọ đầy đủ tiện nghi</h4>
    <div class="col-sm-2"></div>
    <section class="section_qlbaidang  col-sm-6">
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
                        onmouseover="showImage('{{ asset('images/'.$image->image) }}')" onmouseout="resetImage()">
                        <img class="w-8 h-10" src="{{ asset('images/'.$image->image) }}" width="120" height="120"
                            alt="Thumbnail">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-4 px-2 bg-white text-dark">
            <h6><strong>{{ $post->content }}</strong><br></h6>
            <p><b class="price">{{ $post->gia }}/tháng</b> - <b>{{ $post->dientich }} m²</b></p>
            <p><i class="fa-solid fa-location-dot fa-lg" style="color: #c5122a;"></i> {{ $post->dia_chi }},
                {{ $post->huyen }}, {{ $post->tinh }}</p>

            <div class="d-flex justify-content-between align-items-center">
                <p> <i class="fa-solid fa-clock fa-lg" style="color: #c5122a;"></i> Đăng {{ $time }}</p>
                <div class="d-flex d-flex align-items-center">
                    <a href="/them-yeu-thich/{{ $post->maphong }}" class="text-danger  mx-2 icon-heart">
                        @if(Auth::check() && $listwish)

                        @if($listwish->yeuthich == 0)
                        <i class="fa-regular fa-heart px-1"></i>
                        @else
                        <i class="fa-solid fa-heart px-1"></i>
                        @endif
                        @else
                        <i class="fa-regular fa-heart px-1"></i>
                        @endif

                    </a>
                    <p class="mb-0 ml-2"> Yêu thích</p>
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
            {{-- <span class="success">{{ $msg }}</span> --}}
            <script>
                alert("{{ $msg }}");
            </script>
            @endif
            <div class="total_evalute">
                <h4 class="p-3 "><b>Đánh giá {{ $post->content }}</b></>
                    <div class="rating-stars-show pt-2" id="total_start">
                        <span class="px-2 text">{{ $total_rating->average_rating }}</span>
                        <span class="fa fa-star total_show py-1"></span>
                        <span class="fa fa-star total_show py-1"></span>
                        <span class="fa fa-star total_show py-1"></span>
                        <span class="fa fa-star total_show py-1"></span>
                        <span class="fa fa-star total_show py-1"></span>
                        <span class="messeva"> {{ $total_rating->total_ratings }} đánh giá</span>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const ratingStarsShow = document.getElementById('total_start');
                            const starsShow = ratingStarsShow.querySelectorAll('.total_show');
                            const ratingValue = parseFloat("{{ $total_rating->average_rating }}");
                            showStars(ratingValue);

                            function showStars(rating) {
                                const fullStars = Math.floor(rating); // Số nguyên của xếp hạng
                                const halfStar = (rating % 1 !== 0); // Kiểm tra xem có nửa sao không
                                starsShow.forEach((star, i) => {
                                    if (i < fullStars) {
                                        star.classList.add('active');
                                        star.style.color = 'orange';
                                    } else if (halfStar && i === fullStars) {
                                        star.classList.add('active');
                                        star.style.color = 'orange';
                                        star.classList.add(
                                            'fa-star-half-alt'); // Thêm class cho nửa sao
                                    } else {
                                        star.style.color = '#dddddd';
                                    }
                                });
                            }
                        });
                    </script>

            </div>
            <h3 class="text-center">Đánh Giá</h3>
            <form action="/danhgia-phongtro/{{ $post->phongtro_id }}" method="POST" class="">
                @csrf
                @method('POST')

                <div class="rating-stars text-center" id="ratingStars">
                    <input type="hidden" name="star" id="star1">
                    <span class="fa fa-star rating_star" data-index="1"></span>

                    <input type="hidden" name="star" id="star2">
                    <span class="fa fa-star rating_star" data-index="2"></span>

                    <input type="hidden" name="star" id="star3">
                    <span class="fa fa-star rating_star" data-index="3"></span>

                    <input type="hidden" name="star" id="star4">
                    <span class="fa fa-star rating_star" data-index="4"></span>

                    <input type="hidden" name="star" id="star5">
                    <span class="fa fa-star rating_star" data-index="5"></span>
                </div>

                <div class="form-group text-center">
                    <textarea id="comment" class="form-control danhgia_textarea" name="comment"
                        placeholder="Viết đánh giá của bạn..."></textarea>
                </div>

                <div class="form-group text-center d-flex justify-content-center">
                    <input type="submit" name="submit" class="btn btn-primary danhgia " value="Đánh giá"
                        id="submitReview">
                </div>
            </form>

        </div>
        <section class="bg-white text-dark mb-3 section_evaluate px-3">

            <h4 class="text-center pt-2"><strong>Các đánh giá về {{ $post->tenloai }}</strong></h4>
         
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
                                star.style.color = (i < rating) ? 'orange' :
                                    '#dddddd';
                            });
                        }
                    });
                </script>
                @endforeach
            @else 
                <div class="text-center"> Chưa có đánh giá nào!!!</div>
            @endif
           

        </section>

        </table>
    </section>
    <section class="col-sm-3">
        <div class="mt-1 px-2 bg-white text-dark row">
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
</script>

@endsection