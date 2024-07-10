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
                            <form id="UpdateForm" method="POST" enctype="multipart/form-data">
                                <input type="hidden" id="distribusis_id" name="distribusis_id" value="#">
                                @csrf
                                <div class="form-group">
                                    <label for="nama_barang">Nama Barang</label>
                                    <input id="nama_barang" type="text"
                                        class="form-control @error('nama_barang') is-invalid @enderror" name="nama_barang">
                                    @error('nama_barang')
                                        <div id="nama_barang" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="volume">Volume</label>
                                    <input id="volume" type="text"
                                        class="form-control @error('volume') is-invalid @enderror" name="volume">
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
                                        name="harga_satuan_display" value="{{ old('harga_satuan') }}">
                                    <input id="harga_satuan" type="hidden" name="harga_satuan"
                                        value="{{ old('harga_satuan') }}">
                                    @error('harga_satuan')
                                        <div id="harga_satuan_error" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                                        Simpan Data Barang
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            var distribusiId = window.location.pathname.split('/').pop();

            // Mendapatkan data yang ada dan mengisi form
            $.ajax({
                url: '/api/admin/manajemen/distribusi-barang/edit/' + distribusiId,
                method: 'GET',
                success: function(data) {
                    if (data.distribusibarangs) { // Periksa apakah distribusibarangs ada
                        $('#distribusis_id').val(data.distribusibarangs.distribusis_id);
                        $('#nama_barang').val(data.distribusibarangs.nama_barang);
                        $('#volume').val(data.distribusibarangs.volume);
                        $('#satuan').val(data.distribusibarangs.satuan);
                        $('#harga_satuan').val(data.distribusibarangs.harga_satuan);

                        // Format harga satuan ke format Rupiah
                        $('#harga_satuan_display').val(formatRupiah(data.distribusibarangs
                            .harga_satuan));
                    } else {
                        console.error('Unexpected data format:', data);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('There has been a problem with your AJAX operation:', error);
                }
            });

            // Mengirim data yang diperbarui saat form disubmit
            $('#UpdateForm').submit(function(event) {
                event.preventDefault();

                var formData = new FormData();
                formData.append('distribusis_id', $('#distribusis_id').val());
                formData.append('nama_barang', $('#nama_barang').val());
                formData.append('volume', $('#volume').val());
                formData.append('satuan', $('#satuan').val());
                formData.append('harga_satuan', $('#harga_satuan').val());

                $.ajax({
                    url: '/api/admin/manajemen/distribusi-barang/update/' + distribusiId,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-HTTP-Method-Override': 'PUT' // Method Override untuk menggunakan PUT
                    },
                    success: function(data) {
                        window.location.href = data.url;
                    },
                    error: function(xhr, status, error) {
                        console.error('There has been a problem with your AJAX operation:',
                            error);
                    }
                });
            });
        });

        // Function to format number to Rupiah
        function formatRupiah(number) {
            return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }

        function parseRupiah(rupiah) {
            return rupiah.replace(/[^0-9]/g, '');
        }

        $('#harga_satuan_display').on('input', function() {
            var rawValue = parseRupiah($(this).val());
            $('#harga_satuan').val(rawValue);
            $(this).val(formatRupiah(rawValue));
        });
    </script>
@endsection
