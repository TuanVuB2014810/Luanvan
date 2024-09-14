@extends('layouts.app_admin')

@section('content')
<div class="col m-5">
    <h4 class="px-2">Chỉnh sửa loại hình:</h4>
    
    <form action="/admin/ql_loai/edit/{{$loai->id  }}" method="post" class="form-inline mb-3" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <table>
            <tr>
                <td>
                    <label>Loại hình:</label>
                </td>
                <td>
                    <input class="form-control" type="text" value="{{ $loai->name }}"  name="name" placeholder="Tên loại hình" id="tendm">
                </td>
            
               
                <td>
                <button class="btn btn-success py-1"  type="submit" name="submit">Submit</button>
                </td>
            </tr>
           
        </table>
    </form>
    

</div>
 
@endsection
    