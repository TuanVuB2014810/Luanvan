@extends('layouts.app_admin')

@section('content')
<section class="section_qlbaidang">
  <div class="admin_tk mau_khung">

    <h3 class="m-2">Các bài đăng </h3>
    
    <form action="" class="col-lg-5 px-3" action="" method="POST">

      @csrf
      @method('POST')
      <div class="input-group search_div w-100 m-2">
        <input type="search" id="inputField1" class="form-control" name="tukhoa" placeholder="Tìm kiếm bài đăng"
          aria-label="Recipient's username" aria-describedby="button-addon2">
        <input class="btn btn-outline-primary" name="timkiem_sp" type="submit" value="Tìm" id="button-addon2">
      </div>
    </form>
  </div>
 @if($msg = Session::get('msg_duyet'))
    <br>
    <h5 class="success_msg text-center my-3">{{ $msg }}</h5>
    @endif
  <table class="table mt-3">
    <thead>
      <tr>
        <th>STT</th>
        <th class="col-5">Tên nội dung </th>
        <th>Người đăg</th>
        <th>ngày đăng</th>
        <th>Bài đăng </th>
        <th>Hành động</th>
      </tr>
    </thead>
    <tbody>
      @php $i=1 @endphp
      @foreach ($post as $item)

      <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $item->content }}</td>
        <td>{{ $item->name}}</td>
        <td>{{ $item->date_create}}</td>
        <td><a href="/admin/chitiet_baidang/{{ $item->maphong }}" class="btn btn-outline-success"> Xem chi tiết <i class="fa-solid fa-arrow-right" style="color: #ffffff;"></i></a></td>
        <td>
          @if($item->status==0)
          <a href="/admin/duyetbai/{{ $item->maphong }}" class="btn btn-success py-1">Duyệt</a>
          <!-- Button trigger modal -->
          <a href="" class="btn btn-danger py-1" data-toggle="modal" data-target="#rejectModal">Từ chối</a>
          <!-- Modal -->
          <div class="modal fade mt-5" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel"
            aria-hidden="true">
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
                      <!-- Select field for reason -->
                      <div class="form-group">
                          <label for="reasonSelect">Chọn hoặc nhập lý do:</label>
                          <select class="form-control" id="reasonSelect" name="reason"required>
                              <option value="">Chọn lý do từ chối</option>
                              <option value="Thông tin không chính xác">Thông tin không chính xác</option>
                              <option value="Ảnh không rõ ràng">Ảnh không rõ ràng</option>
                              <option value="Bài viết không phù hợp">Bài viết không phù hợp</option>
                              <option value="Bài viết vi phạm chính sách">Bài viết vi phạm chính sách</option>
                              <option value="Lý do tùy chỉnh">Lý do tùy chỉnh</option>
                          </select>
                          <!-- Input field for custom reason -->
                          <div id="customReasonInputWrapper" style="display: none;">
                              <input type="text" class="form-control mt-2" id="customReasonInput" name="reason" placeholder="Nhập lý do tùy chỉnh">
                          </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                      <button type="submit" class="btn btn-primary" id="btnReject">Từ chối</button>
                  </div>
              </form>
              
              
              </div>
            </div>
          </div>

          {{-- <a href="/admin/quan-ly-duyet-bai-an-bai/{{ $item->maphong }}" class="btn btn-danger py-1">Từ chối</a>
          --}}
          @elseif($item->status==1)
          <p> Đã duyệt</p>
          @else
          <p>Đã từ chối bài đăng</p>

          @endif
          {{-- <form action="/ql_dangbai/delete/{{$item->maphong }}" method="post">
          @csrf
          @method('delete')
          <button class="btn btn-danger py-1" type="submit" name="submit">Xóa</button>

          </form> --}}
        </td>
      </tr>

      @endforeach
    </tbody>
  </table>
</section>
<script>
  document.getElementById('btnReject').addEventListener('click', function() {
    // Lấy giá trị từ trường input
    var reason = document.getElementById('reason').value;
    // Gửi yêu cầu từ chối lên server
    // Code gửi yêu cầu từ chối tới server ở đây
    console.log('Lý do từ chối: ' + reason);
    // Đóng modal
    $('#rejectModal').modal('hide');
  });
  document.getElementById('reasonSelect').addEventListener('change', function() {
    var customReasonInputWrapper = document.getElementById('customReasonInputWrapper');
    var customReasonInput = document.getElementById('customReasonInput');
    
    // Lấy giá trị được chọn trong select
    var selectedValue = this.value;

    // Nếu giá trị được chọn là 'Lý do tùy chỉnh'
    if (selectedValue === 'Lý do tùy chỉnh') {
        // Hiển thị trường input và cập nhật giá trị của trường input
        customReasonInputWrapper.style.display = 'block';
        customReasonInput.setAttribute('name', 'customReason'); // Đặt tên mới cho trường input
    } else {
        // Nếu giá trị được chọn là một trong các giá trị khác, ẩn trường input và đặt giá trị của nó là trống
        customReasonInputWrapper.style.display = 'none';
        customReasonInput.setAttribute('name', ''); // Đặt tên của trường input về giá trị mặc định
        customReasonInput.value = ''; // Đặt giá trị của trường input về trống
    }
});


</script>

@endsection