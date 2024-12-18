@extends('layouts.app_admin')

@section('danhsach_phongtro')
<div class="mau_khung">
  <h3>Danh sách đánh giá</h3> 
</div>

<div class="row px-2">
  <div class="col-sm-2"></div>
  <div class="col-sm-8">
  <table class="table mt-3" id="post-table">
    <thead>
      <tr class="">
        <th class="">STT</th>
        <th>Người dùng</th>
        <th class=""> Bình luận </th>
        <th>Số sao</th>
        <th class="">Hành động</th>
      </tr>
    </thead>
    <tbody> 
      @php 
      $i=1;
      $index = 1; 
      @endphp
        @foreach ($danhgia as $item)
        
        <tr id="item-row-{{ $item->id }}">
            <td>{{ $index++}}</td>
            <td>{{$item->name}}</td>
            <td>{{ $item->comment }}</td>
            <td>
                @php
                    $maxStars = 5; // Tổng số sao tối đa
                    $rating = $item->rating; // Giá trị rating
                @endphp

                @for ($i = 1; $i <= $maxStars; $i++)
                    @if ($i <= $rating)
                        <i class="fas fa-star" style="color: gold;"></i> <!-- Sao đầy -->
                    @else
                        <i class="far fa-star" style="color: gold;"></i> <!-- Sao rỗng -->
                    @endif
                @endfor
            </td>

            <td class="d-flex">
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
</div>

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
        const url = `/admin/ql_danhgia/delete/${itemId}`; // Tạo URL xóa

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
     