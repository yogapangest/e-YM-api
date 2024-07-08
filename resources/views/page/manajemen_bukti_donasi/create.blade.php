@extends('administrator.layouts.app')


@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">

            <div class="row pt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tambah Bukti Donasi</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('index.store.bukti') }}" enctype="multipart/form-data">
                                @csrf


                                <div class="form-group">
                                    <label for="tanggal" class="form-label">Taggal</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal">
                                    @error('taggal')
                                        <div id="tanggal" class="form-tanggal"></div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nominal" class="form-label">Nominal</label>
                                    <input type="text" class="form-control" id="nominal" name="nominal">
                                    @error('nominal')
                                        <div id="nominal" class="form-nominal"></div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <input type="text" class="form-control" id="deskripsi" name="deskripsi">
                                    @error('deskripsi')
                                        <div id="deskripsi" class="form-deskripsi"></div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="file" class="form-label">file</label>
                                    <input type="file" class="form-control" id="file" name="file">
                                    @error('file')
                                        <div id="file" class="form-file"></div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="datadonasi_id">Donasi</label>
                                    <select id="datadonasi_id"
                                        class="form-control @error('datadonasi_id') is-invalid @enderror"
                                        name="datadonasi_id">
                                        <option value="" selected disabled>Pilih Donasi</option>
                                        @foreach ($datadonasis as $data)
                                            <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('datadonasi_id')
                                        <div id="datadonasi_id" class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        Tambah Arsip
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
