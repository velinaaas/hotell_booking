@extends('layouts.master')

@push('style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush

@section('main')
    <div class="container mt-4">
        <div class="row">
            <!-- Card per Kamar Tersedia -->
            @foreach ($kamar as $item)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->nama_kamar }}</h5>
                            <p class="card-text">
                                Stok Tersedia: <strong>{{ $item->sisa }}</strong><br>
                                Booking dalam Progres: <strong>{{ $item->booking }}</strong>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endpush
