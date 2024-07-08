@extends('administrator.layouts.app')


@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="row pt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Donasi</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('form.update.donasi', $donasi->id) }}"
                                enctype="multipart/form-data">
                                @method('put')
                                @csrf

                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <input id="deskripsi" type="text"
                                        class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi"
                                        placeholder="deskripsi Jenis Arsip" value="{{ $donasi->deskripsi }}">
                                    @error('deskripsi')
                                        <div id="deskripsi" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nominal">Nominal</label>
                                    <input id="nominal" type="text"
                                        class="form-control @error('nominal') is-invalid @enderror" name="nominal"
                                        placeholder="nominal" value="{{ $donasi->nominal }}">
                                    @error('nominal')
                                        <div id="nominal" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="file" class="form-label">file</label>
                                    <input type="file" class="form-control" id="file" name="file"
                                        placeholder="{{ $donasi->file ? $donasi->file : 'Tidak ada file yang diunggah' }}"
                                        value="{{ $donasi->file }}">
                                    @error('file')
                                        <div id="file" class="form-file">{{ $message }}</div>
                                    @enderror

                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        Update Donasi
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
