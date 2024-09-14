@extends('layouts.app_admin')

@section('content')
<div class="container  row pt-5">
    <div class="col-sm-2">

    </div>
    <section class="col-sm-8">
         <div class="mau_khung py-1">
      
        <h3 class="text-center">Chỉnh sửa thông tin </h3>

       </div>
        @if(session()->has('msg_update'))
        <p class="success_msg text-center">{{ session('msg_update') }}</p>
        @endif
        <form action="" method="post" onsubmit="return validateEditProfile()">
            @csrf
            @method('PUT')
            <table class="table table_cus">

                <tr>
                    <td>Họ tên</td>
                    <td>:</td>
                    <td> <input class="form-control" type="text" value="{{$user->name }}" name="name"
                            placeholder="Sửa danh mục" id="name" required></td>
                        <div id="nameError" style="color: red;"></div>

                </tr>
                <tr>
                    <td>Thành phố/Tỉnh</td>
                    <td>:</td>
                    <td> <input class="form-control" type="text" value="{{$user->city }}" name="city"
                            placeholder="Sửa danh mục" id="city" required></td>
                        <div id="cityError" style="color: red;"></div>

                </tr>
                <tr>
                    <td>Số điện thoại</td>
                    <td>:</td>
                    <td> <input class="form-control" type="text" value="{{$user->phone }}" name="phone"
                            placeholder="Sửa danh mục" id="phone" required></td>
                        <div id="phoneError" style="color: red;"></div>

                </tr>

                <tr>
                    <td>Email:</td>
                    <td>:</td>
                    <td> <input class="form-control" type="email" value="{{$user->email }}" name="email"
                            placeholder="Chỉnh sửa email" id="email" required></td>
                        <div id="emailError" style="color: red;"></div>

                </tr>
                <tr>

                    <td colspan="3"> <input type="submit" class="btn btn-outline-success mt-2 py-1" id="themmoi"
                            name="save" value="Cập nhật"></td>
                </tr>
            </table>
        </form>
    </section>
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
    <div class="col-sm-1">

    </div>
</div>
@endsection