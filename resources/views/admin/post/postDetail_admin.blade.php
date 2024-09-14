@extends('layouts.app_admin')

@section('content')

{{-- <img src="{{ asset('storage/anh1.webp') }}" alt=""> --}}
<div class=" row">
  
    <h5 class="my-4 px-2 col-12 text-center bg-primary text-light p-2">Thông tin chi tiết bài đăng của {{ $post->tennguoi }} </h5>
    
    <section class="section_qlbaidang  col-sm-7">
        <div class="bg-white text-dark mt-1 px-2 image-container" id="mainImageContainer">
            <!-- Khung hình chính -->
            <img class="rounded mx-auto d-block img_chinh" src="{{ asset('images/'.$post->image) }}" 
                alt="Main Image" id="mainImage">
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

            <div class="d-flex justify-content-start align-items-center">
                <p> <i class="fa-solid fa-clock fa-lg" style="color: #c5122a;"></i> Đăng {{ $time }}</p>
                

            </div>
        </div>

        <div class="mt-1 px-2 bg-white text-dark">
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
        <div class="mt-1 px-2 bg-white text-dark">
             <h5 class="pt-2"><strong>Mô tả chi tiết</strong></h5>
            <p>{!! $post->mota !!}</p>
            <p><strong>Liên hệ: </strong> {{ $post->phone}}</p>


        </div>
        </table>
    </section>
    <section class="col-sm-3">
        <div class="mt-1 px-2 bg-white text-dark row rounded-lg">
            <h5 class="col-12 mb-2 "><strong> Người cho thuê </strong></h5>
            <p class="col-6">{{ $post->tennguoi }}</p>
              <a class="btn btn-outline-danger col-6 mb-3 mt-2 btn_profile_cum"
                href="/user/detailUser/{{ $post->user_id }}">Xem trang > </a>


            <p class="col-12"> Tỉnh thành: {{ $post->city }}</p>
            <p class="col-12"> Liên hệ:{{ $post->phone }}</p>

        </div>

    </section>
    <div class="col-sm-1"></div>

   

    

</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
@endsection