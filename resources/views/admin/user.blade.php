@extends('layouts.app_admin')

@section('content')
<div class="mau_khung">
<h3>Thông tin người dùng  </h3> 


</div>
<table class="table mt-3">
    <thead>
      <tr>
        <th>STT</th>
        <th> Tên người dùng</th>
        <th>Địa chỉ</th>
        <th> Email</th>
        <th>Số Điện Thoại</th>
        <th>Loại tài khoản</th>

      </tr>
    </thead>
    <tbody>
      @php
       $i=1;
      @endphp
        @foreach ($users as $user)
        <tr>
            <td>{{$i++}}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->city}}</td>
            <td>{{ $user->email}}</td>
            <td>{{ $user->phone}}</td>
            @if($user->google_id != null)
            <td><i class="fa-brands fa-google fa-xl" style="color: #d74514;"></i></td>
            @elseif($user->facebook_id !=null)
            <td><i class="fa-brands fa-facebook fa-xl" style="color: #0b5dea;"></i></td>
            @else
            <td>Đăng ký</td>
            @endif
            
        </tr>
      
        @endforeach
    </tbody>
  </table>
@endsection
    