@extends('layouts.app_admin')

@section('content')
<div class="mau_khung  ">
   <h4 class="mx-4 fs-2">
      @if(Auth::user())
      Xin chào  {{ Auth::user()->name }}
      @endif
  
   </h4>

   <p class="mx-4 fs-3"> Trang quản lý của hệ thống tìm kiếm phòng trọ.</p>
</div>
 
@endsection
    