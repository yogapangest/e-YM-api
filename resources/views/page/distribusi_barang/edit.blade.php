@extends('administrator.layouts.app')


@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">

            <div class="row pt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Data Barang</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('index.update.distribusibarang', $distribusiBarang->id) }}">
                                @method('put')
                                @csrf
                                <input type="hidden" name="distribusi_id" value="{{ $distribusiBarang->distribusi_id }}">

                                <div class="form-group">
                                    <label for="nama_barang">Nama Barang</label>
                                    <input id="nama_barang" type="text"
                                        class="form-control @error('nama_barang') is-invalid @enderror" name="nama_barang"
                                        placeholder="Nama Barang" value="{{ $distribusiBarang->nama_barang }}">
                                    @error('nama_barang')
                                        <div id="nama_barang" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="volume">Volume</label>
                                    <input id="volume" type="text"
                                        class="form-control @error('volume') is-invalid @enderror" name="volume"
                                        placeholder="Volume" value="{{ $distribusiBarang->volume }}">
                                    @error('volume')
                                        <div id="volume" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="satuan">Satuan</label>
                                    <select id="satuan" class="form-control @error('satuan') is-invalid @enderror"
                                        name="satuan">
                                        <option value="">Pilih Satuan</option>
                                        <option value="Nota" {{ $distribusiBarang->satuan == 'Nota' ? 'selected' : '' }}>
                                            Nota</option>
                                        <option value="Kwitansi"
                                            {{ $distribusiBarang->satuan == 'Kwitansi' ? 'selected' : '' }}>Kwitansi
                                        </option>
                                    </select>
                                    @error('satuan')
                                        <div id="satuan" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="harga_satuan_display">Harga Satuan</label>
                                    <input id="harga_satuan_display" type="text"
                                        class="form-control @error('harga_satuan') is-invalid @enderror"
                                        name="harga_satuan_display" placeholder="Harga Satuan"
                                        value="{{ number_format($distribusiBarang->harga_satuan, 0, ',', '.') }}">
                                    <input id="harga_satuan" type="hidden" name="harga_satuan"
                                        value="{{ $distribusiBarang->harga_satuan }}">
                                    @error('harga_satuan')
                                        <div id="harga_satuan_error" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                                        Simpan Data Barang
                                    </button>
                                </div>
                                <script>
                                    document.getElementById('harga_satuan_display').addEventListener('input', function(e) {
                                        let displayValue = e.target.value.replace(/\D/g, ''); // Hapus semua karakter non-digit
                                        let formattedValue = displayValue.replace(/\B(?=(\d{3})+(?!\d))/g,
                                        '.'); // Tambahkan titik setiap 3 angka
                                        e.target.value = formattedValue;

                                        // Set nilai asli tanpa format ke hidden input
                                        document.getElementById('harga_satuan').value = displayValue;
                                    });

                                    document.querySelector('form').addEventListener('submit', function(e) {
                                        let displayValue = document.getElementById('harga_satuan_display').value;
                                        let actualValue = displayValue.replace(/\./g, ''); // Hapus titik sebelum submit
                                        document.getElementById('harga_satuan').value = actualValue;
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
