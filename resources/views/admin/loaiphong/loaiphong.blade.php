@extends('layouts.app_admin')

@section('danhsach_phongtro')
<div class="mau_khung">
  <h3>Danh sách loại nhà trọ </h3> 
</div>


<a class="btn btn-success" href="/admin/ql_loai-create">Thêm loại</a>
{{-- @if($msg)
  <h5 class="success text-center">{{ $msg}}</h5>
  @endif --}}
   @if($msg = Session::get('msg'))
    <br>
    <h5 class="success_msg text-center my-1">{{ $msg }}</h5>
    @endif
<div class="row px-2">
  <div class="col-sm-3"></div>
  <table class="table mt-3 col-sm-6">
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
        
        <tr>
            <td>{{ $i++}}</td>
            <td>{{ $item->name }}</td>
            
            <td class="d-flex">
              <a href="/admin/ql_loai/edit/{{ $item->id }}" class="btn btn-success py-1 mx-1"><i class="fa-regular fa-pen-to-square" style="color: #ffffff;"></i></a>
              <form action="/admin/ql_loai/delete/{{$item->id }}" method="POST">
                @csrf
                @method('delete')
                <button type="submit" name="submit" onclick="return confirm('bạn có thật sự muốn xóa')" class="btn btn-danger"><i class="fa-solid fa-trash" style="color: #ffffff;"></i></button>
                
              </form> 
            </td>
        </tr>
      
        @endforeach
    </tbody>
  </table>
   <div class="col-sm-3"></div>
</div>

@endsection
     