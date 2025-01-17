@extends('administrator.layouts.app')


@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="row pt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tambah Data Barang</h4>
                        </div>
                        <!-- Peringatan akan muncul di sini -->
                        <div id="warningMessage" style="display: none;" class="alert alert-danger"></div>
                        <div class="card-body">
                            <form id="DistribusiBarangForm" method="POST" action="#">
                                @csrf
                                <input type="hidden" name="distribusis_id" value="#">

                                <div class="form-group">
                                    <label for="nama_barang">Nama Barang</label>
                                    <input id="nama_barang" type="text"
                                        class="form-control @error('nama_barang') is-invalid @enderror" name="nama_barang"
                                        placeholder="Nama Barang" value="{{ old('nama_barang') }}">
                                    @error('nama_barang')
                                        <div id="nama_barang" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="volume">Volume</label>
                                    <input id="volume" type="text"
                                        class="form-control @error('volume') is-invalid @enderror" name="volume"
                                        placeholder="Volume" value="{{ old('volume') }}">
                                    @error('volume')
                                        <div id="volume" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="satuan">Satuan</label>
                                    <select id="satuan" class="form-control @error('satuan') is-invalid @enderror"
                                        name="satuan">
                                        <option value="">Pilih Satuan</option>
                                        <option value="Nota">Nota</option>
                                        <option value="Kwitansi">Kwitansi</option>

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
                                        value="{{ old('harga_satuan') }}">
                                    <input id="harga_satuan" type="hidden" name="harga_satuan"
                                        value="{{ old('harga_satuan') }}">
                                    @error('harga_satuan')
                                        <div id="harga_satuan_error" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>

                                @if ($errors->has('total_harga'))
                                    <div class="alert alert-danger">{{ $errors->first('total_harga') }}</div>
                                @endif

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        Tambah Data Barang
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
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('js/distribusibarang.js') }}"></script>


    <script>
        $(document).ready(function() {
            var distribusiId = window.location.pathname.split('/').pop();

            $('#DistribusiBarangForm').submit(function(event) {
                event.preventDefault();

                var formData = new FormData(this);
                formData.append('distribusis_id', distribusiId);
                formData.append('nama_barang', $('#nama_barang').val());
                formData.append('volume', $('#volume').val());
                formData.append('satuan', $('#satuan').val());
                formData.append('harga_satuan', $('#harga_satuan').val());

                // Hitung total jumlah yang akan ditambahkan
                var totalJumlahBaru = parseInt($('#jumlah').val());
                var totalJumlahSaatIni = 0;

                // Iterasi data yang ada di tabel distribusi untuk menghitung total jumlah saat ini
                $('.table-striped tbody tr').each(function(index, tr) {
                    var jumlah = parseInt($(tr).find('td:nth-child(6)').text().replace(/\D/g, ''));
                    totalJumlahSaatIni += jumlah;
                });

                // Bandingkan dengan pengeluaran yang ada
                var pengeluaran = distribusiId;

                if ((totalJumlahSaatIni + totalJumlahBaru) > pengeluaran) {
                    // Ganti alert dengan menampilkan pesan di halaman
                    $('#warningMessage').text(
                        'Jumlah total melebihi pengeluaran yang ada pada distribusi ini.');
                    $('#warningMessage').show();
                    return;
                }

                $.ajax({
                    url: '/api/admin/manajemen/distribusi-barang/',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },

                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: 'Data berhasil disimpan',
                            confirmButtonColor: '#6777ef',
                        }).then(function() {
                            window.location.href = '/apps/distribusi_barang/view/' +
                                distribusiId;
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('There has been a problem with your AJAX operation:',
                            error);
                    }
                });
            });
        });
    </script>
@endsection
