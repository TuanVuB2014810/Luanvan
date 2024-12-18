@extends('layouts.app_admin')

@section('danhsach_phongtro')
<div class="mau_khung">
  <h3>Danh sách loại nhà trọ </h3> 
</div>



<div class="row px-2">
  <div class="col-sm-2"></div>
  <div class="col-sm-8">
  <table class="table mt-3" id="post-table">
    <thead>
      <tr class="">
        <th class="">STT</th>
        <th class=""> Tên loại </th>
        <th class="">Hành động</th>
      </tr>
    </thead>
    <tbody> 
      @php $i=1 @endphp
        @foreach ($loai as $item)
        
        <tr id="item-row-{{ $item->id }}">
            <td>{{ $i++}}</td>
            <td>{{ $item->name }}</td>
            
            <td class="d-flex">
              <a href="/admin/ql_loai/edit/{{ $item->id }}" class="btn btn-success py-1 mx-1"><i class="fa-regular fa-pen-to-square" style="color: #ffffff;"></i></a>
              <button class="btn btn-danger delete-item" data-id="{{ $item->id }}">
                  <i class="fa-solid fa-trash" style="color: #ffffff;"></i>
              </button>
              
            </td>
        </tr>
      
        @endforeach
    </tbody>
  </table>
  </div>
   <div class="col-sm-3"></div>
   <div class="col-12 text-center">
   <a class="btn btn-success" href="/admin/ql_loai-create">Thêm loại</a>
      @if(session('msg'))
<script>
    document.addEventListener("DOMContentLoaded", function () {
        Swal.fire({
            title: "Thành công",
            text: "{{ session('msg') }}",
            icon: "success",
            confirmButtonText: "OK"
        });
    });
</script>
@endif
   </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(document).ready(function () {
      bang(); // Gọi hàm bang() để khởi tạo DataTable
    //   $('.delete-item').on('click', function (e) {
    //     e.preventDefault(); // Ngăn hành động mặc định
    //     const itemId = $(this).data('id'); // Lấy ID người dùng từ nút
    //     const url = `/admin/ql_loai/delete/${itemId}`; // Tạo URL xóa

    //     delete_dt(url, itemId);
    // });
    $(document).on('click', '.delete-item', function (e) {
        e.preventDefault(); // Ngăn hành động mặc định

        // Lấy ID bài đăng từ thuộc tính data-id
        const itemId = $(this).data('id'); 
        const url = `/admin/ql_loai/delete/${itemId}`; // Tạo URL xóa

        // Hiển thị hộp thoại xác nhận với SweetAlert
        swal({
            title: "Bạn có thật sự muốn xóa?",
            text: "Thao tác này không thể hoàn tác!",
            icon: "warning",
            buttons: ["Hủy", "Xóa"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                // Gửi yêu cầu AJAX để xóa
                $.ajax({
                    url: url, // Đường dẫn API
                    type: 'DELETE', // Phương thức xóa
                    data: {
                        _token: '{{ csrf_token() }}', // Token CSRF để bảo mật
                    },
                    success: function (response) {
                        if (response.success) {
                            // Hiển thị thông báo thành công
                            swal("Thành công", response.success, "success");

                            // Xóa hàng HTML khỏi giao diện
                            $(`button[data-id="${itemId}"]`).closest('tr').fadeOut('slow', function () {
                                $(this).remove();
                            });
                        }
                    },
                    error: function (xhr) {
                        // Hiển thị lỗi từ server
                        swal("Lỗi", xhr.responseJSON?.error || "Đã xảy ra lỗi. Không thể xóa.", "error");
                    }
                });
            }
        });
    });
});
    
</script>

@endsection
     