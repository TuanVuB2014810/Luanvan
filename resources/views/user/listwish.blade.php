@extends('layouts.app')

@section('content')

<section class="container-fluid col-sm-8 bg-white text-dark mt-5 pt-5">
    <h4 class="my-3 px-2 text-center mau_khung py-2 bg-danger"> Danh sách yêu thích</strong></h5>
        <div class="row d-flex justify-content-around mx-1">
            @if(!empty((array) json_decode($posts)))
            @foreach ($posts as $p)

            <div class="col-sm-3 col-lg-3 cart-status">
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
            @else
            <div class="text-center">
                <h4 class="mt-5">Chưa có bài đăng nào</h4>
               
            </div>
            @endif

        </div>
</section>

@endsection