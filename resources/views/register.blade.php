<!doctype html>
<html lang="en">
<head>
    <title>Register | AkuDatang</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('template/dist/assets/css/style.css') }}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('template/dist/assets/css/style-preset.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/dist/assets/fonts/tabler-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/dist/assets/fonts/fontawesome.css') }}" />

    <style>
        /* Custom Monochrome Blue Overrides */
        body {
            background-color: #f8faff !important; /* Biru sangat pucat */
            font-family: 'Poppins', sans-serif;
        }

        .auth-main.v1 {
            background: radial-gradient(circle at top right, #e0eaff 0%, #f8faff 100%) !important;
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.08); /* Shadow biru tipis */
        }

        .form-control {
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .btn-primary {
            background-color: #2563eb !important;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #1d4ed8 !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .text-blue-primary {
            color: #2563eb;
        }

        .input-group-text {
            background-color: transparent;
            border-color: #e2e8f0;
        }

        /* Styling Social Buttons agar Monokrom */
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

        .error-text {
            font-size: 0.75rem;
            color: #dc2626;
            margin-top: 4px;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div class="auth-main v1">
        <div class="auth-wrapper">
            <div class="auth-form">
                <div class="card my-5">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="{{ asset('template/dist/assets/images/logo-dark.svg') }}" alt="logo" class="img-fluid mb-4" style="max-height: 40px;" />
                            <h4 class="f-w-600 mb-1">Daftar Akun Baru</h4>
                            <p class="mb-4 text-muted small">Sudah punya akun? <a href="{{ route('login.index') }}" class="text-blue-primary fw-bold">Masuk di sini</a></p>
                        </div>

                        <form action="{{ route('register.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label small fw-500">Nama Depan</label>
                                        <input type="text" class="form-control" placeholder="Contoh: Budi" name="first_name" value="{{ old('first_name') }}" required />
                                        @error('first_name') <div class="error-text text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label small fw-500">Nama Belakang</label>
                                        <input type="text" class="form-control" placeholder="Susanto" name="last_name" value="{{ old('last_name') }}" />
                                        @error('last_name') <div class="error-text">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label small fw-500">Alamat Email</label>
                                <input type="email" class="form-control" placeholder="nama@email.com" name="email" required value="{{ old('email') }}" />
                                @error('email') <div class="error-text">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label small fw-500">Alamat Rumah</label>
                                <input type="text" class="form-control" placeholder="Jl. Raya No. 123" name="address" required value="{{ old('address') }}" />
                                @error('address') <div class="error-text">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label small fw-500">Latitude</label>
                                <input type="text" class="form-control" placeholder="Contoh: -6.200000" name="latitude" required value="{{ old('latitude') }}" />
                                @error('latitude') <div class="error-text">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label small fw-500">Longitude</label>
                                <input type="text" class="form-control" placeholder="Contoh: 106.816666" name="longitude" required value="{{ old('longitude') }}" />
                                @error('longitude') <div class="error-text">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label small fw-500">Kata Sandi</label>
                                <input type="password" class="form-control" placeholder="Minimal 8 karakter" name="password" required />
                                @error('password') <div class="error-text">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label small fw-500">Konfirmasi Sandi</label>
                                <input type="password" class="form-control" placeholder="Ulangi kata sandi" name="confirm_password" required />
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="terms" checked required />
                                <label class="form-check-label text-muted small" for="terms">
                                    Saya setuju dengan <a href="#" class="text-blue-primary">Syarat & Ketentuan</a> yang berlaku.
                                </label>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary shadow-sm">Buat Akun</button>
                            </div>
                        </form>

                        <div class="saprator my-4">
                            <span class="text-muted small">Atau daftar dengan</span>
                        </div>

                        <div class="text-center">
                            <ul class="list-inline mx-auto mt-3 mb-0">
                                <li class="list-inline-item">
                                    <a href="#" class="avtar avtar-s rounded-circle bg-social-outline">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="avtar avtar-s rounded-circle bg-social-outline">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="avtar avtar-s rounded-circle bg-social-outline">
                                        <i class="fab fa-google"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('template/dist/assets/js/plugins/bootstrap.min.js') }}"></script>
</body>
</html>