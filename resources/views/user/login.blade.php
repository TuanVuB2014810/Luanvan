@extends('layouts.app')
@section('content')
<section class="row container d-flex justify-content-center mt-5">
    <div class="col-2"></div>
    <div class="dangnhap row d-flex justify-content-between col-sm-6 mt-5 bg-white">
        <h4 class="text-center "> Đăng nhập </h4>
        @if($msg = Session::get('error'))
        <span class="error text-center">{{ $msg }}</span>
        @endif

        <form  action="/post-login" method="POST" class="row  form_login d-flex justify-content-between">
            @csrf
            @method('post')
           
                <div class="input-group col-12 flex-nowrap login_ttk col-12">
                    <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-user"></i></span>
                    <input type="text" name="name" class="form-control login_ttk" placeholder="Tên người dùng"
                        aria-label="Username" aria-describedby="addon-wrapping" required>
                </div>
                <div class="input-group flex-nowrap login_ttk mt-3">
                    <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-unlock"></i></span>
                    <input type="password" name="pass" class="form-control login_ttk" placeholder="Mật khẩu"
                        aria-label="Username" aria-describedby="addon-wrapping" required>
                </div>
               
                <input class="btn btn-success mt-4 mx-auto submit_login" type="submit" name="login" value="Đăng nhập">
                {{-- <div class="flex items-center justify-end mt-4 align-middle ">
                    <a href="{{ route('auth.google') }}">
                        google
                    </a>
                </div> --}}
                <h6 class="text-center mt-4">Hoặc đăng nhập bằng</h6>
                <hr class="my-2">
                <div class="row d-fex justify-content-center">
                    <a class="btn a_login_gg col-5 btn_login mocked-styled-18 b10u9umr"  href="{{ route('auth.google') }}">
                        <svg class="" width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg"> 
                            <path
                                d="M19.2992 10.1951C19.2992 9.47569 19.2395 8.95069 19.1102 8.40625H10.7031V11.6534H15.6379C15.5384 12.4604 15.0012 13.6757 13.8072 14.4923L13.7905 14.601L16.4487 16.6133L16.6328 16.6312C18.3242 15.1048 19.2992 12.859 19.2992 10.1951Z"
                                fill="#4285F4"></path>
                            <path
                                d="M10.7042 18.75C13.1219 18.75 15.1515 17.9722 16.634 16.6306L13.8084 14.4916C13.0522 15.0069 12.0374 15.3666 10.7042 15.3666C8.33635 15.3666 6.32663 13.8403 5.61022 11.7306L5.50522 11.7393L2.74122 13.8296L2.70508 13.9278C4.17754 16.7861 7.2021 18.75 10.7042 18.75Z"
                                fill="#34A853"></path>
                            <path
                                d="M5.61025 11.7322C5.42122 11.1878 5.31182 10.6044 5.31182 10.0016C5.31182 9.39881 5.42122 8.8155 5.6003 8.27106L5.59529 8.15511L2.79666 6.03125L2.7051 6.07381C2.09823 7.25994 1.75 8.59191 1.75 10.0016C1.75 11.4113 2.09823 12.7432 2.7051 13.9294L5.61025 11.7322Z"
                                fill="#FBBC05"></path>
                            <path
                                d="M10.7042 4.63331C12.3856 4.63331 13.5198 5.34303 14.1665 5.93612L16.6936 3.525C15.1416 2.11528 13.1219 1.25 10.7042 1.25C7.2021 1.25 4.17754 3.21387 2.70508 6.07218L5.60028 8.26944C6.32664 6.15972 8.33636 4.63331 10.7042 4.63331Z"
                                fill="#EB4335"></path>
                        </svg><b class="mx-2">Google</b>
                    </a>
                    <a class="btn  a_login_fb col-6 btn_login mocked-styled-18 b10u9umr" href="{{ route('auth.facebook') }}">
                        <svg class="" width="20" height="20" viewBox="0 0 20 20" fill="none" 
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10.0005 1.66797C5.3988 1.66797 1.66797 5.32786 1.66797 9.84202C1.66797 13.9213 4.71464 17.3024 8.6988 17.918V12.2054H6.58214V9.84202H8.6988V8.0411C8.6988 5.99084 9.94297 4.86025 11.8455 4.86025C12.7571 4.86025 13.7121 5.01966 13.7121 5.01966V7.02986H12.6588C11.6255 7.02986 11.3021 7.66096 11.3021 8.3076V9.84038H13.6113L13.2421 12.2037H11.3021V17.9163C15.2863 17.304 18.333 13.9221 18.333 9.84202C18.333 5.32786 14.6021 1.66797 10.0005 1.66797Z"
                                fill="#2561CF"></path>
                        </svg><b class="mx-2">Facebook</b>
                    </a>
                    <p class=" px-1 py-1 col-11"> Chưa có tài khoản? <a href="/register" class="no-underline"> Đăng ký tài khoản
                        </a></p>
                </div>
            
        </form>
    </div>

</section>

@endsection