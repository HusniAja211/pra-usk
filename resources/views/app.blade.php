<!doctype html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>Home | Gradient Able Dashboard Template</title>
    <!-- [Meta] -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description"
        content="Gradient Able is trending dashboard template made using Bootstrap 5 design framework. Gradient Able is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies." />
    <meta name="keywords"
        content="Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard" />
    <meta name="author" content="codedthemes" />

    @include('inc.head')
    <style>
    body {
        /* Warna latar belakang yang tidak menyilaukan */
        background-color: #f1f5f9 !important; 
        color: #334155;
    }

    /* Sidebar dengan warna putih bersih agar kontras dengan body */
    .pc-sidebar {
        background: #ffffff !important;
        border-right: 1px solid #e2e8f0 !important;
    }

    /* Beri sedikit warna pada teks sidebar agar tidak membosankan */
    .pc-sidebar .pc-link {
        color: #64748b;
        font-weight: 500;
    }

    /* Menu aktif dengan aksen biru yang tegas tapi elegan */
    .pc-sidebar .pc-item.active > .pc-link {
        background: #2563eb !important; /* Biru solid */
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        border-radius: 8px;
    }

    
</style>
</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-header="header-1" data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true"
    data-pc-direction="ltr" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ Sidebar Menu ] start -->
    @include('inc.sidebar')
    <!-- [ Sidebar Menu ] end -->
    <!-- [ Header Topbar ] start -->
    <header class="pc-header">
        <div class="m-header">
            <a href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : route('user.dashboard')}}" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                <img src="{{ asset('template/dist/assets/images/logo-white.svg') }}" alt="logo image" class="logo-lg" />
            </a>
        </div>
        @vite(['resources/js/app.js'])
        @include('inc.navbar')
    </header>
    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-md-12 col-xl-12">
                    @yield('content')
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- [ Main Content ] end -->
    @include('inc.footer')

    @include('inc.js')

</body>
<!-- [Body] end -->

</html>
