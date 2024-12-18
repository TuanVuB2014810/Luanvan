@extends('layouts.app')
@section('content')
<div class="container-fluid row">
    <div class="col-sm-4"></div>
    <section class="col-sm-4">
        <h4 class="mt-5 text-center">Chỉnh sửa mật khẩu</h4>

        <div class="row d-flex justify-content-center">
            <form action="" method="post" id="changePasswordForm" class="" onsubmit="return validatePasswordForm()">
                @csrf
                @method('PUT')

                <div class="input-group flex-nowrap login_ttk">
                    <span class="input-group-text" id="addon-wrapping">
                        <i class="fa-solid fa-lock-open" style="color: #74C0FC;"></i>
                    </span>
                    <input type="password" class="form-control login_ttk" id="currentPassword" name="currentPassword"
                        placeholder="Xác nhận mật khẩu" required>
                    <span class="input-group-text toggle-password-toggle" style="cursor: pointer;">
                        <i class="fa-solid fa-eye"></i>
                    </span>
                </div>

                <div class="input-group flex-nowrap login_ttk mt-3">
                    <span class="input-group-text" id="addon-wrapping">
                        <i class="fa-solid fa-unlock"></i>
                    </span>
                    <input type="password" class="form-control login_ttk" id="newPassword" name="newPassword"
                        placeholder="Mật khẩu mới" required>
                    <span class="input-group-text toggle-password-toggle" style="cursor: pointer;">
                        <i class="fa-solid fa-eye"></i>
                    </span>
                </div>

                <div class="input-group flex-nowrap login_ttk mt-3">
                    <span class="input-group-text" id="addon-wrapping">
                        <i class="fa-solid fa-unlock"></i>
                    </span>
                    <input type="password" class="form-control login_ttk" id="confirmPassword"
                        placeholder="Nhập lại mật khẩu" name="confirmPassword" required>
                    <span class="input-group-text toggle-password-toggle" style="cursor: pointer;">
                        <i class="fa-solid fa-eye"></i>
                    </span>
                </div>
                <input class="btn btn-success mt-2" type="submit" name="submit" value="Thay đổi">
                <div id="errorContainer" class="error"></div>
            </form>
        </div>
    </section>
    <div class="col-sm-4"></div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        @if(session()->has('msg_err'))
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: '{{ session('msg_err') }}',
            });
        @elseif(session()->has('msg_success'))
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: '{{ session('msg_success') }}',
            });
        @endif
    });
</script>

@endsection
