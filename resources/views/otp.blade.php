<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi OTP - Telkom Akses</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
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

        /* LEFT SIDE IMAGE + OVERLAY */
        .left-side {
            position:relative;
            height:100vh;
            background:url('{{ asset("images/telkom.jpeg") }}') no-repeat center center/cover;
            display:flex;
            align-items:center;
            justify-content:flex-start;
            color:#fff;
            transition: all 0.5s ease;
        }

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

        .left-content {
            position:relative;
            z-index:2;
            text-align:left;
            padding-left:80px;
            padding-right:40px;
            max-width:550px;
            animation: slideInLeft 1s ease forwards;
            opacity:0;
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

        /* RIGHT SIDE CENTERING OTP CARD */
        .right-side {
            display:flex;
            align-items:center;
            justify-content:center;
            height:100vh;
        }

        /* OTP CARD */
        .otp-card {
            background:#fff;
            border-left:6px solid #d90429;
            border-radius:20px;
            padding:40px;
            width:100%;
            max-width:420px;
            box-shadow:0 10px 30px rgba(255, 255, 255, 0.1);
            animation: fadeIn 1s ease forwards;
            opacity:0;
        }

        .otp-card h4 {
            font-weight:700;
            color:#d90429;
        }

        .otp-card .form-label {
            font-weight:500;
        }

        .otp-card input.form-control {
            border-radius:10px;
            padding:12px 15px;
            border:1px solid #d1d1d1;
            font-size:16px;
            transition: all 0.3s;
        }

        .otp-card input.form-control:focus {
            border-color:#d90429;
            box-shadow:0 0 0 0.2rem rgba(217,4,41,0.2);
        }

        .btn-verify {
            background:#d90429;
            border:none;
            border-radius:10px;
            font-weight:600;
            padding:12px;
            transition: all 0.3s;
            color:white;
        }

        .btn-verify:hover {
            background:#b00322;
        }

        .timer {
            text-align:center;
            margin-top:15px;
            font-weight:600;
            color:#d90429;
            font-size:16px;
        }

        @media(max-width:992px){
            .left-side { display:none; }
            .right-side { height:auto; padding:40px 20px; }
        }

        /* Animations */
        @keyframes slideInLeft {
            0% { transform: translateX(-50px); opacity:0; }
            100% { transform: translateX(0); opacity:1; }
        }

        @keyframes fadeIn {
            0% { opacity:0; transform: translateY(20px);}
            100% { opacity:1; transform: translateY(0);}
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="container-fluid h-100">
        <div class="row h-100">

            <!-- LEFT IMAGE -->
            <div class="col-lg-7 p-0">
                <div class="left-side">
                    <div class="left-content">
                        <h1>e-Office Pemberkasan</h1>
                        <p>Sistem Administrasi Internal<br>PT Telkom Akses</p>
                    </div>
                </div>
            </div>

            <!-- RIGHT OTP -->
            <div class="col-lg-5 right-side">
                <div class="otp-card">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/telkom-akses-seeklogo.png') }}" class="brand-logo" alt="Telkom Akses" style="height:90px;">
                        <p class="text-muted small">Masukkan OTP yang dikirim ke email Anda</p>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('otp.verify') }}" id="otpForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Kode OTP</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                                <input type="text" name="otp" class="form-control" maxlength="6" required placeholder="6 digit kode">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-verify w-100" id="verifyBtn">
                            <i class="bi bi-check-circle me-2"></i> Verifikasi
                        </button>
                    </form>

                    <div class="timer" id="timer">02:00</div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Script Countdown OTP -->
<script>
    let timeLeft = 120;
    const timerElement = document.getElementById('timer');
    const verifyBtn = document.getElementById('verifyBtn');

    const countdown = setInterval(() => {
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;
        timerElement.textContent = `${minutes}:${seconds}`;
        timeLeft--;

        if(timeLeft < 0){
            clearInterval(countdown);
            timerElement.textContent = "OTP Expired";
            verifyBtn.disabled = true;
            verifyBtn.classList.add('btn-secondary');
        }
    }, 1000);
</script>

</body>
</html>
