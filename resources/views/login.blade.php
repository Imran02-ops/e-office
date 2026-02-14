<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Telkom Akses</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            margin:0;
            font-family:'Poppins',sans-serif;
            height:100vh;
            overflow:hidden;
        }

        .login-wrapper {
            height:100vh;
        }

        /* LEFT SIDE BACKGROUND */
        .left-side {
            position:relative;
            height:100vh;
            background:url('{{ asset("images/telkom.jpeg") }}')
                    no-repeat center center/cover;
            display:flex;
            align-items:center;
            justify-content:flex-start; /* DIGESER KE KIRI */
            color:#fff;
        }

        /* OVERLAY GRADASI MERAH (TIDAK DIUBAH) */
        .left-side::before {
            content:"";
            position:absolute;
            inset:0;
            background:linear-gradient(
                120deg,
                rgba(217,4,41,0.85),
                rgba(155,0,0,0.75)
            );
            z-index:1;
        }

        /* TEXT DI ATAS OVERLAY */
        .left-content {
            position:relative;
            z-index:2;
            text-align:left;
            padding-left:80px;   /* Lebih ke kiri */
            padding-right:40px;
            max-width:550px;
        }

        .left-content h1 {
            font-size:42px;
            font-weight:700;
        }

        .left-content p {
            font-size:18px;
            margin-top:20px;
            line-height:1.6;
        }

        /* RIGHT SECTION CENTERING */
        .right-side {
            display:flex;
            align-items:center;
            justify-content:center;
            height:100vh;
        }

        /* LOGIN BOX */
        .login-box {
            background:#fff;
            border-left:6px solid #d90429;
            border-radius:20px;
            padding:40px;
            width:100%;
            max-width:420px;
            box-shadow:0 10px 30px rgba(0,0,0,0.1);
        }

        .btn-login {
            background:#d90429;
            border:none;
        }

        .btn-login:hover {
            background:#b00322;
        }

        .form-control:focus {
            border-color:#d90429;
            box-shadow:0 0 0 0.2rem rgba(217,4,41,0.2);
        }

        .brand-logo {
            height:90px;
            width:auto;
            margin-bottom:20px;
        }

        @media(max-width:992px){
            .left-side{
                display:none;
            }
            .right-side{
                height:auto;
                padding:40px 20px;
            }
        }
    </style>
</head>
<body>

<div class="login-wrapper">
<div class="container-fluid h-100">
<div class="row h-100">

    <!-- LEFT IMAGE SECTION -->
    <div class="col-lg-7 p-0">
        <div class="left-side">
            <div class="left-content">
                <h1>e-Office Pemberkasan</h1>
                <p>
                    Sistem Administrasi Internal<br>
                    PT Telkom Akses
                </p>
            </div>
        </div>
    </div>

    <!-- RIGHT LOGIN SECTION -->
    <div class="col-lg-5 right-side">
        <div class="login-box">

            <div class="text-center">
                <img src="{{ asset('images/telkom-akses-seeklogo.png') }}"
                    class="brand-logo" alt="Telkom Akses">
                <p class="text-muted small">Masuk ke sistem e-Office</p>
            </div>

            <form class="mt-4" method="POST" action="{{ route('login.post') }}">
                @csrf

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email"
                            name="email"
                            class="form-control"
                            placeholder="admin@telkomakses.co.id"
                            required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password"
                            name="password"
                            class="form-control"
                            placeholder="••••••••"
                            required>
                    </div>
                </div>

                <button type="submit"
                        class="btn btn-login text-white w-100 py-2">
                    Login
                </button>
            </form>

            <div class="text-center mt-4">
                <small class="text-muted">
                    © 2026 PT Telkom Akses
                </small>
            </div>

        </div>
    </div>

</div>
</div>
</div>

</body>
</html>
