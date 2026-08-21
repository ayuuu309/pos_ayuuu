@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="container py-4">
    @include('layouts.navbar')

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom">
        <div>
            <h3 class="fw-bold text-dark m-0 d-flex align-items-center gap-2">
                <i class="fa-solid fa-users-gear text-primary"></i> Halaman Users
            </h3>
            <p class="text-muted small m-0 mt-1">Kelola data pengguna, hak akses, dan manajemen akun sistem.</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary fw-semibold px-4 shadow-sm">
                <i class="fa-solid fa-plus me-1"></i>+Tambah User
            </a>
        </div>
    </div>

    {{-- Form Search --}}
    <form action="{{ route('admin.users') }}" method="GET" class="mb-4">
        <div class="input-group" style="max-width: 400px;">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}" 
                class="form-control bg-light" 
                placeholder="Search username or email"
            >
            <button class="btn btn-outline-secondary px-4 fw-semibold" type="submit">
                <i class="fa-solid fa-magnifying-glass me-1"></i> Cari
            </button>
        </div>
    </form>

    {{-- Tabel Data Users --}}
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-muted text-uppercase small">
                    <tr>
                        <th scope="col" class="py-3 px-4 text-center" style="width: 60px;">#</th>
                        <th scope="col" class="py-3 px-4">Name</th>
                        <th scope="col" class="py-3 px-4">Email</th>
                        <th scope="col" class="py-3 px-4 text-center">Role</th>
                        <th scope="col" class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="py-3 px-4 text-center text-muted fw-medium">
                            {{ $users->firstItem() + $loop->index }}
                        </td>
                        <td class="py-3 px-4 fw-bold text-dark">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 38px; height: 38px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span>{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-secondary">
                            <i class="fa-regular fa-envelope me-1 text-muted"></i>
                            {{ $user->email }}
                        </td>
                        <td class="py-3 px-4 text-center">
                            @if($user->role->name == 'admin')
                                <span class="badge bg-purple-subtle text-purple border border-purple-subtle rounded-pill px-3 py-2 text-capitalize" style="background-color: #f3e8ff; color: #7e22ce;">
                                    <i class="fa-solid fa-user-shield me-1"></i> {{ $user->role->name }}
                                </span>
                            @else
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2 text-capitalize">
                                    <i class="fa-solid fa-user me-1"></i> {{ $user->role->name }}
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-center">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-warning fw-semibold px-3">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit Akun
                                </a>
                                
                                <span class="text-muted opacity-50">||</span>

                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger fw-semibold px-3" onclick="return confirm('Yakin hapus user ini?')">
                                        <i class="fa-solid fa-trash-can me-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-light border-0 py-3 px-4">
            {{ $users->links() }}
        </div>
    </div>

</div>
@endsection