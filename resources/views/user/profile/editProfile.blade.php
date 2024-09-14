@extends('layouts.app')

@section('content')
<div class="container-fluid row pt-5">
    <div class="col-sm-3">
    </div>
    <section class="col-sm-6">
        <h3 class="text-center">Chỉnh sửa thông tin khách hàng</h3>

        <form action="" method="post" onsubmit="return validateEditProfile()">
            @csrf
            @method('PUT')
            <table class="table table_cus p-3">
                <tr>
                    <td class="col-md-2 ">Họ tên</td>
                    <td class="col-md-1">:</td>
                    <td class="col-md-8">
                        <input class="form-control" type="text" value="{{$user->name }}" name="name"
                            placeholder="Sửa tên" id="name" required>
                        <div id="nameError" style="color: red;"></div>
                    </td>
                </tr>
                <tr>
                    <td>Thành phố/Tỉnh</td>
                    <td>:</td>
                    <td>
                        <input class="form-control" type="text" value="{{$user->city }}" name="city"
                            placeholder="Sửa tỉnh thành" id="city" required>
                        <div id="cityError" style="color: red;"></div>
                    </td>
                </tr>
                <tr>
                    <td>Số điện thoại</td>
                    <td>:</td>
                    <td>
                        <input class="form-control" type="text" value="{{$user->phone }}" name="phone"
                            placeholder="Sửa số điện thoại" id="phone" required>
                        <div id="phoneError" style="color: red;"></div>
                    </td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td>:</td>
                    <td>
                        <input class="form-control" type="email" value="{{$user->email }}" name="email"
                            placeholder="Chỉnh sửa email" id="email" required>
                        <div id="emailError" style="color: red;"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"> <input type="submit" class="btn btn-outline-success mt-2 py-1" id="themmoi"
                            name="save" value="Cập nhật"></td>
                    <td class="mt-2">
                        @if(session()->has('msg_update'))
                        <span class="success_msg text-center">{{ session('msg_update') }}</span>
                        @endif
                    </td>
                </tr>
            </table>

        </form>

    </section>
    <div class="col-sm-3">

    </div>
</div>

<script>
    function validateEditProfile() {
        var name = document.getElementById('name').value.trim();
        var city = document.getElementById('city').value.trim();
        var phone = document.getElementById('phone').value.trim();
        var email = document.getElementById('email').value.trim();
        var errorMessage = '';
        if (name === '') {
            errorMessage += 'Vui lòng nhập họ tên.\n';
            document.getElementById('nameError').innerText = 'Vui lòng nhập họ tên.';
        } else {
            document.getElementById('nameError').innerText = ''; // Xóa thông báo lỗi nếu nhập đúng
        }
        if (city === '') {
            errorMessage += 'Vui lòng nhập thành phố/tỉnh.\n';
            document.getElementById('cityError').innerText = 'Vui lòng nhập thành phố/tỉnh.';
        } else {
            document.getElementById('cityError').innerText = ''; // Xóa thông báo lỗi nếu nhập đúng
        }
        if (phone === '') {
            errorMessage += 'Vui lòng nhập số điện thoại.\n';
            document.getElementById('phoneError').innerText = 'Vui lòng nhập số điện thoại.';
        } else if (!(/^\d{10}$/).test(phone)) {
            errorMessage += 'Số điện thoại phải có 10 chữ số.\n';
            document.getElementById('phoneError').innerText = 'Số điện thoại phải có 10 chữ số.';
        } else {
            document.getElementById('phoneError').innerText = ''; // Xóa thông báo lỗi nếu nhập đúng
        }
        if (email === '') {
            errorMessage += 'Vui lòng nhập email.\n';
            document.getElementById('emailError').innerText = 'Vui lòng nhập email.';
        } else if (!(/^\S+@\S+\.\S+$/).test(email)) {
            errorMessage += 'Email không hợp lệ.\n';
            document.getElementById('emailError').innerText = 'Email không hợp lệ.';
        } else {
            document.getElementById('emailError').innerText = ''; // Xóa thông báo lỗi nếu nhập đúng
        }
        if (errorMessage !== '') {
            return false;
        }
        return true;
    }
</script>

@endsection