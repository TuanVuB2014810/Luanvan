@extends('layouts.app')

@section('content')
<section class="section_qlbaidang">

    <div class="container  row pt-3">
        <div class="col-sm-4">

        </div>
        <section class="col-sm-6">
            <h2 class="py-3 text-center"> Thêm bài đăng mới </h2>
            <form action="" id="imageForm" method="post" class="form-inline mb-3" enctype="multipart/form-data">
                @csrf
                @method('post')
                <table class="table table_cus">
                    <tr>
                        <td>
                            <label>Nội dung bài đăng: </label>
                        </td>
                        <td>
                            <input id="content" class="form-control" type="text" name="content" placeholder="Nội dung bài đăng" required>
                            <span id="contentError" class="text-danger"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Tên phòng trọ:</label>
                        </td>
                        <td>
                            <input class="form-control" type="text" name="name" placeholder="nhập tên nhà ở" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Số phòng :</label>
                        </td>
                        <td>
                            <input type="number" min="1" class="form-control" type="text" value="1" name="sophong"
                                placeholder="số phòng" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Địa chỉ: </label>
                        </td>
                        <td>
                            <select name="calc_shipping_provinces" class="form-control" required="">
                                <option value="">Tỉnh / Thành phố</option>
                            </select>
                            <select name="calc_shipping_district" class="form-control" required="">
                                <option value="">Quận / Huyện</option>
                            </select>
                            <input class="billing_address_1" name="" type="hidden" value="">
                            <input class="billing_address_2" name="" type="hidden" value="">
                            <input type="text" class="form-control" name="dia_chi" placeholder="Nhập địa chỉ cụ thể" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Miêu tả phòng trọ:</label>
                        </td>

                        <td>
                            <textarea class="form-control" name= "mota" placeholder="Mô tả chi tiết" id="" cols="30" rows="10"
                                required></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Giá Phòng / tháng</label>
                        </td>
                        <td>
                            <input class="form-control" type="text" name="gia" placeholder="nhập giá" id="gia" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Giá nước / tháng</label>
                        </td>
                        <td>
                            <input class="form-control" type="text" name="gia_nuoc" placeholder="Nhập giá nước"
                                id="gia_nuoc" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Giá điện / tháng</label>
                        </td>
                        <td>
                            <input class="form-control" type="text" name="gia_dien" placeholder="Nhập giá điện"
                                id="gia_dien" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Diện tích</label>
                        </td>
                        <td>
                            <input class="form-control" type="text" name="dientich" id="dien_tich"
                                placeholder="Nhập diện tích" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label> Ảnh nhà trọ</label>
                        </td>
                        <td>
                           
                            <input type="file" id="imageInput" name="images[]" multiple accept="image/*" required>
                            <div id="previewImages"></div>
                        </td>

                    </tr>

                    <tr>
                        <td>
                            <label>Loại phòng</label>
                        </td>
                        <td>

                            <select class="form-control" id="select" name="type" required>
                                <option>---------Chọn loại nhà trọ---------</option>
                                @foreach($loai as $l)
                                <option value="{{ $l->id }}">{{ $l->name }}</option>
                                @endforeach

                            </select>
                        </td>
                    </tr>
                    <tr>

                        <td colspan="3">
                            <button class="btn btn-success py-1" type="submit" name="submit">Submit</button>
                        </td>
                    </tr>

                </table>
            </form>

        </section>
        <div class="col-sm-2">

        </div>
    </div>
    <script>
        $(document).ready(function() {
            initializeAddressFields();
        });
    </script>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            setupImagePreview();
        });
    </script> --}}
    





    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('imageInput');
            const previewImages = document.getElementById('previewImages');
            imageInput.addEventListener('change', function(event) {
                previewImages.innerHTML = '';
                const files = event.target.files;
                for (const file of files) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.width = '70px'; // Đặt chiều rộng là 70px
                        img.style.height = '80px'; // Đặt chiều cao là 80px
                        img.style.marginRight = '10px';
                        previewImages.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("imageForm").addEventListener("submit", function(event) {
                var giaInput = document.getElementById("gia");
                var giaNuocInput = document.getElementById("gia_nuoc");
                var giaDienInput = document.getElementById("gia_dien");
                var dientichInput = document.getElementById('dien_tich')
                var content = document.getElementById('content')
                // Clear previous error messages
                clearErrorMessages();
                // Validate giá, giá nước, and giá điện to ensure they are numbers
                if (!validateNumberField(giaInput.value)) {
                    displayErrorMessage(giaInput, "Giá phải là một số.");
                    event.preventDefault(); // Prevent form submission
                    return false;
                }
                if (content.value == '') {
                    displayErrorMessage(giaInput, "Không được để trống");
                    event.preventDefault(); // Prevent form submission
                    return false;
                }
                if (!validateNumberField(giaNuocInput.value)) {
                    displayErrorMessage(giaNuocInput, "Giá nước phải là một số.");
                    event.preventDefault(); // Prevent form submission
                    return false;
                }
                if (!validateNumberField(giaDienInput.value)) {
                    displayErrorMessage(giaDienInput, "Giá điện phải là một số.");
                    event.preventDefault(); // Prevent form submission
                    return false;
                }
                if (!validateNumberField(dientichInput.value)) {
                    displayErrorMessage(dientichInput, "Diện tích phải là một số.");
                    event.preventDefault(); // Prevent form submission
                    return false;
                }
                // If all validations pass, allow form submission
                return true;
            });

            function validateNumberField(value) {
                return !isNaN(parseFloat(value)) && isFinite(value);
            }

            function displayErrorMessage(inputElement, message) {
                var errorElement = document.createElement("div");
                errorElement.classList.add("text-danger");
                errorElement.innerText = message;
                inputElement.parentNode.insertBefore(errorElement, inputElement.nextSibling);
            }

            function clearErrorMessages() {
                var errorMessages = document.querySelectorAll(".text-danger");
                errorMessages.forEach(function(errorMessage) {
                    errorMessage.parentNode.removeChild(errorMessage);
                });
            }
        });
    </script>

    @endsection