@extends('layouts.app_admin')

@section('content')
<div class="mau_khung  ">

   <p class="mx-4 fs-3"> Trang quản lý của hệ thống tìm kiếm phòng trọ.</p>
</div>
    <h2 class="text-center my-5">Số bài đăng theo từng tháng</h2>
    <canvas id="monthlyPostChart"></canvas>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById('monthlyPostChart').getContext('2d');
            
            const chartData = {
                labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
                datasets: [{
                    label: 'Số bài đăng',
                    data: [
                        @foreach($monthlyPosts as $month => $count)
                            {{ $count }},
                        @endforeach
                    ],
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            };

            const config = {
                type: 'bar',
                data: chartData,
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 },
                            grid: {
                                display: false // Tắt lưới trục Y
                            }
                        },
                        x: {
                            grid: {
                                display: false // Tắt lưới trục X
                            }
                        }
                    }
                }
            };

            new Chart(ctx, config);
        });
    </script>
</div>
@endsection
