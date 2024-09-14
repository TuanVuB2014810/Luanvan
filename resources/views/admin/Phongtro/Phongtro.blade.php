@extends('layouts.app_admin')

@section('danhsach_phongtro')
<div class="mau_khung">
 <h3>Thông tin phòng trọ</h3> 

</div>
@if(isset($msg_err)){
  <p>không có phòng trọ này</p>
}

@endif
<table class="table mt-3">
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
@endsection
    