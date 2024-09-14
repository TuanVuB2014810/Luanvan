@extends('layouts.app')

@section('content')
<div class="  mt-3 row">
    <div class="col-sm-2">

    </div>
    <section class="col-sm-10 row">
        <div class="col-12 row">
            <div class="card div_avt_profile col-lg-3 col-12 mt-5" >
              <form id="uploadForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="file" name="image_avt" id="imageInput" accept="image/*" style="display: none;">
                <label for="imageInput" style="cursor: pointer; position: relative; display: inline-block;">
                    <div class="div_avt_svg">
                        <img id="uploadedImage" class="avt_img rounded-circle" src="{{ asset('images/'.$avatarUrl) }}" alt="Uploaded Image" style="width: 200px; height: 200px; object-fit: cover;">
                        <svg class="avt_svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 25" fill="currentColor" aria-hidden="true" class="w-4 h-4" >
                            <path d="M12 16.676a3 3 0 100-6 3 3 0 000 6z"></path>
                            <path d="M20.25 7.676h-2.766c-.14 0-.315-.091-.45-.235l-1.216-1.919a.727.727 0 00-.065-.086c-.42-.49-.987-.76-1.597-.76H9.844c-.61 0-1.177.27-1.597.76a.729.729 0 00-.065.086L6.967 7.444c-.104.114-.25.235-.404.235v-.375a.75.75 0 00-.75-.75H4.688a.75.75 0 00-.75.75v.375H3.75a2.252 2.252 0 00-2.25 2.25v8.997a2.252 2.252 0 002.25 2.25h16.5a2.252 2.252 0 002.25-2.25v-9a2.252 2.252 0 00-2.25-2.25zM12 18.176a4.5 4.5 0 110-9 4.5 4.5 0 010 9z"></path>
                        </svg>
                    </div>
                </label>
            </form>
            

               
                <div class="card-body">
                    <h5 class="card-title text-center profile_name"><b>{{ $user->name }}</b></h5>
                </div>
                <div class="row px-5">
                    <p class="col-sm-12">Địa Chỉ: {{ $user->city }}</p>
                    <p class="col-sm-12">Liên hệ:  {{ $user->phone }}</p>
                    <p class="col-sm-12">Đã tham gia:{{ $time }} </p>
                    <a class="btn btn-warning text-light col-12" href="/edit-profile">Chỉnh sữa thông tin</a>
                    <a class="btn btn-outline-dark col-12 my-2" href="/edit-profile-password"><b>Thay đổi mật khẩu</b></a>
                </div>
                
            </div>
            <div class="col-lg-8 col-12 bg-white row d-flex justify-content-start mx-3 mt-5  ">
               <h3 class=" col-12 pt-2 text-center"> Các bài đăng </h3>
               @if(!empty((array) json_decode($posts)))
                    @foreach ($posts as $p)
                    <div class="col-sm-12 col-lg-4 cart-status">
                        <a class="btn btn-light sp_a" href="/chitiet_baidang/{{ $p->maphong }}">
                            <img class="card-img-top-status  img-fluid" src="{{ asset('images/'.$p->image) }}" />
                        </a>
                        <div class="card-body card-body-status">
                        <p class="card-title">{{ $p->content }}</p>
                            <p class="card-text text-dt">{{ $p->dientich }} m²</p>
                            <h6 class="card-subtitle mb-2  text-price">{{ $p->gia }}</h6>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center">
                        <h4 class="">Chưa có bài đăng nào</h4>
                        <a class="btn btn-warning" href="/ql_dangbai"> Đăng ngay</a>
                    </div>
                @endif
            </div>

        </div>
       

    </section>
    {{-- <div class="col-sm-1">

    </div> --}}

</div>
<script>
  document.addEventListener('DOMContentLoaded', function () {
      document.getElementById('imageInput').addEventListener('change', function (event) {
          const fileInput = event.target;
          const imageElement = document.getElementById('uploadedImage');

          const file = fileInput.files[0];
          if (file) {
              const reader = new FileReader();
              reader.onload = function (e) {
                  const imageUrl = e.target.result;
                  // Kiểm tra xem phần tử uploadedImage có tồn tại hay không trước khi thiết lập thuộc tính src
                  if (imageElement) {
                      imageElement.src = imageUrl;
                      // Gọi hàm gửi biểu mẫu khi hình ảnh được chọn thành công
                      submitForm();
                  }
              };

              reader.readAsDataURL(file);
          }
      });

      // Thêm sự kiện click cho biểu tượng SVG
      document.getElementById('svgIcon').addEventListener('click', function () {
          document.getElementById('imageInput').click();
      });

      // Hàm gửi biểu mẫu
      function submitForm() {
          document.getElementById('uploadForm').submit();
      }
  });
</script>



@endsection
