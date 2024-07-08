@extends('administrator.layouts.app')


@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">

            <div class="row pt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Arsip</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('index.update.arsip', $arsip->id) }}"
                                enctype="multipart/form-data">
                                @method('put')
                                @csrf

                                <div class="form-group">
                                    <label for="program">Program</label>
                                    <select id="programs_id" class="form-control @error('programs_id') is-invalid @enderror"
                                        name="programs_id" value="{{ $arsip->nama }}">
                                        <option value="{{ $arsip->programs_id }}">{{ $arsip->program->nama }}</option>
                                        @foreach ($programs as $data)
                                            <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('programs_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="jenisArsip">Jenis Arsip</label>
                                    <select id="jenisArsip_id"
                                        class="form-control @error('jenisArsip_id') is-invalid @enderror"
                                        name="jenisArsip_id" value="{{ $arsip->nama }}">
                                        <option value="{{ $arsip->jenisArsip_id }}">{{ $arsip->jenisArsip->nama }}</option>
                                        @foreach ($jenisArsip as $data)
                                            <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('jenisArsip_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="file" class="form-label">File</label>
                                    <input type="file" class="form-control @error('file') is-invalid @enderror"
                                        id="file" name="file">
                                    @error('file')
                                        <div id="file" class="form-file">{{ $message }}</div>
                                    @enderror
                                    @if ($arsip->file)
                                        <small id="fileHelp" class="form-text text-muted">File yang diunggah:
                                            {{ $arsip->file }}</small>
                                    @else
                                        <small id="fileHelp" class="form-text text-muted">Tidak ada file yang
                                            diunggah</small>
                                    @endif
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
