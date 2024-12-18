@extends('layouts.app')

@section('content')
<section class="section_qlbaidang pt-5">
  <div class="container ">
  <div class="nut">
        <a class="btn btn-outline-success me-2" href="/ql_dangbai/create">Đăng bài mới</a>
        <a class="btn btn-success me-2" href="/ql_dangbai/show">Hiển thị</a>
        <a class="btn btn-danger me-2" href="/ql_dangbai/refused">Bị từ chối</a>
        <a class="btn btn-secondary me-2" href="/ql_dangbai/in-review">Chờ duyệt</a>
        <a class="btn btn-warning me-2" href="/ql_dangbai/hidden">Ẩn</a>
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

    @if($msg = Session::get('success_del'))
    <br>
    <h4 class="success_msg text-center my-3">{{ $msg }}</h4>
    @endif
    {{-- @if($msg2 = Session::get('sucess'))
   <span class="success" >{{ $msg2 }}</span>
    @endif --}}
    <table class="table" id="post-table">
      <thead>
        <tr>
          <th class="col-1">STT</th>
          <th class="col-4">Tên nội dung</th>
          <th class="col-1">Mã phòng</th>
          <th class="col-2">Ngày tạo</th>
          <th class="col-2">Trạng thái</th>
          <th class="col-3">Hành động</th>
        </tr>

      </thead>
      <tbody>
        @php
        $counter = 1;
        @endphp
        @foreach ($post as $item)

        <tr>
          <td>{{ $counter++ }}</td>
          <td>{{ $item->content }}</td>
          <td>{{ $item->maphong}}</td>
          <td>{{ $item->date_create}}</td>
          <td>
            @if($item->status==0)
            <p>Đang chờ duyệt</p>
            @elseif($item->status==-1)
            <p>Bài viết đã bị từ chối</p>
            @elseif($item->status==1)
            <p>Đã đăng</p>
            @else
            <p>Đã ẩn</p>

            @endif
          </td>
          <td class="d-flex flex-column flex-lg-row">
            <a href="/ql_dangbai/edit/{{ $item->maphong }}"
              class="btn btn-outline-success col-12 col-lg-4 p-3 btn-action mb-1 mb-lg-0"><i class="fa-regular fa-pen-to-square fa-lg" style="color: #63E6BE;"></i></a>
            <div class="btn-action col-12 col-lg-4 mb-1 mb-lg-0" style="padding-bottom: 20px">
    
              <!-- Nút xóa bài đăng -->
              <button class="delete-item btn btn-outline-danger btn-block btn-action-delete mx-1 p-3" data-id="{{ $item->maphong }}">
                <i class="fa-solid fa-trash fa-lg" style="color: #e94e4e;"></i>
            </button>

            </div>
            @if($item->status==2)
              <a href="javascript:void(0)" 
                data-url="/ql_dangbai/show/{{ $item->maphong }}" 
                class="btn btn-outline-info btn-action btn-action-show col-12 p-3 col-lg-4"
                onclick="confirmAjaxAction(event, 'Bạn có chắc chắn muốn hiện bài viết này?')">
                  <i class="fa-regular fa-eye fa-lg" style="color: #74C0FC;"></i>
              </a>
              @elseif($item->status==1)
              <a href="javascript:void(0)" 
                data-url="/ql_dangbai/hidden/{{ $item->maphong }}" 
                class="btn btn-outline-warning btn-action col-12 col-lg-4 p-3"
                onclick="confirmAjaxAction(event, 'Bạn có chắc chắn muốn ẩn bài viết này?')">
                  <i class="fa-regular fa-eye-slash fa-lg" style="color: #FFD43B;"></i>
              </a>
              @endif

          </td>

        </tr>

        @endforeach
      </tbody>
    </table>
  </div>
</section>

<script>
  $(document).ready(function () {
    // Khởi tạo DataTable
    bang();

    // Gắn sự kiện xóa với event delegation
    $(document).on('click', '.delete-item', function (e) {
        e.preventDefault(); // Ngăn hành động mặc định

        // Lấy ID bài đăng từ thuộc tính data-id
        const itemId = $(this).data('id'); 
        const url = `/ql_dangbai/delete/${itemId}`; // Tạo URL xóa

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