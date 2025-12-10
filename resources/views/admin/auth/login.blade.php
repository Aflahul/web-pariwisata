<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
</head>

<body class="bg-light">


    <div class="container-fluid">
        <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">


                <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                    <h3 class="text-center mb-3">Login Admin</h3>


                    @if ($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif


                    <form method="POST" action="{{ route('admin.login.process') }}">
                        @csrf


                        <div class="form-floating mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                            <label>Email</label>
                        </div>


                        <div class="form-floating mb-4">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                            <label>Password</label>
                        </div>


                        <button class="btn btn-primary py-3 w-100 mb-4">Login</button>
                    </form>


                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
