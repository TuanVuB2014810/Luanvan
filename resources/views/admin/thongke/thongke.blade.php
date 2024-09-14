@extends('layouts.app_admin')

@section('danhsach_phongtro')
<div class=" admin_tk mau_khung row">
  <h3 class="col-12 col-lg-3">Thống Kê</h3>
  <form action="" class="select_tk col-12 col-lg-9" method="POST">
    @csrf
    @method('POST')
    <label class="col-form-label px-2">Tháng:</label>
    <select class="form-select " aria-label="Default select example" name="thang">
      <option value="0">Tất cả</option>
      @for ($i = 1; $i <= 12; $i++) <option value="{{ $i }}">{{ $i }}</option>
        @endfor

    </select>

    <label class="col-form-label px-2" for="">Năm:</label>
    <select class="form-select py-1" aria-label="Default select example" name="nam">
      <option value="0">Tất cả</option>
      @for ($i = 2024; $i >= 2020; $i--)
      <option value="{{ $i }}">{{ $i }}</option>
      @endfor

    </select>
    <button class="btn btn-light text-dark mx-2" type="submit" name="submit">Thống kê</button>
  </form>
</div>
{{-- @if($msg2 = Session::get('success'))
         <span class="success" >{{ $msg2 }}</span>
@endif --}}
@if(isset($nam) && isset($thang))
@if($nam==0 && $thang==0)
<h5 class="py-4 px-2 text-center">Thống kê <b>tất cả</b></h5>
@elseif($nam==0 && $thang!=0)
<h5 class="py-4 px-2 text-center">Thống kê <b>tháng {{ $thang }} </b></h5>
@elseif($nam!=0 && $thang==0)
<h5 class="py-4 px-2 text-center">Thống kê <b> năm {{ $nam }} </b></h5>
@else
<h5 class="py-4 px-2 text-center">Thống kê từ <b>{{ $thang }} - {{ $nam }}</b></h5>
@endif
@endif
<section class="row mt-2 d-flex justify-content-center ">

  @if(isset($userPost))
  <div class="card col-sm-4 cart_tk" style="width: 18rem;">
    <div class="card-header card_header">
      <b>Đăng bài nhiều nhất</b>
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">người đăng: {{ $userPost->name }}</li>
      <li class="list-group-item">Số lượng bài:{{ $userPost->total_posts }}</li>

    </ul>
  </div>
  @else
  <div class="card col-sm-4 cart_tk" style="width: 18rem;">
    <div class="card-header card_header">
      <b>Đăng bài nhiều nhất</b>
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">Tháng này không có bài đăng</li>
      <li class="list-group-item">Số lượng bài: 0</li>

    </ul>
  </div>
  @endif
  @if(isset($quantityPost))
  <div class="card col-sm-4 cart_tk" style="width: 18rem;">
    <div class="card-header card_header">
      <b>Bài đăng</b>
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">Bài đăng: {{ $quantityPost->total_posts }} bài</li>
      <li class="list-group-item">Bài duyệt: {{ $quantityPost->total_duyet }} bài</li>
      <li class="list-group-item">Từ chối: {{ $quantityPost->total_tuchoi }} bài</li>
      <li class="list-group-item">Chờ duyệt: {{ $quantityPost->total_posts - $quantityPost->total_duyet - $quantityPost->total_tuchoi }} bài</li>

    </ul>
  </div>
  @endif
    @if(isset($user))
  <div class="card col-sm-4 cart_tk" style="width: 18rem;">
    <div class="card-header card_header">
      <b>Thành viên</b>
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">Số thành viên: {{$user->total_user }}</li>
      <li class="list-group-item">Thành viên đã đăng bài: {{ $user->total_user_in_posts }}</li>
      <li class="list-group-item">Tỉ lệ: {{$user->tyle }}</li>
      

    </ul>
  </div>
  @else
  <div class="card col-sm-4 cart_tk" style="width: 18rem;">
    <div class="card-header card_header">
           <b>Thành viên</b>
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">Tháng này không có thành viên nào đăng ký</li>

    </ul>
  </div>
  @endif
  {{-- <div class="card col-sm-4" style="width: 18rem;">
      <div class="card-header">
      <b>Đăng bài nhiều nhất</b>
      </div>
      <ul class="list-group list-group-flush">
      <li class="list-group-item">người đăng: {{ $userPost->name }}</li>
  <li class="list-group-item">Số lượng bài:{{ $userPost->total_posts }}</li>

  </ul>
  </div>
  <div class="card col-sm-4" style="width: 18rem;">
    <div class="card-header">
      <b>Đăng bài nhiều nhất</b>
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">người đăng: {{ $userPost->name }}</li>
      <li class="list-group-item">Số lượng bài:{{ $userPost->total_posts }}</li>

    </ul>
  </div> --}}

</section>

@endsection