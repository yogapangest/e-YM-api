@extends('administrator.layouts.app')

@section('title')
    <title>Data User | e-YM</title>
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
                                <h4>Data User</h4>
                                <div class="card-header-form">
                                    <div class="ml-auto mb-2">
                                        <a href="{{ route('index.create.datauser') }}" style="float: right;"
                                            class="btn btn-round btn-primary mb-3">Tambah</a>
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
                                            <th>Nama</th>
                                            {{-- <th>Username</th> --}}
                                            <th>Email</th>
                                            <th>Alamat</th>
                                            <th>No Telephone</th>
                                            <th>Rekap Donasi</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>

                                        <tbody>
                                            @if ($users->count() > 0)
                                                @foreach ($users as $data)
                                                    <tr>
                                                        <td class="align-middle">{{ $loop->iteration }}</td>
                                                        <td class="align-middle">{{ $data->name }}</td>
                                                        {{-- <td class="align-middle">{{ $data->username }}</td> --}}
                                                        <td class="align-middle">{{ $data->email }}</td>
                                                        <td class="align-middle">{{ $data->alamat }}</td>
                                                        <td class="align-middle">{{ $data->telephone }}</td>
                                                        <td class="align-middle">
                                                            <a class="btn btn-primary btn-sm"
                                                                href="{{ route('form.show.donasi_admin', ['user_id' => $data->id]) }}">
                                                                Rekap
                                                            </a>
                                                        </td>
                                                        <td class="align-middle">
                                                            <div class="d-flex justify-content-center">
                                                                <!-- Menggunakan flexbox untuk membuat ikon sejajar -->
                                                                <a href="{{ route('index.edit.datauser', $data->id) }}"
                                                                    class="btn btn-primary ml-2">
                                                                    <!-- Gunakan class ml-2 untuk margin kiri -->
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                {{-- <a href="{{ route('index.destroy.datauser', $data->id) }}"
                                                                    class="btn btn-danger ml-2">
                                                                    <!-- Gunakan class ml-2 untuk margin kiri -->
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </a> --}}

                                                                <a href="#" class="btn btn-danger ml-2"
                                                                    onclick="confirmDelete({{ $data->id }})">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </a>

                                                                <form id="delete-form-{{ $data->id }}"
                                                                    action="{{ route('index.destroy.datauser', $data->id) }}"
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
                                                    <td class="text-center" colspan="8">Data Donatur Belum Ada</td>
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
