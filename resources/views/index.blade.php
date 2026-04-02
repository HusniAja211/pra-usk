<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AkuDatang Bookstore</title>
    
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800" rel="stylesheet" />
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { background-color: #f8faff; font-family: 'Poppins', sans-serif; color: #1e293b; overflow-x: hidden; }
        
        /* Monokrom Biru Palette */
        .bg-primary { background-color: #2563eb; }
        .text-primary { color: #2563eb; }
        .border-primary { border-color: #2563eb; }
        .bg-primary-light { background-color: #eff6ff; }
        
        /* Soft Shadows & Transitions */
        .premium-shadow { box-shadow: 0 10px 40px -10px rgba(37, 99, 235, 0.1); }
        .hover-lift { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-lift:hover { transform: translateY(-8px); box-shadow: 0 20px 25px -5px rgba(37, 99, 235, 0.15); }
        
        /* Custom Decorative Shapes */
        .blob-bg {
            position: absolute; width: 500px; height: 500px;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
            z-index: -1; animation: morph 8s ease-in-out infinite;
        }

        @keyframes morph {
            0%, 100% { border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; }
            34% { border-radius: 70% 30% 50% 50% / 30% 30% 70% 70%; }
            67% { border-radius: 100% 60% 60% 100% / 100% 100% 60% 60%; }
        }

        /* Modal Style */
        .modal {
            display: none; position: fixed; z-index: 1000;
            left: 0; top: 0; width: 100%; height: 100%;
            background-color: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(8px);
        }
    </style>
</head>
<body class="antialiased selection:bg-blue-200 selection:text-blue-900">

    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-blue-50/50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 flex items-center justify-between h-20">
            
            <div class="flex items-center gap-3 cursor-pointer">
                <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center premium-shadow">
                    <i class="ph ph-books text-white text-2xl"></i>
                </div>
                <span class="text-2xl font-extrabold tracking-tight text-slate-800">AkuDatang<span class="text-primary">.</span></span>
            </div>

            <div class="flex gap-4 items-center">
                @auth
                    <a href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : route('user.dashboard') }}" 
                    class="px-6 py-2.5 bg-primary-light text-primary text-sm rounded-full font-bold hover:bg-primary hover:text-white transition premium-shadow">
                    Dashboard
                    </a>
                @else
                    <a href="{{ route('login.create') }}" 
                    class="text-sm font-semibold text-slate-600 hover:text-primary transition px-2">
                    Masuk
                    </a>
                    <a href="{{ route('register.create') }}" 
                    class="px-6 py-2.5 bg-primary text-white text-sm rounded-full font-bold hover:bg-blue-700 transition premium-shadow hover-lift">
                    Daftar
                    </a>
                @endauth
            </div>
            
        </div>
    </nav>

    <header class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="relative z-10 text-center lg:text-left">
                <div class="inline-block px-4 py-1.5 bg-blue-50 rounded-full text-primary text-xs font-bold tracking-wider uppercase mb-6 border border-blue-100">
                    📚 Toko Buku Digital Terlengkap
                </div>
                <h1 class="text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight mb-6">
                    Temukan Jendela <br><span class="text-primary">Dunia Anda.</span>
                </h1>
                <p class="text-lg text-slate-500 mb-8 max-w-lg mx-auto lg:mx-0 leading-relaxed">
                    Lebih dari 10.000+ koleksi buku pilihan menanti untuk dibaca. Beli buku original dengan harga terbaik dan pengiriman super cepat.
                </p>
            </div>
            
            <div class="relative hidden lg:flex justify-center items-center">
                <div class="blob-bg"></div>
                <div class="relative z-10 grid grid-cols-2 gap-6 translate-x-8">
                    <div class="bg-white p-4 rounded-2xl premium-shadow hover-lift mt-12">
                        <div class="w-40 h-56 bg-blue-50 rounded-lg flex items-center justify-center border border-blue-100">
                            <i class="ph ph-book-open text-6xl text-blue-200"></i>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-2xl premium-shadow hover-lift -translate-y-8">
                        <div class="w-48 h-64 bg-primary rounded-lg flex flex-col items-center justify-center text-white p-6 text-center">
                            <i class="ph ph-star text-4xl mb-2 text-yellow-300"></i>
                            <h3 class="font-bold">Bestseller</h3>
                            <p class="text-xs text-blue-200 mt-2">Pilihan pembaca minggu ini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="py-16 bg-white border-y border-blue-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-primary-light text-primary flex items-center justify-center shrink-0">
                        <i class="ph ph-shield-check text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-lg mb-1">100% Buku Original</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">Garansi uang kembali jika buku yang Anda terima bajakan atau tidak resmi.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-primary-light text-primary flex items-center justify-center shrink-0">
                        <i class="ph ph-tag text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-lg mb-1">Harga Lebih Hemat</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">Dapatkan diskon eksklusif dan promo menarik setiap harinya hanya di sini.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-primary-light text-primary flex items-center justify-center shrink-0">
                        <i class="ph ph-truck text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-lg mb-1">Pengiriman Aman</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">Buku dipacking tebal dan dikirim ke seluruh Indonesia dengan aman.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="buku-populer" class="py-24 max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4">
            <div>
                <span class="text-primary font-bold text-sm tracking-wider uppercase">Koleksi Pilihan</span>
                <h2 class="text-3xl font-extrabold text-slate-800 mt-2">Buku Terpopuler</h2>
            </div>
            <a href="#" class="text-sm font-bold text-slate-600 hover:text-primary transition flex items-center gap-2 bg-white px-5 py-2.5 rounded-full border border-slate-200 hover:border-primary">
                Lihat Semua Koleksi <i class="ph ph-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($books as $book)
            <div class="bg-white rounded-3xl p-5 border border-blue-50 premium-shadow hover-lift cursor-pointer" onclick="openModal('{{ $book->id }}')">
                <div class="aspect-3/4 bg-blue-50 rounded-2xl mb-5 overflow-hidden relative group">
                    @if($book->image)
                        <img src="{{ asset('storage/' . $book->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-blue-200">
                            <i class="ph ph-image text-6xl"></i>
                        </div>
                    @endif
                    <div class="absolute top-4 left-4 bg-white/95 backdrop-blur px-4 py-1.5 rounded-full text-[10px] font-extrabold text-primary uppercase tracking-widest shadow-sm">
                        {{ $book->category->name ?? 'Umum' }}
                    </div>
                </div>
                
                <h3 class="font-bold text-slate-800 text-lg mb-1 line-clamp-1">{{ $book->title }}</h3>
                <p class="text-xs font-medium text-slate-400 mb-5 flex items-center gap-1.5">
                    <i class="ph ph-pen-nib"></i> Oleh: <span class="text-slate-600">{{ $book->author }}</span>
                </p>
                
                <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                    <div>
                        <span class="text-xs text-slate-400 block mb-0.5">Harga</span>
                        <span class="text-xl font-extrabold text-slate-900">Rp{{ number_format($book->price, 0, ',', '.') }}</span>
                    </div>
                    <button class="w-12 h-12 rounded-full bg-primary-light text-primary hover:bg-primary hover:text-white transition flex items-center justify-center text-xl">
                        <i class="ph ph-shopping-cart-simple"></i>
                    </button>
                </div>
            </div>

            <div id="modal-{{ $book->id }}" class="modal flex items-center justify-center p-4 sm:p-6">
                <div class="bg-white rounded-2rem max-w-4xl w-full overflow-hidden shadow-2xl flex flex-col md:flex-row relative">
                    <button onclick="closeModal('{{ $book->id }}')" class="absolute top-4 right-4 z-10 w-10 h-10 bg-white/50 backdrop-blur rounded-full flex items-center justify-center text-slate-500 hover:text-red-500 transition">
                        <i class="ph ph-x text-xl font-bold"></i>
                    </button>
                    
                    <div class="md:w-5/12 bg-blue-50 p-8 flex items-center justify-center">
                        @if($book->image)
                            <img src="{{ asset('storage/' . $book->image) }}" class="rounded-xl premium-shadow max-h-100 w-auto">
                        @else
                            <div class="w-48 h-64 bg-white rounded-xl premium-shadow flex items-center justify-center text-blue-200">
                                <i class="ph ph-image text-4xl"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="md:w-7/12 p-8 lg:p-10 flex flex-col">
                        <span class="inline-block px-3 py-1 bg-primary-light text-primary text-xs font-bold rounded-lg w-max mb-3 uppercase tracking-wider">
                            {{ $book->category->name ?? 'Category' }}
                        </span>
                        <h2 class="text-3xl font-extrabold text-slate-900 mb-6">{{ $book->title }}</h2>
                        
                        <div class="grid grid-cols-2 gap-4 mb-6 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            <div>
                                <span class="text-xs text-slate-400 block">Penulis</span>
                                <span class="font-bold text-slate-700">{{ $book->author }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-slate-400 block">Penerbit</span>
                                <span class="font-bold text-slate-700">{{ $book->publisher }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-slate-400 block">Stok Tersedia</span>
                                <span class="font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded">{{ $book->stock }} eks</span>
                            </div>
                        </div>

                        <div class="grow">
                            <h4 class="font-bold text-slate-800 mb-2">Sinopsis</h4>
                            <p class="text-sm text-slate-500 leading-relaxed line-clamp-4">
                                {{ $book->description ?: 'Belum ada deskripsi untuk buku ini.' }}
                            </p>
                        </div>

                        <div class="flex items-center justify-between border-t border-slate-100 pt-6 mt-6">
                            <div>
                                <span class="text-xs text-slate-400 block">Total Harga</span>
                                <span class="text-3xl font-extrabold text-primary">Rp{{ number_format($book->price, 0, ',', '.') }}</span>
                            </div>
                            <button class="px-8 py-4 bg-primary text-white rounded-2xl font-bold hover:bg-blue-700 transition flex items-center gap-2 premium-shadow">
                                <a href="{{ route('login.create') }}"><i class="ph ph-shopping-cart-simple text-xl"></i> Tambah</a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 lg:px-8 mb-24">
        <div class="bg-primary rounded-3xl p-10 lg:p-16 text-center relative overflow-hidden premium-shadow">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full blur-2xl -translate-y-1/2 translate-x-1/3"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-5 rounded-full blur-xl translate-y-1/3 -translate-x-1/3"></div>
            
            <div class="relative z-10">
                <h2 class="text-3xl lg:text-4xl font-extrabold text-white mb-4">Siap untuk Petualangan Baru?</h2>
                <p class="text-blue-100 mb-8 max-w-xl mx-auto text-lg">Daftar sekarang dan dapatkan diskon 20% untuk pembelian buku pertama Anda di AkuDatang Bookstore.</p>
                <div class="flex justify-center gap-4">
                    <a href="{{ route('register.create') }}" class="px-8 py-4 bg-white text-primary font-bold rounded-full hover:bg-blue-50 transition premium-shadow">Daftar Sekarang</a>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-white border-t border-blue-50 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                            <i class="ph ph-books text-white text-xl"></i>
                        </div>
                        <span class="text-xl font-extrabold text-slate-800">AkuDatang<span class="text-primary">.</span></span>
                    </div>
                    <p class="text-slate-500 text-sm leading-relaxed max-w-sm">
                        Destinasi utama untuk menemukan buku-buku original dan berkualitas. Membuka wawasan, satu halaman setiap kalinya.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 mb-4">Tautan Singkat</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-sm text-slate-500 hover:text-primary">Tentang Kami</a></li>
                        <li><a href="#" class="text-sm text-slate-500 hover:text-primary">Katalog Buku</a></li>
                        <li><a href="#" class="text-sm text-slate-500 hover:text-primary">Cara Pembelian</a></li>
                        <li><a href="#" class="text-sm text-slate-500 hover:text-primary">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 mb-4">Hubungi Kami</h4>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-2 text-sm text-slate-500"><i class="ph ph-whatsapp-logo text-lg text-primary"></i> +62 812 3456 7890</li>
                        <li class="flex items-center gap-2 text-sm text-slate-500"><i class="ph ph-envelope-simple text-lg text-primary"></i> halo@akudatang.com</li>
                        <li class="flex items-center gap-2 text-sm text-slate-500"><i class="ph ph-map-pin text-lg text-primary"></i> Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-slate-400">© {{ date('Y') }} AkuDatang Bookstore. All rights reserved.</p>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white transition"><i class="ph ph-instagram-logo text-lg"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white transition"><i class="ph ph-twitter-logo text-lg"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white transition"><i class="ph ph-facebook-logo text-lg"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function openModal(id) {
            document.getElementById('modal-' + id).style.display = 'flex';
            document.body.style.overflow = 'hidden'; 
        }

        function closeModal(id) {
            document.getElementById('modal-' + id).style.display = 'none';
            document.body.style.overflow = 'auto'; 
        }

        // Close when clicking outside modal content
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }
        
        // Navbar blur effect on scroll
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 10) {
                nav.classList.add('shadow-sm');
            } else {
                nav.classList.remove('shadow-sm');
            }
        });
    </script>
</body>
</html>