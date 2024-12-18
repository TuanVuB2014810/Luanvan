@extends('layouts.app')
@section('content')
<section class="row container d-flex justify-content-center">
    <div class="col-2"></div>
    <div class="dangnhap row d-flex justify-content-between col-sm-6 mt-5">
        <h4 class="text-center"> Tạo tài khoản</h4>
        
        @if(Session::has('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    title: 'Chúc mừng',
                    text: "{{ Session::get('success') }}",
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            });
        </script>

        @endif

        <form action="" method="POST" class="row form_login d-flex justify-content-between">
            @csrf
            <div class="input-group d-flex justify-content-center mb-3 login_ttk">
                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Tên người dùng" >
            </div>
            @error('name')
            <div class="text-danger mb-2">{{ $message }}</div>
            @enderror
            <div class="input-group d-flex justify-content-center mb-3 login_ttk">
                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                <input type="password" name="pass" class="form-control" value="{{ old('pass') }}" placeholder="Mật khẩu" >
                <span class="input-group-text toggle-password-toggle" style="cursor: pointer;">
                        <i class="fa-solid fa-eye"></i>
                    </span>
            </div>
           
            @error('pass')
                <div class="text-danger mb-2">{{ $message }}</div>
                @enderror
            <div class="input-group d-flex justify-content-center mb-3 login_ttk">
                <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email" >
            </div>
            @error('email')
                <div class="text-danger mb-2">{{ $message }}</div>
                @enderror
            <div class="input-group d-flex justify-content-center mb-3 login_ttk">
                <span class="input-group-text"><i class="fa-regular fa-building"></i></span>
                <input type="text" name="city" class="form-control" value="{{ old('city') }}" placeholder="Thành phố" >
                
            </div>
            @error('city')
                <div class="text-danger mb-2">{{ $message }}</div>
                @enderror
            <div class="input-group d-flex justify-content-center mb-3 login_ttk">
                <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                <input type="phone" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="Số điện thoại" >
               
            </div>
            @error('phone')
                <div class="text-danger mb-2">{{ $message }}</div>
                @enderror
            <div>
                <input type="submit" name="submit" class="btn btn-success d-flex justify-content-center mx-auto"
                    value="Tạo tài khoản" id="tendm">
            </div>
        </form>

        <p class="px-2 py-1 text-center"> Đã có tài khoản? <a href="/login" class="no-underline"> Đăng nhập ngay</a></p>
    </div>
</section>
@endsection
