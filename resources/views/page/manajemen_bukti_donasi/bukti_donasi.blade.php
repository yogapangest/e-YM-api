@extends('admin.admin_master')

@section('title')
    <title>Bukti Donasi | e-YM</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }} ">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
@endsection

@section('admin')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row pt-2">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Bukti Donasi</h4>
                                {{-- @foreach ($dataDonasi as $donasi)
                                    <div>
                                        <a href="{{ route('index.view.datadonasi') }}">{{ $donasi->nama }}</a>
                                    </div>
                                @endforeach --}}
                                <div class="card-header-form">
                                    <form>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
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
                                            <th>Tanggal</th>
                                            <th>Nominal</th>
                                            <th>Deskripsi</th>
                                            <th>Bukti Transfer</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                        <tr>

                                            <td>1</td>
                                            <td>24 Maret 2024</td>
                                            <td>500.000</td>
                                            <td>Pahala untuk almarhum keluarga saya</td>
                                            <td><i class="fas fa-file"></i></td>
                                            <td class="align-middle">
                                                <div class="d-flex justify-content-center">
                                                    <!-- Menggunakan flexbox untuk membuat ikon sejajar -->
                                                    <a href="#" class="btn btn-primary ml-2">
                                                        <!-- Gunakan class ml-2 untuk margin kiri -->
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-danger ml-2">
                                                        <!-- Gunakan class ml-2 untuk margin kiri -->
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </div>
                                            </td>

                                        </tr>
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
