@extends('layouts.app')

@section('content')

{{-- <img src="{{ asset('storage/anh1.webp') }}" alt=""> --}}
<div class="row">
    <div class="col-sm-2"></div>
    <div class="col-12 text-center">
        <h3 class="my-4 px-2">Cho thuê nhà trọ, phòng trọ đầy đủ tiện nghi</h3>
    </div>

    <div class="col-sm-1"></div>
    <section class="col-sm-2 row bg-white mx-1">
        <div class="col-10">
            <h4 class="text-center pt-2">Tìm kiếm</h4>
            <div>

                <h6 class="mb-3 text-danger"><b class="running-border">Lọc theo giá</b></h6>

                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#searchModal">
                    Nhập giá
                </button>
                <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="searchModalLabel">Tìm kiếm theo giá</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="/tim-kiem-phong-tro-theo-gia" class="mx-auto" method="post"
                                    id="priceForm">
                                    @csrf
                                    @method('POST')

                                    <div id="slider" class="mt-5 mb-2"></div>
                                    <input type="hidden" name="minPrice" id="minPrice" value="">
                                    <input type="hidden" name="maxPrice" id="maxPrice" value="">
                                      <div class="text-center">
                                    <button type="submit" class="mt-2 btn btn-outline-success">Tìm Kiếm</button>
                                      </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                <form action="/tim-kiem-phong-tro-theo-gia" class="mx-auto  py-0 my-0" method="post">
                    @csrf
                    @method('POST')

                    <input type="hidden" name="minPrice" value="0">
                    <input type="hidden" name="maxPrice" value="2000000">
                    <button type="submit" class=" btn btn-light mt-2 py-1 py-1">Dưới 2 triệu</button>
                </form>

                <form action="/tim-kiem-phong-tro-theo-gia" class="mx-auto py-0 my-0" method="post">
                    @csrf
                    @method('POST')

                    <input type="hidden" name="minPrice" value="2000000">
                    <input type="hidden" name="maxPrice" value="3000000">
                    <button type="submit" class=" btn btn-light mt-2 py-1">Giá 2 - 3 triệu</button>
                </form>
                <form action="/tim-kiem-phong-tro-theo-gia" class="mx-auto py-0 my-0" method="post">
                    @csrf
                    @method('POST')

                    <input type="hidden" name="minPrice" value=3000000">
                    <input type="hidden" name="maxPrice" value="5000000">
                    <button type="submit" class=" btn btn-light mt-2 py-1">Giá 3 - 5 triệu</button>
                </form>
                <form action="/tim-kiem-phong-tro-theo-gia" class="mx-auto py-0 my-0" method="post">
                    @csrf
                    @method('POST')

                    <input type="hidden" name="minPrice" value="4000000">
                    <input type="hidden" name="maxPrice" value="10000000">
                    <button type="submit" class=" btn btn-light mt-1 my-1 py-1">Giá 4 - 10 triệu</button>
                </form>
                <form action="/tim-kiem-phong-tro-theo-gia" class="mx-auto py-0 my-0 " method="post">
                    @csrf
                    @method('POST')

                    <input type="hidden" name="minPrice" value="4000000">
                    <input type="hidden" name="maxPrice" value="10000000">
                    <button type="submit" class=" btn btn-light mt-1 my-1 py-1">Giá 10 - 20 triệu</button>
                </form>

            </div>
            <hr class="px-2">

            <div>

                <h6 class="mb-3 text-danger"><b class="running-border">Lọc theo diện tích</b></h6>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#searchModalPrice">
                    Nhập diện tích
                </button>
                <div class="modal fade mt-5 pt-5" id="searchModalPrice" tabindex="-1" role="dialog"
                    aria-labelledby="searchModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="searchModalPriceLabel">Tìm kiếm theo diện tích</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="/tim-kiem-phong-tro-theo-dien-tich" method="post" id="dtForm">
                                    @csrf
                                    @method('POST')

                                    <div id="slider_dt" class="mt-5 mb-2"></div>
                                    <input type="hidden" name="mindt" id="mindt" value="">
                                    <input type="hidden" name="maxdt" id="maxdt" value="">
                                      <div class="text-center">
                                    <button type="submit_dt" class="mt-2 btn btn-outline-success">Tìm Kiếm</button>
                                      </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                <form action="/tim-kiem-phong-tro-theo-dien-tich" class="mx-auto py-0 my-0" method="post">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="mindt" value="0">
                    <input type="hidden" name="maxdt" value="15">
                    <button type="submit_dt" class=" btn btn-light mt-2">0 - 15 m²</button>
                </form>

                <form action="/tim-kiem-phong-tro-theo-dien-tich" class="my-0 py-0 " method="post">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="mindt" value="0">
                    <input type="hidden" name="maxdt" value="15">
                    <button type="submit_dt" class=" btn btn-light mt-1 my-1 py-1"> 15 - 30 m² </button>
                </form>
                <form action="/tim-kiem-phong-tro-theo-dien-tich" class="my-0 py-0 " method="post">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="mindt" value="0">
                    <input type="hidden" name="maxdt" value="15">
                    <button type="submit_dt" class=" btn btn-light mt-1 my-1 py-1"> 30 - 45 m² </button>
                </form>
                <form action="/tim-kiem-phong-tro-theo-dien-tich" class="my-0 py-0 " method="post">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="mindt" value="0">
                    <input type="hidden" name="maxdt" value="15">
                    <button type="submit_dt" class=" btn btn-light mt-1 my-1 py-1"> 45 - 60 m² </button>
                </form>
                <form action="/tim-kiem-phong-tro-theo-dien-tich" class="my-0 py-0 " method="post">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="mindt" value="0">
                    <input type="hidden" name="maxdt" value="15">
                    <button type="submit_dt" class=" btn btn-light mt-1 my-1 py-1 btn-block"> 60 - 75 m² </button>
                </form>
                <form action="/tim-kiem-phong-tro-theo-dien-tich" class="my-0 py-0 " method="post">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="mindt" value="0">
                    <input type="hidden" name="maxdt" value="15">
                    <button type="button" class="btn btn-light mt-1 my-1 py-1 btn-block">75 - 100 m²</button>

                </form>
                <form action="/tim-kiem-phong-tro-theo-dien-tich" class="my-0 py-0 " method="post">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="mindt" value="100">
                    <input type="hidden" name="maxdt" value="100000">
                    <button type="submit_dt" class=" btn btn-light mt-1 my-1 py-1 btn-block"> Trên 100 m² </button>
                </form>

            </div>
            <div class="row p-2">

                <hr class="px-2">
                <a href="" class="btn btn-danger py-1 my-1 find_adress" data-toggle="modal"
                    data-target="#rejectModal">Tìm kiếm địa chỉ</a>
                <div class="modal fade mt-5" id="rejectModal" tabindex="-1" role="dialog"
                    aria-labelledby="rejectModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center" id="searchModalLabel">Nhập địa chỉ</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="/tim-kiem-phong-tro-theo-dia-chi " class="col-10 w-100 mx-2 my-2 "
                                    method="post" id="dcForm">
                                    @csrf
                                    @method('POST')
                                    <select name="calc_shipping_provinces" class="form-control" required="">
                                        <option value="">Tỉnh/Thành phố</option>
                                    </select>
                                    <select name="calc_shipping_district" class="form-control mt-1" required="">
                                        <option value="">Quận/Huyện</option>
                                    </select>
                                    <input class="billing_address_1" name="" type="hidden" value="">
                                    <input class="billing_address_2" name="" type="hidden" value="">
                                              <div class="text-center">
                                    <button type="submit_dt" class="mt-2 btn btn-danger mx-auto my-2 offset-1">Tìm
                                        kiếm</button>
                                              </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-2"> </div>
    </section>
    <section class="section_qlbaidang col-sm-8 bg-white">
        <div class="row mb-4  py-2">

            <a href="/tim-kiem-loai-hinh-thue/1" class="btn col-2 img_loaihinh">
                <div class=" d-flex flex-column  align-items-center  ">
                    <img src="{{ asset('images/chungcu.svg') }}">
                    <p class="ml-2">Chung cư</p>
                </div>
            </a>
            <a href="/tim-kiem-loai-hinh-thue/2" class="btn col-2 img_loaihinh">
                <div class=" d-flex flex-column  align-items-center  ">
                    <img src="{{ asset('images/nhao.svg') }}">
                    <p class="ml-2">Nhà ở</p>
                </div>
            </a>
            <a href="/tim-kiem-loai-hinh-thue/3" class="btn  col-2 img_loaihinh">
                <div class=" d-flex flex-column  align-items-center  ">
                    <img src="{{ asset('images/phongtro.svg') }}">
                    <p class="ml-2">Phòng trọ</p>
                </div>
            </a>
            <a href="/tim-kiem-loai-hinh-thue/4" class="btn col-2 img_loaihinh">
                <div class=" d-flex flex-column  align-items-center  ">
                    <img src="{{ asset('images/VanPhong.svg') }}">
                    <p class="ml-2">Văn phòng</p>
                </div>
            </a>
        </div>
        <hr>
        @if(isset($find) && $find = json_decode($find))
        <h5 class="mb-3 text-center">Thông tin các bài đăng <strong>{{ $tukhoa }}</strong> </h5>
        <div class="col-12 bg-white row d-flex justify-content-start mx-3 mt-3  ">

            @foreach ($find as $item)
            <div class="col-sm-4 col-lg-4 cart-status pr-1">
                <a class="btn btn-light sp_a" href="/chitiet_baidang/{{ $item->maphong }}">
                    <img class="card-img-top-status  img-fluid" src="{{ asset('images/'.$item ->image) }}" />
                </a>
                <div class="card-body card-body-status">
                    <p class="card-title">{{ $item->content }}</p>
                    <p class="card-text text-dt">{{ $item->dientich }} m²</p>
                    <h6 class="card-subtitle mb-2  text-price">{{ $item->gia }}</h6>
                </div>
            </div>

            @endforeach
        </div>
        @else
        <h5 class="text-center">Không tìm thấy bài đăng của:<strong>{{ $tukhoa }}</strong> </h5>
        @endif

    </section>
    <div class="col-sm-1"></div>
    <section class="row">
        @if(isset($PostLast))
        <div class="col-sm-2"></div>
        <section class="col-sm-8 bg-white text-dark mt-2">
            <h5 class="my-3 px-2"> Bài đăng gần đây </h5>
            <div class="row d-flex justify-content-start mx-1">
                @foreach ($PostLast as $p)

                <div class="col-sm-6 col-lg-3 cart-status">
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
        @endif
    </section>
    <section class="row">
        @if(isset($PostMostfav))
        <div class="col-sm-2"></div>
        <section class="col-sm-8 bg-white text-dark mt-2">
            <h5 class="my-3 px-2"> Tin đăng được quan tâm nhất </h5>
            <div class="row d-flex justify-content-start mx-1">
                @foreach ($PostMostfav as $p)

                <div class="col-sm-6  col-lg-3 cart-status">
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
        @endif
    </section>
</div>

<script>
    $(document).ready(function() {
        initializeAddressFields();
        initializeSliders();
    });
</script>
@endsection