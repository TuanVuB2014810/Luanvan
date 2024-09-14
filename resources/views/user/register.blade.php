@extends('layouts.app')
@section('content')
<section class="row container d-flex justify-content-center">
    <div class="col-2"></div>
    <div class="dangnhap row d-flex justify-content-between col-sm-6 mt-5">
        <h4 class="text-center"> Tạo tài khoản</h4>
        @if($msg2 = Session::get('success'))
        <span class="success_msg text-center">{{ $msg2 }}</span>
        @endif
        <form action="" method="POST" class="row form_login d-flex justify-content-between">
            @csrf
            @method('post')
            <div class="input-group d-flex justify-content-center mb-3 login_ttk">
                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                <input type="text" name="name" class="form-control" placeholder="Tên người dùng" required>
                
            </div>
            <div class="input-group d-flex justify-content-center mb-3 login_ttk">
                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                <input type="password" name="pass" class="form-control" placeholder="Mật khẩu" required>
               
            </div>
            <div class="input-group d-flex justify-content-center mb-3 login_ttk">
                <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
               

            </div>
            <div class="input-group d-flex justify-content-center mb-3 login_ttk">
                <span class="input-group-text"><i class="fa-regular fa-building"></i></span>
                <input type="text" name="city" class="form-control" placeholder="Thành phố"  required>
                

            </div>
            <div class="input-group d-flex justify-content-center mb-3 login_ttk">
                <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                <input type="phone" name="phone" class="form-control" placeholder="Số điện thoại" required>
                

            </div>
            
            <div>
                <input type="submit" name="submit" class="btn btn-success d-flex justify-content-center mx-auto"
                    value="Tạo tài khoản" id="tendm">
            </div>
        </form>

        <p class="px-2 py-1 text-center" > Đã có tài khoản? <a href="/login" class="no-underline"> Đăng nhập ngay</a></p>
    </div>

</section>

@endsection