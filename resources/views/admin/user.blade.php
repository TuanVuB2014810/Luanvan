@extends('layouts.app_admin')

@section('content')
<div class="mau_khung">
<h3>Thông tin người dùng  </h3> 


</div>
<table class="table mt-3" id="post-table">
    <thead>
      <tr>
        <th>STT</th>
        <th> Tên người dùng</th>
        <th>Địa chỉ</th>
        <th> Email</th>
        <th>Số Điện Thoại</th>
        <th>Loại tài khoản</th>
        <th>Thao tác</th>
      </tr>
    </thead>
    <tbody>
      @php
       $i=1;
      @endphp
        @foreach ($users as $user)
        <tr id="user-row-{{ $user->user_id }}">
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
            <td class="d-flex">
            <button class="btn btn-danger delete-user" data-id="{{ $user->user_id }}">
                <i class="fa-solid fa-trash" style="color: #ffffff;"></i>
            </button>
            </td>
        </tr>
      
        @endforeach
    </tbody>
  </table>
  <script>
  $(document).ready(function () {
      bang(); // Gọi hàm bang() để khởi tạo DataTable
      $('.delete-user').on('click', function (e) {
        e.preventDefault(); // Ngăn hành động mặc định
        const userId = $(this).data('id'); // Lấy ID người dùng từ nút
        const url = `/admin/ql_taikhoan/delete/${userId}`; // Tạo URL xóa

        delete_dt(url, userId);
    });
  });
</script>
<script>
    // Hàm xóa người dùng




@endsection
    