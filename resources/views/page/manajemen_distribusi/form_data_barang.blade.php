@extends('administrator.layouts.app')


@section('title')
    <title>Daftar Data Barang | e-YM</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }} ">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-rHy3mowRf3m1OPbK6UVDu+OIaNRszJ8z7XeR+AhB0mEgwZOVtBijqUMs7Wjg87YQzPKdJU+zjlz4hJOuxYYplg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row pt-2">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">

                                <h4>Tambah Data Barang</h4>

                                <div class="card-header-form ">
                                    <form>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary mb-6"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <form action="{{ route('index.store.distribusibarang', $distribusi_id) }}" method="POST">
                                @csrf

                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Nama Barang</th>
                                                <th>Volume</th>
                                                <th>Satuan</th>
                                                <th>Harga Satuan</th>
                                                <th>Jumlah</th>
                                            </tr>

                                            <tbody>
                                                @php
                                                    $no = 1;
                                                @endphp

                                                @foreach ($data_barang as $data)
                                                    <tr>
                                                        <td class="d-flex justify-content-center align-items-center">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="data_barangs[]" id="{{ $data->id }}"
                                                                value="{{ $data->id }}">
                                                        </td>

                                                        <td class="align-middle">{{ $data->nama_barang }}</td>
                                                        <td class="align-middle">{{ $data->volume }}</td>
                                                        <td class="align-middle">{{ $data->satuan }}</td>
                                                        <td class="align-middle">
                                                            {{ number_format($data->harga_satuan, 0, ',', '.') }}</td>
                                                        <td class="align-middle">
                                                            {{ number_format($data->jumlah, 0, ',', '.') }}</td>

                                                    </tr>
                                                    @php
                                                        $no++;
                                                    @endphp
                                                @endforeach

                                            </tbody>

                                        </table>
                                    </div>
                                </div>

                                <div class="row d-flex justify-content-start mt-3 mb-3">
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 ml-3">
                                        <button type="submit" class="btn btn-primary">
                                            Tambah
                                        </button>
                                        <a href="{{ route('index.view.distribusibarang', $distribusi_id) }}"
                                            class="btn btn-cancel">Back</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection

@section('script')
    {{-- Datatable JS --}}
    <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>

    {{-- Modal JS --}}
    <script src="{{ asset('assets/js/page/bootstrap-modal.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Event handler untuk menangani saat form disubmit
            $('form').submit(function(event) {
                // Cek jumlah checkbox yang dipilih
                var checkedCheckboxes = $('input[name="data_barangs[]"]:checked');
                if (checkedCheckboxes.length === 0) {
                    // Tampilkan pesan error jika tidak ada checkbox yang dipilih
                    alert('Pilih setidaknya satu data barang.');
                    event.preventDefault(); // Menghentikan pengiriman form
                }
            });
        });
    </script>
@endsection
