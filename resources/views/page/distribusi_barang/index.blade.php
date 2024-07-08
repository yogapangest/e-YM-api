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
                                <h4>Daftar Data Barang : {{ $distribusi->program->nama }} -
                                    {{ \carbon\carbon::parse($distribusi->tanggal)->translatedFormat('d F Y') }}</h4>

                                <div class="card-header-form ">

                                    <div class="d-flex justify-content-end mb-3">
                                        <a href="{{ route('cetak.pdf', $distribusi_id) }}"
                                            class="btn btn-round btn-danger mb-6 mr-2">Cetak</a>
                                        <a href="{{ route('index.create.distribusibarang', $distribusi_id) }}"
                                            class="btn btn-round btn-primary">Tambah</a>
                                    </div>
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
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>Volume</th>
                                            <th>Satuan</th>
                                            <th>Harga Satuan</th>
                                            <th>Jumlah</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>

                                        <tbody>
                                            @if ($distribusi_barang->count() > 0)
                                                @foreach ($distribusi_barang as $data)
                                                    <tr>
                                                        <td class="align-middle">{{ $loop->iteration }}</td>
                                                        <td class="align-middle">{{ $data->nama_barang }}</td>
                                                        <td class="align-middle">{{ $data->volume }}</td>
                                                        <td class="align-middle">{{ $data->satuan }}</td>
                                                        <td class="align-middle">
                                                            {{ number_format($data->harga_satuan, 0, ',', '.') }}
                                                        </td>
                                                        <td class="align-middle">
                                                            {{ number_format($data->jumlah, 0, ',', '.') }}
                                                        </td>

                                                        <td class="align-middle">
                                                            <div class="d-flex justify-content-end">
                                                                <a href="{{ route('index.edit.distribusibarang', $data->id) }}"
                                                                    class="btn btn-primary ml-2">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                {{-- <a href="{{ route('index.destroy.distribusibarang', $data->id) }}"
                                                                    class="btn btn-danger ml-2">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </a> --}}

                                                                <a href="#" class="btn btn-danger ml-2"
                                                                    onclick="confirmDelete({{ $data->id }})">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </a>

                                                                <form id="delete-form-{{ $data->id }}"
                                                                    action="{{ route('index.destroy.distribusibarang', $data->id) }}"
                                                                    method="POST" style="display: none;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td class="text-center" colspan="7">Data Barang Belum Diisi</td>
                                                </tr>
                                            @endif
                                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
                                            <script src="{{ asset('js/hapus.js') }}"></script>

                                            @include('sweetalert::alert')
                                        </tbody>

                                    </table>
                                </div>
                            </div>
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
@endsection
