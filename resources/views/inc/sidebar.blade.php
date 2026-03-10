<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : route('user.dashboard') }}"
                class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                <img src="{{ asset('template/dist/assets/images/logo-white.svg') }}" alt="logo image" class="logo-lg" />
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                @auth
                    <li class="pc-item">
                        <a href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : route('user.dashboard') }}"
                            class="pc-link"><span class="pc-micon"> <i class="ph ph-gauge"></i></span><span
                                class="pc-mtext">Dashboard</span></a>
                    </li>
                    @if (auth()->user()->role == 'admin')
                        {{-- ADMIN START --}}
                        <li class="pc-item">
                            <a href="{{ route('admin.member.index') }}" class="pc-link"><span class="pc-micon"> <i
                                        class="ph ph-users"></i></span><span class="pc-mtext">Members</span></a>
                        </li>
                        <li class="pc-item pc-hasmenu">
                            <a href="#!" class="pc-link"><span class="pc-micon"> <i class="ph ph-book"></i>
                                </span><span class="pc-mtext">Manage Products</span><span class="pc-arrow"><i
                                        data-feather="chevron-right"></i></span></a>
                            <ul class="pc-submenu">
                                <li class="pc-item"><a class="pc-link" href="{{ route('admin.category.index') }}"><i
                                            class="ph ph-squares-four"></i>
                                        Categories</a></li>
                                <li class="pc-item"><a class="pc-link" href="{{ route('admin.book.index') }}"><i
                                            class="ph ph-book-open"></i>
                                        Books</a></li>
                            </ul>
                        </li>
                        <li class="pc-item pc-hasmenu">
                            <a href="#!" class="pc-link"><span class="pc-micon"> <i class="ph ph-credit-card"></i>
                                </span><span class="pc-mtext">Transacrions</span><span class="pc-arrow"><i
                                        data-feather="chevron-right"></i></span></a>
                            <ul class="pc-submenu">
                                <li class="pc-item"><a class="pc-link" href="{{ route('admin.payment.index') }}"><i
                                            class="ph ph-money"></i> Payment
                                        Books</a></li>
                                <li class="pc-item"><a class="pc-link" href="{{ route('admin.cart.index') }}"><i class="ph ph-shopping-cart"></i>
                                        Carts</a></li>
                                <li class="pc-item"><a class="pc-link" href="{{ route('admin.report.index') }}"><i class="ph ph-chart-bar"></i>
                                        Reports</a></li>
                            </ul>
                        </li>
                        {{-- ADMIN END --}}
                    @elseif(auth()->user()->role == 'user')
                        {{-- USER START --}}
                        <li class="pc-item">
                            <a href="{{ route('about') }}" class="pc-link"><span class="pc-micon"> <i class="ph ph-info"></i></span><span
                                    class="pc-mtext">About Us</span></a>
                        </li>
                        <li class="pc-item">
                            <a href="https://wa.me/6285781197648" class="pc-link"><span class="pc-micon"> <i
                                        class="ph ph-chat-circle-text"></i></span><span class="pc-mtext">Contact to
                                    Admin</span></a>
                        </li>
                        <li class="pc-item">
                        <a href="{{ route('cart.index') }}" class="pc-link"><span class="pc-micon"> <i
                                        class="ph ph-chat-circle-text"></i></span><span class="pc-mtext">Cart
                                    </span></a>
                        </li>
                        <li class="pc-item">
                        </li>
                        {{-- USER END --}}
                    @endif
                @endauth

                {{-- <li class="pc-item"><a href="../other/sample-page.html" class="pc-link">
                        <span class="pc-micon">
                            <i class="ph ph-desktop"></i>
                        </span>
                        <span class="pc-mtext">Sample page</span></a></li> --}}

            </ul>
        </div>
    </div>
</nav>
