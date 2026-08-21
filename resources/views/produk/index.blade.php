@extends('layouts.app')

@section('title', 'Produk')

@section('content')

    <div class="container py-4">
        @include('layouts.navbar')

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    <div class="fw-medium">{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom gap-3">
            <div>
                <h1 class="fw-bold text-dark m-0 d-flex align-items-center gap-2">
                    <i class="bi bi-box-seam-fill text-primary"></i> Halaman Produk
                </h1>
                <p class="text-muted mb-0 small">Kelola katalog produk, harga, serta ketersediaan stok toko Anda secara
                    mudah.</p>
            </div>
            <div>
                @can('create', App\Models\Produk::class)
                    <a href="{{ route('produk.create') }}"
                        class="btn btn-primary px-4 py-2 rounded-3 shadow-sm fw-semibold d-inline-flex align-items-center gap-2">
                        <i class="bi bi-plus-lg"></i>Tambah Produk
                    </a>
                @endcan
            </div>
        </div>

        <form action="{{ route('produk.index') }}" method="GET" class="mb-4">
        <div class="input-group" style="max-width: 400px;">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}" 
                class="form-control bg-light" 
                placeholder="Search nama produk"
            >
            <button class="btn btn-outline-secondary px-4 fw-semibold" type="submit">
                <i class="fa-solid fa-magnifying-glass me-1"></i> Cari
            </button>
        </div>
    </form>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary small text-uppercase">
                        <tr>
                            <th scope="col" class="py-3 ps-4" style="width: 50px;">#</th>
                            <th scope="col" class="py-3">User</th>
                            <th scope="col" class="py-3 text-center" style="width: 90px;">Foto</th>
                            <th scope="col" class="py-3">Nama</th>
                            <th scope="col" class="py-3">Jenis Produk</th>
                            <th scope="col" class="py-3">Harga Beli</th>
                            <th scope="col" class="py-3">Harga Jual</th>
                            <th scope="col" class="py-3 text-center" style="width: 120px;">Stok</th>
                            <th scope="col" class="py-3 text-center" style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <th scope="row" class="ps-4 text-muted font-monospace fw-normal small">
                                    {{ $products->firstItem() + $loop->index }}
                                </th>
                                <td class="fw-medium text-secondary small">
                                    <i class="bi bi-person-circle me-1 text-muted"></i>
                                    {{ $product->user->name }}
                                </td>
                                <td class="text-center">
                                    @if ($product->foto && Storage::disk('public')->exists($product->foto))
                                        <img src="{{ asset('storage/' . $product->foto) }}" width="50" height="50"
                                            class="rounded-3 border object-fit-cover shadow-sm">
                                    @else
                                        <div class="bg-light text-muted border rounded-3 d-flex align-items-center justify-content-center mx-auto shadow-sm"
                                            style="width: 50px; height: 50px;">
                                            <i class="bi bi-image text-secondary fs-5"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="fw-semibold text-dark">{{ $product->nama }}</td>
                                <td>
                                    <span
                                        class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-2 py-1 small">
                                        {{ $product->jenis->nama_jenis ?? '-' }} </span>
                                </td>
                                <td class="text-nowrap text-secondary font-monospace small">
                                    Rp {{ number_format($product->harga_beli, 0, ',', '.') }}
                                </td>
                                <td class="text-nowrap fw-bold text-success font-monospace">
                                    Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    @if ($product->stok <= 0)
                                        <span
                                            class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-1"><i
                                                class="bi bi-x-circle me-1"></i> Habis</span>
                                    @elseif($product->stok <= 5)
                                        <span
                                            class="badge bg-warning-subtle text-dark border border-warning-subtle rounded-pill px-3 py-1"><i
                                                class="bi bi-exclamation-triangle me-1"></i> {{ $product->stok }}</span>
                                    @else
                                        <span
                                            class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1"><i
                                                class="bi bi-check-circle me-1"></i> {{ $product->stok }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex align-items-center justify-content-center gap-1">
                                        @can('update', $product)
                                            <a href="{{ route('produk.edit', $product) }}"
                                                class="btn btn-sm btn-warning text-dark fw-semibold px-2 py-1 d-inline-flex align-items-center">
                                                <i class="bi bi-pencil-square me-1"></i> Edit
                                            </a>
                                        @endcan

                                        @can('delete', $product)
                                            <form action="{{ route('produk.destroy', $product) }}" method="POST"
                                                class="d-inline m-0 p-0">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="btn btn-sm btn-danger fw-semibold px-2 py-1 d-inline-flex align-items-center"
                                                    onclick="return confirm('Apakah anda yakin akan menghapus produk ini?')">
                                                    <i class="bi bi-trash me-1"></i> Hapus
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="bi bi-box-seam display-6 d-block mb-2 text-secondary opacity-50"></i>
                                    Data tidak tersedia.
                                </td>
                            </tr>
                        @endempty
                    </tbody>
                </table>
            </div>

            @if ($products->hasPages())
                <div class="card-footer bg-white border-top py-3 px-4 d-flex justify-content-between align-items-center">
                    <div class="small text-muted">
                        Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }}
                        results
                    </div>
                    <div>
                        {{ $products->links() }}
                    </div>
                </div>
            @endif
        </div>

    </div>

@endsection