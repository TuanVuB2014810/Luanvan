@extends('layouts.app')

@section('content')
<div class="my-5 container-fluid row">
    <div class="col-sm-1">

    </div>
    <section class="col-sm-10 row">
        <div class="col-12 row">
            <div class="card div_avt  col-3 mt-5" >
                
                    <label for="imageInput">
                      <img id="uploadedImage " class="avt_img rounded-circle" src="{{ asset('images/'.$user->avt) }}" alt="Uploaded Image">
                    </label>
                 
               
                <div class="card-body">
                    <h5 class="card-title text-center"><b>{{ $user->name }}</b></h5>
                </div>
                <div class="row px-5">
                    <p class="col-sm-12">Địa Chỉ: {{ $user->city }}</p>
                    <p class="col-sm-12">Liên hệ:  {{ $user->phone }}</p>
                    <p class="col-sm-12">Đã tham gia:{{ $time }} </p>
                </div>
                
            </div >
            <div class="col-9 bg-white row d-flex justify-content-start  mt-5 ">
               <h3 class=" col-12 pt-2 text-center"> Các bài đăng </h3>
               @if(!empty((array) json_decode($posts)))
                    @foreach ($posts as $p)
                    <div class="col-sm-6 col-lg-4 cart-status">
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
                    
                @endif
            </div>

        </div>
       

    </section>
      <div class="col-sm-1">

    </div>

</div>

@endsection
