@extends('layouts.app')

@section('content')
<section class="section_qlbaidang pt-5">
  <div class="container">
    <a class="btn btn-outline-success" href="/ql_dangbai/create">Đăng bài mới</a>
    <a class="btn btn-success" href="/ql_dangbai/show">Hiển thị</a>
    <a class="btn btn-danger" href="/ql_dangbai/refused">Bị từ chối</a>
    <a class="btn btn-secondary" href="/ql_dangbai/in-review">Chờ duyệt</a>
    <a class="btn btn-warning" href="/ql_dangbai/hidden">Ẩn</a>
    @if($msg = Session::get('msg'))
    <br>
    <h4 class="success_msg text-center my-3">{{ $msg }}</h4>
    @endif
    @if($msg = Session::get('success_del'))
    <br>
    <h4 class="success_msg text-center my-3">{{ $msg }}</h4>
    @endif
    {{-- @if($msg2 = Session::get('sucess'))
   <span class="success" >{{ $msg2 }}</span>
    @endif --}}
    <table class="table mt-3">
      <thead>
        <tr>
          <th class="col-1">STT</th>
          <th class="col-4">Tên nội dung</th>
          <th class="col-1">Mã phòng</th>
          <th class="col-2">Ngày tạo</th>
          <th class="col-1">Trạng thái</th>
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
            <form action="/ql_dangbai/delete/{{$item->maphong }}" method="post"
              class="btn-action col-12 col-lg-4 mb-1 mb-lg-0" style="padding-bottom: 18px">
              @csrf
              @method('delete')
              <button class="btn btn-outline-danger btn-block btn-action-delete mx-1 p-3"
                onclick="return confirm('bạn có thật sự muốn xóa bài đăng này')" type="submit"
                name="submit"><i class="fa-solid fa-trash fa-lg" style="color: #e94e4e;"></i></button>
            </form>
            @if($item->status==2)
            <a href="/ql_dangbai/show/{{ $item->maphong }}"
              class="btn btn-outline-info btn-action btn-action-show col-12 p-3 col-lg-4"><i class="fa-regular fa-eye fa-lg" style="color: #74C0FC;"></i></a>
            @elseif($item->status==1)
            <a href="/ql_dangbai/hidden/{{ $item->maphong }}"
              class="btn btn-outline-warning btn-action col-12 col-lg-4 p-3"><i class="fa-regular fa-eye-slash  fa-lg" style="color: #FFD43B;"></i></a>
            @endif
          </td>

        </tr>

        @endforeach
      </tbody>
    </table>
  </div>
</section>

@endsection