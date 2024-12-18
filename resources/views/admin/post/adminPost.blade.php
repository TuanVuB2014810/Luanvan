@extends('layouts.app_admin')

@section('content')
<section class="section_qlbaidang">
  <div class="admin_tk mau_khung">
    <h3 class="mt-2">Các bài đăng </h3>
    
  </div>

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
  
  <table class="table mt-3" id="post-table">
    <thead>
      <tr>
        <th style="width: 1%;">STT</th>
        <th style="width: 25%;">Tên nội dung </th>
        <th style="width: 12%;">Người đăng</th>
        <th style="width: 17%;">Ngày đăng</th>
        <th style="width: 15%;">Bài đăng </th>
        <th style="width: 18%;">Trạng thái</th>
        <th style="width: 12%;">Hành động</th>
      </tr>
    </thead>
    <tbody>
      @php $i=1 @endphp
      @foreach ($post as $item)
      <tr data-id="{{ $item->maphong }}">
        <td>{{ $i++ }}</td>
        <td>{{ $item->content }}</td>
        <td>{{ $item->name}}</td>
        <td>{{ $item->date_create}}</td>
        <td>
          <a href="/admin/chitiet_baidang/{{ $item->maphong }}" class="btn btn-outline-success">Xem chi tiết <i class="fa-solid fa-arrow-right" style="color: #ffffff;"></i></a>
        </td>
        <td>
          @if($item->status==0)
          <button class="btn btn-success py-1" onclick="duyetBai('{{ $item->maphong }}')">Duyệt</button>
          <a href="" class="btn btn-danger py-1" data-toggle="modal" data-target="#rejectModal{{ $item->maphong }}">Từ chối</a>

          <!-- Modal Từ Chối -->
          <div class="modal fade mt-5" id="rejectModal{{ $item->maphong }}" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="rejectModalLabel">Lý do từ chối</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <form action="quan-ly-duyet-bai-an-bai/{{$item->maphong }}" method="post">
                          @csrf
                          @method('post')
                          <div class="modal-body">
                              <div class="form-group">
                                  <label for="reasonSelect">Chọn hoặc nhập lý do:</label>
                                  <select class="form-control reasonSelect" name="reason" required>
                                      <option value="">Chọn lý do từ chối</option>
                                      <option value="Thông tin không chính xác">Thông tin không chính xác</option>
                                      <option value="Ảnh không rõ ràng">Ảnh không rõ ràng</option>
                                      <option value="Bài viết không phù hợp">Bài viết không phù hợp</option>
                                      <option value="Bài viết vi phạm chính sách">Bài viết vi phạm chính sách</option>
                                      <option value="Lý do tùy chỉnh">Lý do tùy chỉnh</option>
                                  </select>
                                  <div class="customReasonInputWrapper" style="display: none;">
                                      <input type="text" class="form-control mt-2 customReasonInput" placeholder="Nhập lý do tùy chỉnh">
                                  </div>
                              </div>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                              <button type="submit" class="btn btn-primary">Từ chối</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>

          @elseif($item->status==1)
          <p>Đã duyệt</p>
          @else
          <p>Đã từ chối bài đăng</p>
          @endif
        </td>
        <td>
        <button class="delete-item btn btn-outline-danger btn-block btn-action-delete mx-1 p-3" data-id="{{ $item->maphong }}">
                <i class="fa-solid fa-trash fa-lg" style="color: #e94e4e;"></i>
            </button>
            </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <div class="mt-4 d-flex justify-content-center align-items-center">
    <a href="{{ route('baidang.create') }}" class="btn btn-success ">Thêm mới</a>
</div>

</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function duyetBai(id) {
    if (!id) {
        swal({
            title: "Lỗi",
            text: "ID không hợp lệ!",
            icon: "error",
            buttons: "OK",
        });
        return;
    }

    swal({
        title: "Xác nhận",
        text: "Bạn có chắc chắn muốn duyệt bài này?",
        icon: "warning",
        buttons: ["Hủy", "Duyệt"],
        dangerMode: true,
    }).then((willApprove) => {
        if (willApprove) {
            // Gửi yêu cầu AJAX duyệt bài
            $.ajax({
                url: '/admin/duyetbai',
                type: 'POST',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Cập nhật giao diện mà không tải lại trang
                        var row = $('tr[data-id="' + id + '"]');
                        row.find('td:nth-last-child(2)').html('<p>Đã duyệt</p>'); 
                        row.find('td:nth-child(6)').html('<p>Đã duyệt</p>');

                        swal({
                            title: "Thành công",
                            text: "Bài viết đã được duyệt.",
                            icon: "success",
                            buttons: "OK",
                        });
                    } else {
                        swal({
                            title: "Lỗi",
                            text: response.message || "Có lỗi xảy ra!",
                            icon: "error",
                            buttons: "OK",
                        });
                    }
                },
                error: function(xhr) {
                    swal({
                        title: "Lỗi",
                        text: "Có lỗi xảy ra! Vui lòng thử lại.",
                        icon: "error",
                        buttons: "OK",
                    });
                }
            });
        }
    });
}




  // Hiển thị trường lý do tùy chỉnh khi chọn
  $(document).on('change', '.reasonSelect', function() {
    var customReasonInputWrapper = $(this).closest('.modal-body').find('.customReasonInputWrapper');
    var customReasonInput = $(this).closest('.modal-body').find('.customReasonInput');
    
    if ($(this).val() === 'Lý do tùy chỉnh') {
        customReasonInputWrapper.show();
        customReasonInput.attr('name', 'customReason'); // Đặt tên mới cho trường input
    } else {
        customReasonInputWrapper.hide();
        customReasonInput.attr('name', ''); // Đặt tên của trường input về giá trị mặc định
        customReasonInput.val(''); // Đặt giá trị của trường input về trống
    }
});

  $(document).on('submit', 'form', function(e) {
    e.preventDefault(); // Ngăn chặn hành vi mặc định của form

    var form = $(this);
    var url = form.attr('action');
    var formData = form.serialize(); // Lấy dữ liệu từ form

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        success: function(response) {
            // Hiển thị thông báo và chờ người dùng xác nhận
            swal({
                title: "Thông báo",
                text: response.msg,
                icon: "success",
                buttons: "OK", // Hiển thị nút xác nhận
            }).then((willProceed) => {
                if (willProceed) {
                    // Người dùng đã bấm xác nhận
                    // Đóng modal
                    form.closest('.modal').modal('hide');
                    // Cập nhật giao diện nếu cần
                    location.reload(); // Tải lại trang để hiển thị thông tin mới
                }
            });
        },
        error: function(xhr) {
            // Xử lý lỗi
            swal({
                title: "Lỗi",
                text: "Có lỗi xảy ra! Vui lòng thử lại.",
                icon: "error",
                buttons: true, // Hiển thị nút xác nhận
            });
        }
    });

});
</script>

<script>
 $(document).ready(function () {
    // Khởi tạo DataTable
    bang();

    // Gắn sự kiện xóa với event delegation
    $(document).on('click', '.delete-item', function (e) {
        e.preventDefault(); // Ngăn hành động mặc định

        // Lấy ID bài đăng từ thuộc tính data-id
        const itemId = $(this).data('id'); 
        const url = `/admin/ql_dangbai/delete/${itemId}`; // Tạo URL xóa

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

<!-- <script>
  $(document).ready(function () {
    $('.delete-item').on('click', function (e) {
        e.preventDefault(); 
        const itemId = $(this).data('id'); 
        const url = `/admin/ql_dangbai/delete/${itemId}`; // Tạo URL xóa
        delete_dt(url, itemId);
    });
});
</script> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection
