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
                        <div class="card-body">
                            <form method="POST" action="{{ route('index.store.databarang') }}">
                                @csrf

                                <div class="form-group">
                                    <label for="nama_barang">Nama Barang</label>
                                    <input id="nama_barang" type="text"
                                        class="form-control @error('nama_barang') is-invalid @enderror" name="nama_barang"
                                        placeholder="Nama Barang ">
                                    @error('nama_barang')
                                        <div id="nama_barang" class="form-text"></div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="volume">Volume</label>
                                    <input id="volume" type="text"
                                        class="form-control @error('volume') is-invalid @enderror" name="volume"
                                        placeholder="Volume">
                                    @error('volume')
                                        <div id="volume" class="form-text"></div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="satuan">Satuan</label>
                                    <input id="satuan" type="text"
                                        class="form-control @error('satuan') is-invalid @enderror" name="satuan"
                                        placeholder="Nota/Kwitansi">
                                    @error('satuan')
                                        <div id="satuan" class="form-text"></div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="harga_satuan">Harga_satuan</label>
                                    <input id="harga_satuan" type="text"
                                        class="form-control @error('harga_satuan') is-invalid @enderror" name="harga_satuan"
                                        placeholder="harga_satuan">
                                    @error('Harga Satuan')
                                        <div id="harga_satuan" class="form-text"></div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="jumlah">Jumlah</label>
                                    <input id="jumlah" type="text"
                                        class="form-control @error('jumlah') is-invalid @enderror" name="jumlah"
                                        placeholder="Jumlah">
                                    @error('jumlah')
                                        <div id="jumlah" class="form-text"></div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        Tambah Data Barang
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
