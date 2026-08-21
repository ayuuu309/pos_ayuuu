<nav class="navbar navbar-expand-lg rounded-4 mb-4 px-3 py-2 shadow-sm border" 
     style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;">
  <div class="container-fluid">
    {{-- Brand / Logo SMKN 4 & Nama POS --}}
    <a class="navbar-brand text-dark fw-bold me-4 d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
      <img src="{{ asset('images/logo smkn4.png') }}" alt="Logo SMKN 4" style="height: 36px; width: auto; object-fit: contain;"> 
      <span>AyuMart</span>
    </a>

    {{-- Toggle Mobile --}}
    <button class="navbar-toggler border-0 text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    {{-- Nav Links --}}
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1">
        <li class="nav-item">
          <a class="nav-link px-3 py-1.5 rounded-3 fw-medium {{ Request::is('dashboard') ? 'bg-primary text-white active' : 'text-dark' }}" 
             href="{{ route('dashboard') }}"> <i class="bi bi-house-fill"></i>
             Dashboard
          </a>
        </li>

        @can('viewAny', App\Models\User::class)
        <li class="nav-item">
          <a class="nav-link px-3 py-1.5 rounded-3 fw-medium {{ Request::is('admin/users*') ? 'bg-primary text-white active' : 'text-dark' }}" 
             href="{{ route('admin.users') }}"> <i class="bi bi-people-fill"></i>
             Users
          </a>
        </li>
        @endcan

        {{-- Menu Produk --}}
        <li class="nav-item">
          <a class="nav-link px-3 py-1.5 rounded-3 fw-medium {{ Request::is('produk*') ? 'bg-primary text-white active' : 'text-dark' }}" 
             href="{{ route('produk.index') }}"> <i class="bi bi-box-fill"></i>
             Produk
          </a>
        </li>

        {{-- Menu Jenis (Ditambahkan Di Sini) --}}
        <li class="nav-item">
          <a class="nav-link px-3 py-1.5 rounded-3 fw-medium {{ Request::is('jenis*') ? 'bg-primary text-white active' : 'text-dark' }}" 
             href="{{ route('jenis.index') }}"> <i class="bi bi-tags-fill"></i>
          Jenis
          </a>
        </li>

        {{-- Menu Penjualan --}}
        <li class="nav-item">
          <a class="nav-link px-3 py-1.5 rounded-3 fw-medium {{ Request::is('penjualan*') ? 'bg-primary text-white active' : 'text-dark' }}" 
             href="{{ route('penjualan.index') }}"> <i class="bi bi-cart-fill"></i>
             Penjualan
          </a>
        </li>

        {{-- Menu Tentang --}}
        <li class="nav-item">
            <a class="nav-link px-3 py-1.5 rounded-3 fw-medium {{ Request::is('tentang') ? 'bg-primary text-white active' : 'text-dark' }}" 
                href="{{ route('tentang') }}">  <i class="bi bi-info-circle-fill me-2"></i>Tentang
           </a>
        </li>
      </ul>

      {{-- Informasi User Login & Form Logout --}}
      <div class="d-flex align-items-center gap-3">
        @auth
          @php
            // Logika mengambil inisial nama
            $words = explode(' ', Auth::user()->name);
            $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
          @endphp

          <div class="d-flex align-items-center gap-2 me-2">
            <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center shadow-sm" 
                 style="width: 38px; height: 38px; font-size: 14px;">
              {{ $initials }}
            </div>

            <div class="d-flex flex-column text-start" style="line-height: 1.2;">
              <span class="fw-bold text-dark" style="font-size: 14px;">
                {{ Auth::user()->name }}
              </span>
              <span class="text-secondary text-capitalize" style="font-size: 11px;">
                {{ Auth::user()->role->name ?? (is_string(Auth::user()->role) ? Auth::user()->role : 'Staff') }}
              </span>
            </div>
          </div>
        @endauth

        {{-- Form Logout --}}
        <form class="d-flex m-0" action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-danger fw-semibold px-3 py-1.5 rounded-3 border-0 shadow-sm" style="background-color: #ef4444;">
            Logout
          </button>
        </form>
      </div>

    </div>
  </div>
</nav>