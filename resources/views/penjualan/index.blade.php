@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')

<div class="container py-4">
    @include('layouts.navbar')

    @if(session('errors'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <div>{{ session('errors') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-2 border-bottom gap-3">
        <div>
            <h2 class="fw-bold text-dark m-0">Halaman Penjualan</h2>
            <p class="text-muted mb-0 small">Kelola dan pantau seluruh riwayat transaksi penjualan toko Anda.</p>
        </div>
        <div>
            <a href="{{ route('penjualan.create') }}" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm fw-semibold">
                <i class="bi bi-plus-lg me-1"></i> Tambah Penjualan
            </a>
        </div>
    </div>

    <form action="{{ route('penjualan.index') }}" method="GET" class="mb-4">
        <div class="input-group" style="max-width: 400px;">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}" 
                class="form-control bg-light" 
                placeholder="Search nama kasir"
            >
            <button class="btn btn-outline-secondary px-4 fw-semibold" type="submit">
                <i class="fa-solid fa-magnifying-glass me-1"></i> Cari
            </button>
        </div>
    </form>

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary small text-uppercase">
                    <tr>
                        <th scope="col" class="py-3 ps-4" style="width: 50px;">#</th>
                        <th scope="col" class="py-3">Tanggal Transaksi</th>
                        <th scope="col" class="py-3">Kasir</th>
                        <th scope="col" class="py-3">Total Pembayaran</th>
                        <th scope="col" class="py-3 text-center">Metode Pembayaran</th>
                        <th scope="col" class="py-3 text-center">Status</th>
                        <th scope="col" class="py-3 text-center" style="width: 220px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                   @forelse ($sales as $sale)
                   <tr>
                        <th scope="row" class="ps-4 text-muted font-monospace fw-normal">{{ ($sales->firstItem() + $loop->index) }}</th>
                        <td class="fw-medium text-dark">
                            <i class="bi bi-clock-history text-muted me-1"></i>
                            {{ $sale->created_at->translatedFormat('d-m-Y H:i:s')}}
                        </td>
                        <td class="fw-medium text-secondary">{{ $sale->user->name }}</td>
                        <td class="fw-bold text-success">Rp.{{number_format($sale->total_pembayaran)}}</td>
                        <td class="text-center">
                            @php
                                $metode = strtoupper($sale->metode_pembayaran);
                            @endphp
                            @if ($metode == 'CASH')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-2"><i class="bi bi-cash me-1"></i> CASH</span>
                            @elseif($metode == 'QRIS')
                                <span class="badge bg-warning-subtle text-dark border border-warning-subtle px-2 py-1 rounded-2"><i class="bi bi-qr-code-scan me-1"></i> QRIS</span>
                            @else
                                <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1 rounded-2"><i class="bi bi-bank me-1"></i> {{ $sale->metode_pembayaran }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @php
                                $status = strtoupper($sale->status);
                            @endphp
                            @if ($status == 'COMPLETED')
                                <span class="badge bg-success px-2 py-1 rounded-2" style="min-width: 100px; display: inline-block;"><i class="bi bi-check-circle me-1"></i> COMPLETED</span>
                            @elseif($status == 'OPEN')
                                <span class="badge bg-warning text-dark px-2 py-1 rounded-2" style="min-width: 100px; display: inline-block;"><i class="bi bi-hourglass-split me-1"></i> OPEN</span>
                            @else
                                <span class="badge bg-secondary px-2 py-1 rounded-2" style="min-width: 100px; display: inline-block;">{{ $sale->status }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex align-items-center justify-content-center gap-1">
                                @if ($status == 'OPEN')
                                    {{-- Status OPEN: Lanjutkan & Hapus --}}
                                    @can('view', $sale)
                                    <a href="{{ route('penjualan.edit', $sale) }}" class="btn btn-sm btn-warning text-dark fw-semibold px-2 py-1 d-inline-flex align-items-center">
                                        <i class="bi bi-pencil-square me-1"></i> Lanjutkan
                                    </a>
                                    @endcan

                                    @can('delete', $sale)
                                    ||
                                    <form action="{{ route('penjualan.destroy', $sale) }}" method="POST" class="d-inline m-0 p-0">
                                        @csrf
                                        @method('DELETE')
                                      <button class="btn btn-sm btn-outline-secondary fw-semibold px-2 py-1 d-inline-flex align-items-center" onclick="return confirm('Apakah anda yakin akan menghapus penjualan ini?')">
                                           Hapus
                                    </button>
                                    </form>
                                    @endcan
                                @else
                                    {{-- Status Selain OPEN (misal COMPLETED): Hanya Detail --}}
                                    <a href="{{ route('penjualan.show', $sale) }}" class="btn btn-sm btn-primary fw-semibold px-2 py-1 d-inline-flex align-items-center">
                                        <i class="bi bi-eye me-1"></i> Detail
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-receipt-cutoff fs-1 d-block mb-2 text-secondary"></i>
                            Data Tidak Ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($sales->hasPages())
            <div class="card-footer bg-white border-top py-3 px-4 d-flex justify-content-between align-items-center">
                <div class="small text-muted">
                    Showing {{ $sales->firstItem() }} to {{ $sales->lastItem() }} of {{ $sales->total() }} results
                </div>
                <div>
                    {{ $sales->links() }}
                </div>
            </div>
        @endif
    </div>

</div>

@endsection