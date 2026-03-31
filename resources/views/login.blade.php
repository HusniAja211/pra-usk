<!doctype html>
<html lang="en">
<head>
    <title>Login | AkuDatang</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('template/dist/assets/css/style.css') }}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('template/dist/assets/css/style-preset.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/dist/assets/fonts/tabler-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/dist/assets/fonts/fontawesome.css') }}" />

    <style>
        /* Global Reset to Monochrome Blue */
        body {
            background-color: #f8faff !important;
            font-family: 'Poppins', sans-serif;
        }

        .auth-main.v1 {
            background: radial-gradient(circle at 10% 20%, rgba(37, 99, 235, 0.05) 0%, rgba(255, 255, 255, 1) 90.2%) !important;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(37, 99, 235, 0.06); /* Soft Blue Shadow */
        }

        .form-control {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 18px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .btn-primary {
            background-color: #2563eb !important;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #1d4ed8 !important;
            transform: translateY(-1px);
            box-shadow: 0 8px 15px rgba(37, 99, 235, 0.2);
        }

        .text-blue-600 { color: #2563eb !important; }
        
        .avtar.bg-social-outline {
            background: #fff;
            border: 1px solid #e2e8f0;
            color: #64748b;
            transition: all 0.2s;
        }

        .avtar.bg-social-outline:hover {
            border-color: #2563eb;
            color: #2563eb;
            background: #eff6ff;
        }

        .saprator span {
            background: #fff;
            padding: 0 15px;
            color: #94a3b8;
            font-size: 0.85rem;
        }
    </style>
</head>

<body>
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <div class="auth-main v1">
        <div class="auth-wrapper">
            <div class="auth-form">
                <div class="card my-5">
                    <div class="card-body p-4 p-sm-5">
                        <div class="text-center">
                            <img src="{{ asset('template/dist/assets/images/logo-dark.svg') }}" alt="logo" class="img-fluid mb-4" style="max-height: 45px;" />
                            <h4 class="f-w-600 mb-1">Selamat Datang Kembali</h4>
                            <p class="mb-4 text-muted small">Belum punya akun? <a href="{{ route('register.create') }}" class="text-blue-600 fw-bold">Daftar sekarang</a></p>
                        </div>

                        <form action="{{ route('login.store') }}" method="post">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="form-label small fw-500 text-muted">Alamat Email</label>
                                <input type="email" class="form-control" placeholder="nama@email.com" name="email" required />
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label small fw-500 text-muted">Kata Sandi</label>
                                <input type="password" class="form-control" placeholder="Masukkan kata sandi" name="password" required />
                            </div>

                            <div class="d-flex mt-1 justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rememberMe" checked />
                                    <label class="form-check-label text-muted small" for="rememberMe">Ingat saya</label>
                                </div>
                                <a href="#" class="text-secondary small fw-500">Lupa Password?</a>
                            </div>

                            <div class="d-grid mt-4">
                                @auth
                                    <a href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : route('user.dashboard') }}"
                                        class="btn btn-outline-primary py-2">Masuk ke Dashboard</a>
                                @endauth
                                
                                @guest
                                    <button type="submit" class="btn btn-primary shadow-sm py-2">Masuk Sekarang</button>
                                @endguest
                            </div>
                        </form>

                        <div class="saprator my-4">
                            <span>Atau masuk dengan</span>
                        </div>

                        <div class="text-center">
                            <div class="d-flex justify-content-center gap-3">
                                <a href="#" class="avtar avtar-s rounded-circle bg-social-outline">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="avtar avtar-s rounded-circle bg-social-outline">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="avtar avtar-s rounded-circle bg-social-outline">
                                    <i class="fab fa-google"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('template/dist/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('template/dist/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('template/dist/assets/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session("success") }}',
                timer: 3000,
                showConfirmButton: false,
                background: '#fff',
                color: '#1e293b',
                iconColor: '#2563eb'
            });
        </script>
    @endif
</body>
</html>