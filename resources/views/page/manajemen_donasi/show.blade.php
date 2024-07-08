@extends('administrator.layouts.app')

@section('title')
    <title>Daftar Donasi | e-YM</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
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
                                <h4>Daftar Donasi {{ $user->name }}</h4>
                                <div class="card-header-form">
                                    <div class="ml-auto mb-2">
                                        <a href="{{ route('form.create.donasi_admin', ['user_id' => $user->id]) }}"
                                            style="float: right;" class="btn btn-round btn-primary mb-3">Tambah</a>
                                    </div>
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
                                            <th>Deskripsi</th>
                                            <th>Nominal</th>
                                            <th>File</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                        <tbody>
                                            @if ($donasi->count() > 0)
                                                @foreach ($donasi as $data)
                                                    <tr>
                                                        <td class="align-middle">{{ $loop->iteration }}</td>
                                                        <td class="align-middle">{{ $data->created_at }}</td>
                                                        <td class="align-middle">{{ $data->deskripsi }}</td>
                                                        <td class="align-middle">
                                                            Rp. {{ number_format(floatval($data->nominal), 0, ',', '.') }}
                                                        </td>
                                                        <td class="align-middle">
                                                            @if ($data->file)
                                                                <a href="{{ asset('storage/donasis/' . $data->file) }}">
                                                                    <i class="fas fa-file-alt" style="font-size: 20px;"></i>
                                                                </a>
                                                            @else
                                                                <i>No file uploaded.</i>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">
                                                            <div class="d-flex justify-content-end">
                                                                <a href="{{ route('form.edit.donasi_admin', $data->id) }}"
                                                                    class="btn btn-primary ml-2">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                {{-- <a href="{{ route('form.destroy.donasi_admin', $data->id) }}"
                                                                    class="btn btn-danger ml-2">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </a> --}}

                                                                <a href="#" class="btn btn-danger ml-2"
                                                                    onclick="confirmDelete({{ $data->id }})">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </a>

                                                                <form id="delete-form-{{ $data->id }}"
                                                                    action="{{ route('form.destroy.donasi_admin', $data->id) }}"
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
                                                    <td class="text-center" colspan="6">Daftar Donasi Belum Ada</td>
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
