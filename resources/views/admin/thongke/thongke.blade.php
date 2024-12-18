@extends('layouts.app_admin')

@section('danhsach_phongtro')
<div class=" admin_tk mau_khung row">
  <h3 class="col-12 col-lg-3">Thống Kê</h3>
  <form action="" class="select_tk col-12 col-lg-9" method="POST">
    @csrf
    @method('POST')
    <label class="col-form-label px-2">Tháng:</label>
    <select class="form-select " aria-label="Default select example" name="thang">
      <option value="0">Tất cả</option>
      @for ($i = 1; $i <= 12; $i++) <option value="{{ $i }}">{{ $i }}</option>
        @endfor

    </select>

    <label class="col-form-label px-2" for="">Năm:</label>
    <select class="form-select py-1" aria-label="Default select example" name="nam">
      <option value="0">Tất cả</option>
      @for ($i = 2024; $i >= 2020; $i--)
      <option value="{{ $i }}">{{ $i }}</option>
      @endfor

    </select>
    <button class="btn btn-light text-dark mx-2" type="submit" name="submit">Thống kê</button>
  </form>
</div>
{{-- @if($msg2 = Session::get('success'))
         <span class="success" >{{ $msg2 }}</span>
@endif --}}
@if(isset($nam) && isset($thang))
@if($nam==0 && $thang==0)
<h5 class="pt-3 px-2 text-center">Thống kê <b>tất cả</b></h5>
@elseif($nam==0 && $thang!=0)
<h5 class="pt-3 px-2 text-center">Thống kê <b>tháng {{ $thang }} </b></h5>
@elseif($nam!=0 && $thang==0)
<h5 class="pt-3 px-2 text-center">Thống kê <b> năm {{ $nam }} </b></h5>
@else
<h5 class="pt-3 px-2 text-center">Thống kê từ <b>{{ $thang }} - {{ $nam }}</b></h5>
@endif
@endif
<section class="row d-flex justify-content-center ">

  @if(isset($userPost))
  <div class="card col-sm-4 cart_tk" style="width: 18rem;">
    <div class="card-header card_header">
      <b>Đăng bài nhiều nhất</b>
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">người đăng: {{ $userPost->name }}</li>
      <li class="list-group-item">Số lượng bài:{{ $userPost->total_posts }}</li>

    </ul>
  </div>
  @else
  <div class="card col-sm-4 cart_tk" style="width: 18rem;">
    <div class="card-header card_header">
      <b>Đăng bài nhiều nhất</b>
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">Tháng này không có bài đăng</li>
      <li class="list-group-item">Số lượng bài: 0</li>

    </ul>
  </div>
  @endif
  @if(isset($quantityPost))
  <div class="card col-sm-4 cart_tk" style="width: 18rem;">
    <div class="card-header card_header">
      <b>Bài đăng</b>
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">Bài đăng: {{ $quantityPost->total_posts }} bài</li>
      <li class="list-group-item">Bài duyệt: {{ $quantityPost->total_duyet }} bài</li>
      <li class="list-group-item">Từ chối: {{ $quantityPost->total_tuchoi }} bài</li>
      <li class="list-group-item">Chờ duyệt: {{ $quantityPost->total_posts - $quantityPost->total_duyet - $quantityPost->total_tuchoi }} bài</li>

    </ul>
  </div>
  @endif
    @if(isset($user))
  <div class="card col-sm-4 cart_tk" style="width: 18rem;">
    <div class="card-header card_header">
      <b>Thành viên</b>
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">Số thành viên: {{$user->total_user }}</li>
      <li class="list-group-item">Thành viên đã đăng bài: {{ $user->total_user_in_posts }}</li>
      <li class="list-group-item">Tỉ lệ: {{$user->tyle }}</li>
      

    </ul>
  </div>
  @else
  <div class="card col-sm-4 cart_tk" style="width: 18rem;">
    <div class="card-header card_header">
           <b>Thành viên</b>
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">Tháng này không có thành viên nào đăng ký</li>

    </ul>
  </div>
  @endif
  {{-- <div class="card col-sm-4" style="width: 18rem;">
      <div class="card-header">
      <b>Đăng bài nhiều nhất</b>
      </div>
      <ul class="list-group list-group-flush">
      <li class="list-group-item">người đăng: {{ $userPost->name }}</li>
  <li class="list-group-item">Số lượng bài:{{ $userPost->total_posts }}</li>

  </ul>
  </div>
  <div class="card col-sm-4" style="width: 18rem;">
    <div class="card-header">
      <b>Đăng bài nhiều nhất</b>
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">người đăng: {{ $userPost->name }}</li>
      <li class="list-group-item">Số lượng bài:{{ $userPost->total_posts }}</li>

    </ul>
  </div> --}}
  <div class="row mt-3">
    <div class="col-lg-3"></div>
   <div class="col-lg-6">
   <canvas id="statChart" style="width: 350px; height: 350px; margin-left: 100px"></canvas>
   </div>
   <h3 class="text-center mt-2">Biểu đồ thể hiện trạng thái bài viết</h3>
   <div class="col-lg-3"></div>
