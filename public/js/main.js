

function initializeSliders() {
    // Khởi tạo slider cho giá
    var priceSlider = document.getElementById('slider');
    var minPriceField = $('#minPrice');
    var maxPriceField = $('#maxPrice');

    noUiSlider.create(priceSlider, {
        start: [0, 30000000], // Khởi tạo giá trị theo đơn vị 100,000
        connect: true,
        range: {
            'min': 0,
            'max': 30000000
        },
        step: 100000, // Bước tăng giá trị
        tooltips: [true, true],
        format: {
            to: function(value) {
                return Math.round(value).toLocaleString('en-US', { maximumFractionDigits: 0 });
            },
            from: function(value) {
                return value.replace(/,/g, '');
            }
        }
    });

    priceSlider.noUiSlider.on('update', function(values, handle) {
        if (handle === 0) {
            var val = parseInt(values[0].replace(/,/g, ''));
            minPriceField.val(val);
        } else {
            var val = parseInt(values[1].replace(/,/g, ''));
            maxPriceField.val(val);
        }
    });

    // Khởi tạo slider cho diện tích
    var areaSlider = document.getElementById('slider_dt');
    var minAreaField = $('#mindt');
    var maxAreaField = $('#maxdt');

    noUiSlider.create(areaSlider, {
        start: [10, 100], 
        connect: true,
        range: {
            'min': 10,
            'max': 100
        },
        step: 1, // Bước tăng giá trị
        tooltips: [true, true]
    });

    areaSlider.noUiSlider.on('update', function(values, handle) {
        if (handle === 0) {
            minAreaField.val(values[0]);
        } else {
            maxAreaField.val(values[1]);
        }
    });
}



function validatePasswordForm() {
    var currentPassword = document.getElementById('currentPassword').value;
    var newPassword = document.getElementById('newPassword').value;
    var confirmPassword = document.getElementById('confirmPassword').value;
    var errorContainer = document.getElementById('errorContainer');

    // Reset error messages
    errorContainer.innerHTML = '';

    // Validate current password
    if (currentPassword.trim() === '') {
        displayError('Mật khẩu hiện tại không được để trống.');
        return false;
    }

    // Validate new password
    if (newPassword.trim() === '') {
        displayError('Mật khẩu mới không được để trống.');
        return false;
    }

    // Validate password length
    if (newPassword.length < 8) {
        displayError('Mật khẩu mới phải có ít nhất 8 ký tự.');
        return false;
    }

    // Validate confirm password
    if (confirmPassword.trim() === '') {
        displayError('Vui lòng nhập lại mật khẩu.');
        return false;
    }

    // Validate password match
    if (newPassword !== confirmPassword) {
        displayError('Xác nhận mật khẩu không khớp.');
        return false;
    }

    return true;
}

function displayError(message) {
    var errorElement = document.createElement('div');
    errorElement.classList.add('error-message');
    errorElement.textContent = message;
    errorContainer.appendChild(errorElement);
}

function initializeAddressFields() {
    // Code xử lý việc chọn tỉnh/thành phố và quận/huyện
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
                    var districtName = el.replace('Huyện ', '');
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

    // Code xử lý việc gán giá trị đã lưu từ localStorage vào các trường input
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
}


