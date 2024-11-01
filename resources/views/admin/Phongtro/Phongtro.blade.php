@extends('layouts.app_admin')

@section('danhsach_phongtro')
<div class="mau_khung">
 <h3>Thông tin phòng trọ</h3> 

</div>
@if(isset($msg_err)){
  <p>không có phòng trọ này</p>
}

@endif
<div class="col-sm-4 d-flex">
            <form action="{{route('import')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <div class="col-sm-3" style="margin-right: 14px;">
                        <input class="btn btn-success " type="submit" value="Nhập File" name="import_csv">
                    </div>
                    <br>
                    <input type="file" style="margin-top: -3px;" name="file" style accept=".xlsx" class="form-control-file">
                    
                </div>
            </form>
        </div>
<table class="table mt-3" id="post-table">
    <thead>
      <tr>
        <th>STT</th>
        <th> Tên phòng trọ </th>
        <th>Số chỗ</th>
        <th>Giá phòng</th>
        <th>Giá nước / tháng</th>
        <th>Giá điện / tháng</th>
     
       
        <th>Xem chi tiết</th>
      </tr>
    </thead>
    <tbody>
      @php $i=1 @endphp
        @foreach ($phongtro as $item)
        
        <tr>
            <td>{{$i++}}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->sophong}}</td>
            <td>{{ $item->gia}}</td>
            <td>{{ $item->gia_nuoc}}</td>
            <td>{{ $item->gia_dien}}</td>
           

           
        <td><a href="/admin/chitiet_baidang/{{ $item->maphong }}" class="btn btn-success"> <i class="fa-solid fa-arrow-right" style="color: #ffffff;"></i></a></td>
              
              
            
        </tr>
      
        @endforeach
    </tbody>
  </table>
<script>
  $(document).ready(function () {
      bang(); // Gọi hàm bang() để khởi tạo DataTable
  });
</script>
@endsection
    