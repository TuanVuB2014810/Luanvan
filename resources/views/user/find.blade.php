
        @if(isset($find) && $find = json_decode($find))
        <h5 class="mb-3 text-center" id="result">Thông tin các bài đăng <strong>{{ $tukhoa }}</strong> </h5>
        <div class="col-12 bg-white row d-flex justify-content-start mx-3 mt-3 ">
            @foreach ($find as $item)
            <div class="col-sm-4 col-lg-4 cart-status pr-1">
                <a class="btn btn-light sp_a" href="/chitiet_baidang/{{ $item->maphong }}">
                    <img class="card-img-top-status  img-fluid" src="{{ asset('images/'.$item ->image) }}" />
                </a>
                <div class="card-body card-body-status">
                    <p class="card-title">{{ $item->content }}</p>
                    <p class="card-text text-dt">{{ $item->dientich }} m²</p>
                    <h6 class="card-subtitle mb-2  text-price">{{ $item->gia }}</h6>
                </div>
            </div>
            @endforeach
        @else
        <h5 class="text-center">Không tìm thấy bài đăng của:<strong>{{ $tukhoa }}</strong> </h5>
        @endif
<script>
     $(document).ready(function() {
        initializeAddressFields();
        initializeSliders();
    });
    $(document).ready(function () {
        $('#searchForm').on('submit', function (e) {
            e.preventDefault(); // Ngăn không gửi form theo cách thông thường

            // Lấy dữ liệu từ form
            let formData = $(this).serialize();

            // Gửi dữ liệu qua AJAX
            $.ajax({
                url: '{{ route('find.posts') }}',  // Thay bằng route của bạn
                method: 'GET',
                data: formData,
                success: function (response) {
                    if (response.success) {
                        // Hiển thị kết quả tìm kiếm
                        $('#result').html(response.html);
                    } else {
                        // Hiển thị thông báo không tìm thấy kết quả
                        $('#result').html('<p class="text-danger">' + response.message + '</p>');
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Đã xảy ra lỗi:", error);
                    $('#result').html('<p class="text-danger">Không thể tải kết quả. Vui lòng thử lại.</p>');
                }
            });
        });
    });
</script>