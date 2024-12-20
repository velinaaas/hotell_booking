@extends('layouts.master')
@push('style')
    <style>
        /* Atur tabel agar responsive */
        .table-container {
            /* overflow-x: auto; */
            /* Tambahkan scroll horizontal jika konten melebihi lebar */
        }

        /* Atur lebar kolom agar rapi */
        .table th,
        .table td {
            white-space: nowrap;
            /* Jangan wrap teks */
            overflow: hidden;
            /* Sembunyikan teks yang melebihi kolom */
            /* text-overflow: ellipsis; */
            /* Tambahkan "..." untuk teks panjang */
            max-width: 150px;
            /* Atur lebar maksimal kolom */
        }

        /* Tambahkan padding untuk tampilan lebih bagus */
        .table td {
            vertical-align: middle;
        }

        /* Atur action button agar tetap rapi */
        .table td .btn {
            padding: 5px 10px;
            font-size: 12px;
        }

        body {
            margin: 0;
            /* Hilangkan margin global */
            overflow-x: hidden;
            /* Pastikan tidak ada scroll horizontal di body */
        }
    </style>

    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
@endpush
@section('main')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="components-preview wide-md mx-auto">
                        <div class="nk-block-head nk-block-head-sm">
                            <div class="nk-block-between">
                                <div class="nk-block-head-content">
                                    <h4 class="nk-block-title">Booking</h4>
                                </div>
                                <div class="nk-block-head-content">
                                    <a href="{{ route('booking.add') }}"
                                        class="btn btn-primary d-none d-md-inline-flex float-right"><em
                                            class="icon ni ni-plus"></em><span>Tambah</span></a>
                                </div>
                            </div>
                        </div><!-- .nk-block-head -->
                        <div class="nk-block">
                            <div class="card card-bordered card-preview p-5">
                                <div class="card-inner">
                                    <div class="table-container">
                                        @php
                                            $date = \Carbon\Carbon::now()->format('Ymd');
                                            $level = Auth::user()->role;
                                        @endphp
                                        <table id="dataTable" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Kode Pemesanan</th>
                                                    <th>Guest</th>
                                                    <th>Nama Kamar</th>
                                                    <th>Jumlah</th>
                                                    <th>Tanggal Check In</th>
                                                    <th>Tanggal Check Out</th>
                                                    @if ($level == 1)
                                                        <th>Customer</th>
                                                    @endif
                                                    <th>Status</th>
                                                    <th>Pembayaran</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($booking as $item)
                                                    <tr>
                                                        <td>{{ $item->kd_pemesanan }}</td>
                                                        <td>{{ $item->guest }}</td>
                                                        <td>{{ $item->nama_kamar }}</td>
                                                        <td>{{ $item->jumlah }}</td>
                                                        <td>{{ $item->tanggal_checkin }}</td>
                                                        <td>{{ $item->tanggal_checkout }}</td>

                                                        @if ($level == 1)
                                                            <td>{{ $item->name }}</td>
                                                        @endif

                                                        <td>{{ $item->status }}</td>
                                                        <td>{{ $item->metode_pembayaran }}</td>
                                                        <td>
                                                            @if ($level == 0)
                                                                @if ($item->status == 'onProgress' && \Carbon\Carbon::parse($item->tanggal_checkin)->format('Ymd') > $date)
                                                                    <form
                                                                        action="{{ route('booking.cancel', $item->id_booking) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Cancel</button>
                                                                    </form>
                                                                @else
                                                                    -
                                                                @endif
                                                            @else
                                                                @if ($item->status == 'onProgress')
                                                                    <form
                                                                        action="{{ route('booking.done', $item->id_booking) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Selesai</button>
                                                                    </form>
                                                                @else
                                                                    -
                                                                    vro

                                                                @endif
                                                            @endif




                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div><!-- .card-preview -->
                        </div><!-- .nk-block -->
                        <!-- nk-block -->
                    </div>
                </div>
            </div><!-- .components-preview -->
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                scrollX: true, // Tambahkan scroll horizontal
                autoWidth: false,
                responsive: true, // Nonaktifkan auto-width
                columnDefs: [{
                        targets: [0, 1, 2, 8, 9],
                        width: '150px'
                    }, // Atur lebar kolom spesifik
                    {
                        targets: '_all',
                        className: 'text-center'
                    } // Rata tengah semua kolom
                ]
            });
        });
    </script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> --}}

    {{-- <script>
        document.getElementById('save-sales-btn').addEventListener('click', function(event) {
            event.preventDefault();

            Swal.bindClickHandler();

            Swal.mixin({
                toast: true
            }).bindClickHandler("alert-confirm");
            Swal.fire({
                title: 'Do you want to save the changes?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: 'No',
                customClass: {
                    actions: 'my-actions',
                    cancelButton: 'order-1 right-gap',
                    confirmButton: 'order-2',
                    denyButton: 'order-3',
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Saved!', '', 'success')
                    document.getElementById('customer-form').submit(); // submit the form
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            });
        });
    </script> --}}

    {{-- <script>
        document.getElementById('save-customer-btn').addEventListener('click', function(event) {
            event.preventDefault();

            Swal.mixin({
                toast: true
            }).fire({
                title: 'Do you want to save the changes?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: 'No',
                customClass: {
                    actions: 'y-actions',
                    cancelButton: 'order-1 right-gap',
                    confirmButton: 'order-2',
                    denyButton: 'order-3',
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Saved!', '', 'uccess')
                    document.getElementById('customer-form').submit(); // submit the form
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            }).catch((error) => {
                console.error('Error submitting form:', error);
            });
        });
    </script> --}}
@endpush