</div>

</section>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('statChart').getContext('2d');
    const chartData = {
        labels: ['Bài đã duyệt', 'Bài từ chối', 'Bài chờ duyệt'],
        datasets: [{
            data: [
                {{ isset($quantityPost->total_duyet) ? $quantityPost->total_duyet : 0 }},
                {{ isset($quantityPost->total_tuchoi) ? $quantityPost->total_tuchoi : 0 }},
                {{ isset($quantityPost->total_posts) ? $quantityPost->total_posts - $quantityPost->total_duyet - $quantityPost->total_tuchoi : 0 }}
            ],
            backgroundColor: [
                'rgba(75, 192, 192, 0.7)',
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 99, 132, 0.7)',
                'rgba(255, 206, 86, 0.7)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 206, 86, 1)'
            ],
            borderWidth: 1
        }]
    };

    const config = {
        type: 'pie', // Biểu đồ tròn
        data: chartData,
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true, // Hiển thị chú thích cho biểu đồ tròn
                    position: 'right',
                    labels: {
                        boxWidth: 10, // Điều chỉnh kích thước hộp
                        padding: 15 // Khoảng cách giữa các mục trong legend
                    },
                    padding: 1 // Vị trí của chú thích
                },
                tooltip: {
                    enabled: true, // Hiển thị tooltip với phần trăm
                    callbacks: {
                        label: function(tooltipItem) {
                            let total = tooltipItem.dataset.data.reduce((acc, value) => acc + value, 0); // Tính tổng
                            let value = tooltipItem.raw;
                            let percentage = ((value / total) * 100).toFixed(2); // Tính phần trăm
                            return tooltipItem.label + ': ' + percentage + '%'; // Hiển thị phần trăm trong tooltip
                        }
                    }
                },
                datalabels: {
                    display: false, // Hiển thị số liệu trên biểu đồ
                    formatter: (value, ctx) => {
                        let total = ctx.dataset.data.reduce((acc, val) => acc + val, 0);
                        let percentage = (value / total * 100).toFixed(2);
                        return percentage + '%'; // Hiển thị phần trăm
                    }
                }
            },
            title: {
                display: true, // Hiển thị tiêu đề
                text: 'Thống kê Bài Đăng', // Tiêu đề của biểu đồ
                font: {
                    size: 16, // Kích thước chữ
                    weight: 'bold', // Đậm
                    family: 'Arial, sans-serif' // Phông chữ
                },
                padding: {
                    top: 10,
                    bottom: 20 // Khoảng cách trên và dưới tiêu đề
                }
            }
        },
    };

    new Chart(ctx, config);
});


</script>

@endsection