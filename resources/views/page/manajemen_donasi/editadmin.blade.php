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
                            <form method="POST" action="{{ route('form.update.donasi_admin', $donasi->id) }}"
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
                                        placeholder="nominal" value="{{ number_format($donasi->nominal, 0, ',', '.') }}">
                                    @error('nominal')
                                        <div id="nominal" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="file" class="form-label">File</label>
                                    <input type="file" class="form-control @error('file') is-invalid @enderror"
                                        id="file" name="file">
                                    @error('file')
                                        <div id="file" class="form-file">{{ $message }}</div>
                                    @enderror
                                    <small id="fileHelp" class="form-text text-muted">
                                        {{ $donasi->file ? 'File yang diunggah: ' . $donasi->file : 'Tidak ada file yang diunggah' }}
                                    </small>
                                </div>


                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        Update Donasi
                                    </button>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var nominalInput = document.getElementById('nominal');

                                        nominalInput.addEventListener('input', function(e) {
                                            // Menghilangkan karakter non-digit
                                            var value = e.target.value.replace(/[^,\d]/g, '');

                                            // Mengubah menjadi format angka dengan titik
                                            e.target.value = new Intl.NumberFormat('id-ID').format(value);
                                        });

                                        // Fungsi untuk menghilangkan format saat mengirim data
                                        nominalInput.closest('form').addEventListener('submit', function() {
                                            nominalInput.value = nominalInput.value.replace(/\./g, '');
                                        });
                                    });
                                </script>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
