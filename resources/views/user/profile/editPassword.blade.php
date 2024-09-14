@extends('layouts.app')
@section('content')
<div class="container-fluid  row">
    <div class="col-sm-4">

    </div>
    <section class="col-sm-4">
        <h4 class="mt-5 text-center">Chỉnh sửa mật khẩu</h4>
       
        <div class=" row d-flex justify-content-center">
            <form action="" method="post" id="changePasswordForm" class="" onsubmit="return validatePasswordForm()">
                @csrf
                @method('PUT')

                <div class="input-group flex-nowrap login_ttk">
                    <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-lock-open" style="color: #74C0FC;"></i></span>
                    <input type="password" class="form-control login_ttk" id="currentPassword" name="currentPassword"
                        placeholder="Xác nhận mập khẩu" required>
                </div>

                <div class="input-group flex-nowrap login_ttk mt-3">
                    <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-unlock"></i></span>
                    <input type="password" class="form-control login_ttk" id="newPassword" name="newPassword"
                        placeholder="Mập khẩu mới" required>
                </div>
                <div class="input-group flex-nowrap login_ttk mt-3">
                    <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-unlock"></i></span>
                    <input type="password" class="form-control login_ttk" id="confirmPassword"
                        placeholder="Nhập lại mật khẩu" name="confirmPassword" required>
                </div>
                @if(session()->has('msg_err'))
                <span class="error">{{ session('msg_err') }}</span><br>
                @elseif(session()->has('msg_success'))
                <span class="success text-center text-success">{{ session('msg_success') }}</span><br>
                @endif
                <input class="btn btn-success mt-2" type="submit" name="submit" value="Thay đổi">
                <div id="errorContainer" class="error"></div>
            </form>

        </div>
    </section>
    <div class="col-sm-4">

    </div>
</div>
@endsection