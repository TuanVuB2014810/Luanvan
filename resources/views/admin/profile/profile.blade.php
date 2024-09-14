@extends('layouts.app_admin')

@section('danhsach_phongtro')

<div class=" container mt-3 row">
    <div class="col-sm-2">

    </div>
    <section class="col-sm-8">
       <div class="mau_khung py-1">
         <h4 class="p-3 my-2 pt-4">Thông tin </h4>
       </div>

        <table class="table  table_cus">

            <tr >
                <td class="w-35 text-end "><i class="fa fa-user  mx-2"></i>Họ tên |</td>

                <td class="w-35 text-primary ">{{ $userAdmin->name }}</td>
            </tr>
            <tr>
                <td class="text-end "><i class="fa-solid fa-city   mx-2"></i>Thành phố/Tỉnh |</td>

                <td class="text-primary">{{ $userAdmin->city }}</td>
            </tr>
            <tr>
                <td class="text-end "><i class="fa-solid fa-location-dot  mx-2"></i>Địa chỉ |</td>

                <td class="text-primary">{{ $userAdmin->city }}</td>
            </tr>
            <tr>
                <td class="text-end "><i class="fa-solid fa-phone  mx-2"></i> Số điện thoại |</td>

                <td class="text-primary">{{ $userAdmin->phone }}</td>
            </tr>
            <tr>
                <td class="text-end "><i class="fa-solid fa-envelope mx-2"></i> Email |</td>

                <td class="text-primary">{{ $userAdmin->email }}</td>
            </tr>
            <tr>

                <td colspan="3">
                    <div class="mx-auto text-center">
                    <a class="btn btn-outline-success text-aligt" href="{{ route('edit_profileAdmin') }}">Chỉnh sửa </a>

                    </div>
                
                </td>
            </tr>

        </table>
    </section>
    <div class="col-sm-2">

    </div>

</div>
@endsection

