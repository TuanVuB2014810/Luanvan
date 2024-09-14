<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Đăng nhập Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
             background: linear-gradient(to right, rgb(192, 36, 163), rgb(19, 190, 147), rgb(0, 128, 113));
            /* background-image: url('{{ asset("public/images/nen_dang_nhap.jpg") }}'); */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            /* Thiết lập chiều cao cho phần tử */
        }

        .error {
            font-size: 18px;
            color: red;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <div class="container">
            <div class="row justify-content-around mt-5">
                <form action="{{ route('admin.logon') }}" class="col-md-6  p-3 my-3" method="post">
                    @csrf
                    @method('POST')

                    <h1 class="text-center text-uppercase text-light h3 py-3"> Đăng nhập Admin </h1>

                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="user" placeholder="User">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="pass" id="pwd" placeholder="Password">
                    </div>
                    @if(Session::get('msg'))
                    <p class="error">{{ Session::get('msg') }}</p>
                    @endif
                    <input type="submit" class="btn-danger btn btn-block" name="login" value="Đăng nhập">
                </form>
            </div>
        </div>
    </div>
</body>

</html>
