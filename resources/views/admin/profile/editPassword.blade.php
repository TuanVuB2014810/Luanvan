@extends('layouts.app_admin')
@section('content')
<div class="container  row">
    <div class="col-sm-2">
      
    </div>
    <section class="col-sm-8">
        <div class="mau_khung py-1">
      
        <h3 class="text-center">Chỉnh sửa Mật khẩu </h3>

       </div>
        @if(session()->has('msg_success'))
        <script>
    document.addEventListener("DOMContentLoaded", function () {
        Swal.fire({
            title: "Thành công",
            text: "{{ session('msg_success') }}",
            icon: "success",
            confirmButtonText: "OK"
        });
    });
</script>
        @endif
        <div class=" row d-flex justify-content-center">
            <form action="" method="post" id="changePasswordForm" class="" onsubmit="return validatePasswordForm()">
                @csrf
                @method('PUT')

                <div class="input-group flex-nowrap login_ttk">
                    <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-unlock"></i></span>
                    <input type="password" class="form-control login_ttk" id="currentPassword" name="currentPassword"
                        placeholder="Xác nhận mập khẩu" required>
                    <span class="input-group-text toggle-password-toggle" style="cursor: pointer;">
                        <i class="fa-solid fa-eye"></i>
                    </span>
                </div>

                <div class="input-group flex-nowrap login_ttk mt-3">
                    <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-unlock"></i></span>
                    <input type="password" class="form-control login_ttk" id="newPassword" name="newPassword"
                        placeholder="Mập khẩu mới" required>
                    <span class="input-group-text toggle-password-toggle" style="cursor: pointer;">
                        <i class="fa-solid fa-eye"></i>
                    </span>
                </div>
                <div class="input-group flex-nowrap login_ttk mt-3">
                    <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-unlock"></i></span>
                    <input type="password" class="form-control login_ttk" id="confirmPassword"
                        placeholder="Nhập lại mật khẩu mới" name="confirmPassword" required>
                    <span class="input-group-text toggle-password-toggle" style="cursor: pointer;">
                        <i class="fa-solid fa-eye"></i>
                    </span>
                </div>
                @if(session()->has('msg_err'))
                <span class="error">{{ session('msg_err') }}</span><br>
               
                @endif
                <div id="errorContainer" class="error"></div>
                <input class="btn btn-success mt-2" type="submit" name="submit" value="Thay đổi">
               
            </form>

        </div>
    </section>
    <div class="col-sm-1">

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection