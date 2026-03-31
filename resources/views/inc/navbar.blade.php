{{-- <div class="header-wrapper">
    <div class="me-auto pc-mob-drp">
        <ul class="list-unstyled d-flex align-items-center mb-0">
            <li class="pc-h-item">
                <a href="#" class="pc-head-link" id="sidebar-hide"><i class="ph ph-list" style="font-size: 1.5rem;"></i></a>
            </li>
            <li class="pc-h-item d-none d-md-block">
                <form class="pc-header-search ms-3" method="GET" action="{{ route('user.dashboard') }}">
                    <div class="input-group bg-light rounded-pill px-3 py-1">
                        <input type="search" name="search" class="form-control border-0 bg-transparent shadow-none" placeholder="Cari buku..." />
                    </div>
                </form>
            </li>
        </ul>
    </div> --}}
    
    <div class="ms-auto">
        <ul class="list-unstyled">
            <li class="dropdown pc-h-item">
                <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#">
                    <img src="{{ asset('template/dist/assets/images/user/avatar-2.jpg') }}" alt="user" class="user-avtar border" />
                </a>
                <div class="dropdown-menu dropdown-menu-end shadow border-0">
                    <div class="p-3 border-bottom mb-2">
                        <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                        <small class="text-muted">{{ auth()->user()->email }}</small>
                    </div>
                    <a href="#" class="dropdown-item"><i class="ph ph-user me-2"></i> Profile</a>
                    <a href="#" class="dropdown-item"><i class="ph ph-gear me-2"></i> Settings</a>
                    <div class="dropdown-divider"></div>
                    <form action="{{ route('logout') }}" method="post" class="px-2">
                        @csrf
                        <button type="submit" class="btn btn-label-danger btn-sm w-100 text-start">
                            <i class="ph ph-power me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</div>