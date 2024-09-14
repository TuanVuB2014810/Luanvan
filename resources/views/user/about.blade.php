@extends('layouts.app')

@section('content')
<section class="row container-fluid pt-4">
    <div class="col-lg-2 col-2"></div>
    <div class="col-lg-8 col-8 pt-5">
        <div class="col-12 row ">

            <div class="col-md-6">
                <img src="{{ asset('images/about_img.jpeg') }}" alt="Your Image" class="img-fluid">
            </div>
            <div class="col-md-6">
                <h1 class="display-4">Hi nhà trọ! Xin chào </h1>
                <p class="lead"> Hi nhà trọ cảm ơn các bạn đã sử dụng hệ thống của chúng tôi </p>
                <hr class="my-4">
                <p>Nếu có bất kì thắc mắc nào liên hệ ngay với chúng tôi</p>
                <a class="btn btn-primary btn-lg" role="button">Liên Hệ Ngay</a>
            </div>

        </div>
        <div class="col-12 row">
            <h2>Địa chỉ liên hệ</h2>
        </div>

        <div class="col-12 row">
            <iframe height="350"
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d9166.255263870778!2d105.77252722260117!3d10.02852339262641!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0895a51d60719%3A0x9d76b0035f6d53d0!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBD4bqnbiBUaMah!5e0!3m2!1svi!2s!4v1709892706487!5m2!1svi!2s"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

    </div>
    <div class="col-lg-2"></div>
</section>

@endsection