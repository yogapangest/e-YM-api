@extends('administrator.layouts.app')

@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="row pt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Program</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('index.update.distribusi', $distribusi->id) }}"
                                enctype="multipart/form-data">
                                @method('put')
                                @csrf

                                <div class="form-group">
                                    <label for="program">Program</label>
                                    <select id="programs_id" class="form-control @error('programs_id') is-invalid @enderror"
                                        name="programs_id" value="{{ $distribusi->nama }}">
                                        <option value="{{ $distribusi->programs_id }}">{{ $distribusi->program->nama }}
                                        </option>
                                        @foreach ($programs as $data)
                                            <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('programs_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input id="tanggal" type="date"
                                        class="form-control @error('tanggal') is-invalid @enderror" name="tanggal"
                                        placeholder="tanggal" value="{{ $distribusi->tanggal }}">
                                    @error('tanggal')
                                        <div id="tanggal" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tempat">Tempat</label>
                                    <input id="tempat" type="text"
                                        class="form-control @error('tempat') is-invalid @enderror" name="tempat"
                                        placeholder="Tempat" value="{{ $distribusi->tempat }}">
                                    @error('tempat')
                                        <div id="tempat" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="penerima_manfaat">Penerima Manfaat</label>
                                    <input id="penerima_manfaat" type="text"
                                        class="form-control @error('penerima_manfaat') is-invalid @enderror"
                                        name="penerima_manfaat" placeholder="Penerima Manfaat"
                                        value="{{ $distribusi->penerima_manfaat }}">
                                    @error('penerima_manfaat')
                                        <div id="penerima_manfaat" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="anggaran_display">Anggaran</label>
                                    <input id="anggaran_display" type="text"
                                        class="form-control @error('anggaran') is-invalid @enderror" name="anggaran_display"
                                        placeholder="Anggaran"
                                        value="{{ number_format($distribusi->anggaran, 0, ',', '.') }}">
                                    <input id="anggaran" type="hidden" name="anggaran"
                                        value="{{ $distribusi->anggaran }}">
                                    @error('anggaran')
                                        <div id="anggaran_error" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="pengeluaran_display">Pengeluaran</label>
                                    <input id="pengeluaran_display" type="text"
                                        class="form-control @error('pengeluaran') is-invalid @enderror"
                                        name="pengeluaran_display" placeholder="Pengeluaran"
                                        value="{{ number_format($distribusi->pengeluaran, 0, ',', '.') }}">
                                    <input id="pengeluaran" type="hidden" name="pengeluaran"
                                        value="{{ $distribusi->pengeluaran }}">
                                    @error('pengeluaran')
                                        <div id="pengeluaran_error" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="file" class="form-label">File</label>
                                    <input type="file" class="form-control @error('file') is-invalid @enderror"
                                        id="file" name="file">
                                    @error('file')
                                        <div id="file" class="form-file">{{ $message }}</div>
                                    @enderror
                                    @if ($distribusi->file)
                                        <small id="fileHelp" class="form-text text-muted">File yang diunggah:
                                            {{ $distribusi->file }}</small>
                                    @else
                                        <small id="fileHelp" class="form-text text-muted">Tidak ada file yang
                                            diunggah</small>
                                    @endif
                                </div>


                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        Tambah Distribusi
                                    </button>
                                </div>
                                <script>
                                    function formatRupiah(input) {
                                        let displayValue = input.value.replace(/\D/g, ''); // Hapus semua karakter non-digit
                                        let formattedValue = displayValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Tambahkan titik setiap 3 angka
                                        input.value = formattedValue;

                                        // Set nilai asli tanpa format ke hidden input yang sesuai
                                        let hiddenInputId = input.id.replace('_display', '');
                                        document.getElementById(hiddenInputId).value = displayValue;
                                    }

                                    document.getElementById('anggaran_display').addEventListener('input', function(e) {
                                        formatRupiah(e.target);
                                    });

                                    document.getElementById('pengeluaran_display').addEventListener('input', function(e) {
                                        formatRupiah(e.target);
                                    });

                                    document.querySelector('form').addEventListener('submit', function(e) {
                                        let anggaranDisplayValue = document.getElementById('anggaran_display').value;
                                        let pengeluaranDisplayValue = document.getElementById('pengeluaran_display').value;

                                        // Hapus titik sebelum submit
                                        document.getElementById('anggaran').value = anggaranDisplayValue.replace(/\./g, '');
                                        document.getElementById('pengeluaran').value = pengeluaranDisplayValue.replace(/\./g, '');
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
