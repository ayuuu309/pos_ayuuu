@extends('layouts.app')

@section('title', 'Detail Penjualan #' . $penjualan->id)

@section('content')
<div class="container py-4">
    @include('layouts.navbar')

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-2 border-bottom gap-2">
        <div>
            <h2 class="fw-bold text-dark m-0">Penjualan #{{ $penjualan->id }}</h2>
            <p class="text-muted mb-0 small">Informasi lengkap transaksi penjualan toko.</p>
        </div>
        <div>
            <a href="{{ route('penjualan.index') }}" class="btn btn-outline-secondary px-3 py-2 rounded-3 fw-semibold">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
        <div class="row g-4">
            <div class="col-md-3">
                <span class="text-muted small d-block mb-1">Tanggal Transaksi</span>
                <h6 class="fw-bold text-dark mb-0">
                    <i class="bi bi-clock-history text-primary me-1"></i>
                    {{ $penjualan->created_at->translatedFormat('d F Y, H:i:s') }}
                </h6>
            </div>
            <div class="col-md-3">
                <span class="text-muted small d-block mb-1">Kasir</span>
                <h6 class="fw-bold text-dark mb-0">{{ $penjualan->user->name ?? '-' }}</h6>
            </div>
            <div class="col-md-3">
                <span class="text-muted small d-block mb-1">Metode Pembayaran</span>
                @php $metode = strtoupper($penjualan->metode_pembayaran); @endphp
                @if ($metode == 'CASH')
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-2"><i class="bi bi-cash me-1"></i> CASH</span>
                @elseif($metode == 'QRIS')
                    <span class="badge bg-warning-subtle text-dark border border-warning-subtle px-3 py-1 rounded-2"><i class="bi bi-qr-code-scan me-1"></i> QRIS</span>
                @else
                    <span class="badge bg-info-subtle text-info border border-info-subtle px-3 py-1 rounded-2">{{ $metode }}</span>
                @endif
            </div>
            <div class="col-md-3">
                <span class="text-muted small d-block mb-1">Total Pembayaran</span>
                <h5 class="fw-bold text-success mb-0">Rp {{ number_format($penjualan->total_pembayaran) }}</h5>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 px-4 border-bottom">
            <h6 class="fw-bold m-0 text-dark">Rincian Barang</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary small text-uppercase">
                    <tr>
                        <th scope="col" class="py-3 ps-4" style="width: 50px;">#</th>
                        <th scope="col" class="py-3">Nama Produk</th>
                        <th scope="col" class="py-3 text-center">Harga Satuan</th>
                        <th scope="col" class="py-3 text-center">Jumlah (Qty)</th>
                        <th scope="col" class="py-3 text-end pe-4">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penjualan->itemPenjualan as $item)
                    <tr>
                        <th scope="row" class="ps-4 text-muted font-monospace fw-normal">{{ $loop->iteration }}</th>
                        <td class="fw-semibold text-dark">{{ $item->produk->nama ?? 'Produk Dihapus' }}</td>
                        <td class="text-center">Rp {{ number_format($item->harga) }}</td>
                        <td class="text-center"><span class="badge bg-light text-dark border px-2 py-1">{{ $item->kuantitas }}</span></td>
                        <td class="text-end pe-4 fw-bold text-dark">Rp {{ number_format($item->subtotal) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Tidak ada rincian barang.</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <td colspan="4" class="text-end fw-bold py-3">Total Akhir:</td>
                        <td class="text-end pe-4 fw-bold text-success fs-5 py-3">Rp {{ number_format($penjualan->total_pembayaran) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection