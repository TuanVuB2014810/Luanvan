@extends('layouts.app')

@section('content')
<div class="container  row pt-3">
    <div class="col-sm-4">

    </div>
    <section class="col-sm-6">
    
    <h2 class="py-3 text-center">Chỉnh sửa thông tin bài đăng</h2>
    <form action="" id="imageForm" method="post" class="form-inline mb-3" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <table class="table table_cus">
            <tr>
                <td>Nội dung bài viết</td>
                <td>:</td>
                <td>
                    <input class="form-control" type="text" value="{{ $post->content }}"  name="content" placeholder="Nội dung bài đăng" required>
                </td>
               
            </tr>
            <tr>
                <td>
                    <label>Tên phòng trọ:</label>
                </td>
                <td>:</td>
                <td>
                    <input class="form-control" type="text" value="{{ $post->name }}"  name="name" placeholder="Thêm tên nhà ở" required >
                </td>
              
            </tr>
            <tr>
                <td>
                    <label>Số phòng :</label>
                </td>
                <td>:</td>
                <td>
                  <input type="number" min="1" class="form-control" value="{{ $post->sophong }}" type="text" value="1" name="sl" placeholder="số phòng" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Địa chỉ: </label>
                </td>
                <td>:</td>
                <td>
                    <select name="calc_shipping_provinces" class="form-control" required="">
                        <option selected value="{{ $post->tinh }}">{{ $post->tinh }}</option>
                      </select>
                      <select name="calc_shipping_district"  class="form-control" required="">
                        <option selected value="{{ $post->huyen }}">{{ $post->huyen }}</option>

                      </select>
                      <input class="billing_address_1" name="" type="hidden" value="">
                      <input class="billing_address_2" name="" type="hidden" value="">
                      <input type="text" value="{{ $post->dia_chi }}" class="form-control" name="dia_chi"
                      placeholder="Nhập địa chỉ cụ thể" required>
                   
                </td>
               
            </tr>
            <tr>
                <td>
                    <label>Miêu tả phòng trọ:</label>
                </td>
                <td>:</td>
                    
                <td>
                 <textarea class="form-control" name="desc" id="" placeholder="Mô tả chi tiết" cols="30" rows="10" required> {{ $post->mota }}</textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Giá</label>
                </td>
                <td>:</td>
                <td>
                    <input class="form-control"  type="text" value="{{ $post->gia }}" id="gia" name="gia" placeholder="Vui lòng nhập giá" required >
                </td>
            </tr>
            <tr>
                <td>
                    <label>Giá nước</label>
                </td>
                <td>:</td>
                <td>
                    <input class="form-control"  type="text" value="{{ $post->gia_nuoc }}" id="gia_nuoc" name="gia_nuoc" placeholder="Vui lòng nhập giá" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Giá điện</label>
                </td>
                <td>:</td>
                <td>
                    <input class="form-control"  type="text" value="{{ $post->gia_dien }}" id="gia_dien" name="gia_dien" placeholder="Vui lòng nhập giá" required >
                </td>
            </tr>
            <tr>
                <td>
                    <label>Diện tích</label>
                </td>
                <td>:</td>
                <td>
                <input class="form-control"  type="text" value="{{ $post->dientich }}"name="dientich" placeholder="Vui lòng nhập diện tích nhà trọ" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label> Ảnh nhà trọ</label>
                </td>
                <td>:</td>
                <td>
                   
                    <input type="file" id="imageInput" name="images[]" multiple accept="image/*">
                    <div id="previewImages"></div>
                </td>
            </tr>
           
            <tr>
                <td>
                    <label>Loại phòng</label>
                </td>
                <td>:</td>
                <td>
                    <select class="form-control"  id="select" name="type" >
                        <option selected value="{{ $post->loai_phong }}">{{ $post->tenloai }}</option>
                        @foreach($loai as $l)
                            <option value="{{ $l->id }}">{{ $l->name }}</option>
                        @endforeach 
                    </select>
                </td>
            </tr>
            <tr>
               
                <td colspan="3">
                <button class="btn btn-success py-1"  type="submit" name="submit">Submit</button>
                </td>
            </tr>
           
        </table>
    </form>
</section>
<div class="col-sm-2">

</div>
</div>
<script src='https://cdn.jsdelivr.net/gh/vietblogdao/js/districts.min.js'></script>
<script>
//<![CDATA[
if (address_2 = localStorage.getItem('address_2_saved')) {
  $('select[name="calc_shipping_district"] option').each(function() {
    if ($(this).text() == address_2) {
      $(this).attr('selected', '');
    }
  });
  $('input.billing_address_2').attr('value', address_2);
}
if (district = localStorage.getItem('district')) {
  $('select[name="calc_shipping_district"]').html(district);
  $('select[name="calc_shipping_district"]').on('change', function() {
    var target = $(this).children('option:selected');
    target.attr('selected', '');
    $('select[name="calc_shipping_district"] option').not(target).removeAttr('selected');
    address_2 = target.text();
    $('input.billing_address_2').attr('value', address_2);
    district = $('select[name="calc_shipping_district"]').html();
    localStorage.setItem('district', district);
    localStorage.setItem('address_2_saved', address_2);
  });
}
$('select[name="calc_shipping_provinces"]').each(function() {
  var $this = $(this);
  var stc = '';
  c.forEach(function(tinh) {
    stc += '<option value="' + tinh + '">' + tinh + '</option>';
  });
  $this.html('<option value="">Tỉnh / Thành phố</option>' + stc);
  
  if (address_1 = localStorage.getItem('address_1_saved')) {
    $('select[name="calc_shipping_provinces"] option').each(function() {
      if ($(this).text() == address_1) {
        $(this).attr('selected', '');
      }
    });
    $('input.billing_address_1').attr('value', address_1);
  }

  $this.on('change', function(i) {
    i = $this.children('option:selected').index() - 1;
    var str = '';
    var r = $this.val();
    if (r != '') {
      arr[i].forEach(function(el) {
        // Lấy tên huyện mà không bao gồm từ "Huyện"
        var districtName = el.replace('Huyện ', ''); // Loại bỏ từ "Huyện" nếu có
        str += '<option value="' + el + '">' + districtName + '</option>';
        $('select[name="calc_shipping_district"]').html('<option value="">Quận / Huyện</option>' + str);
      });
      var address_1 = $this.children('option:selected').text();
      var district = $('select[name="calc_shipping_district"]').html();
      localStorage.setItem('address_1_saved', address_1);
      localStorage.setItem('district', district);
      
      $('select[name="calc_shipping_district"]').on('change', function() {
        var target = $(this).children('option:selected');
        target.attr('selected', '');
        $('select[name="calc_shipping_district"] option').not(target).removeAttr('selected');
        var address_2 = target.text();
        $('input.billing_address_2').attr('value', address_2);
        district = $('select[name="calc_shipping_district"]').html();
        localStorage.setItem('district', district);
        localStorage.setItem('address_2_saved', address_2);
      });
    } else {
      $('select[name="calc_shipping_district"]').html('<option value="">Quận / Huyện</option>');
      district = $('select[name="calc_shipping_district"]').html();
      localStorage.setItem('district', district);
      localStorage.removeItem('address_1_saved', address_1);
    }
  });
});
//]]>
</script>


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
                    img.style.width = '70px';  // Đặt chiều rộng là 70px
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
            // Clear previous error messages
            clearErrorMessages();

            // Validate giá, giá nước, and giá điện to ensure they are numbers
            if (!validateNumberField(giaInput.value)) {
                displayErrorMessage(giaInput, "Giá phải là một số.");
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
    