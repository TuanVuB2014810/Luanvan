@extends('layouts.app')

@section('content')
<section class="section_qlbaidang pt-5">
    <div class="container">
        <a class="btn btn-outline-success" href="/ql_dangbai/create">Đăng bài mới</a>
        <a class="btn btn-success" href="/ql_dangbai/show">Hiển thị</a>
        <a class="btn btn-danger" href="/ql_dangbai/refused">Bị từ chối</a>
        <a class="btn btn-secondary" href="/ql_dangbai/in-review">Chờ duyệt</a>
        <a class="btn btn-warning" href="/ql_dangbai/hidden">Ẩn</a>
        <section class="row bg-white text-dark mt-2">
            @if($msg_status)
            <h5 class="col-12 text-center my-2"><strong>{{ $msg_status }}</strong></h5>
            @endif
            <div class="col-lg-2"></div>
            <div class="col-lg-8 col-12 row d-flex justify-content-start">
               
                @foreach ($posts as $p)

                <div class="col-sm-6 col-lg-4 cart-status">
                    <a class="btn btn-light sp_a" href="/chitiet_baidang/{{ $p->maphong }}">
                        <img class="card-img-top-status  img-fluid" src="{{ asset('images/'.$p->image) }}" />
                    </a>
                    <div class="card-body card-body-status">
                       <p class="card-title">{{ $p->content }}</p>
                       @if($p->errMess!=null)
                        <div class="mt-1">Lý do:<b>  {{ $p->errMess }}</b></div> 
                        @else
                            <p class="card-text text-dt">{{ $p->dientich }} m²</p>
                            <h6 class="card-subtitle mb-2  text-price">{{ $p->gia }}</h6>
                        @endif
                    </div>
                   
                </div>
                

                @endforeach
            </div>
            <div class="col-lg-2"></div>
        </section>
    </div>

</section>

@endsection