@extends('layouts.app_admin')

@section('content')
<div class="col m-5">
    <h4 class="px-2">Thêm loại hình</h4>
    
    <form action=" {{ URL::to('/admin/ql_loai-store') }}" method="post" class="form-inline mb-3" enctype="multipart/form-data">
        @csrf
        <table>
            <tr>
                <td >
                    <label class="px-3">Loại hình</label>
                </td>
                <td>
                <input class="form-control px-3" type="text" name="name" placeholder="Thêm tên loại hình" id="tendm">
                </td>
                <td>
                    <button class="btn btn-success py-1"  type="submit" name="submit">Submit</button>
                </td>
            </tr>
           
            
           
        </table>
    </form>
    

</div>
 
@endsection
    