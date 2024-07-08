@extends('administrator.layouts.app')


@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">



            <div class="row pt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tambah Jenis Arsip</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('index.store.datadonasi') }}">
                                @csrf

                                <div class="form-group">
                                    <label for="user_id">Pilih User</label>
                                    <select class="form-control" id="user_id" name="user_id">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input id="nama" type="text"
                                        class="form-control @error('nama') is-invalid @enderror" name="nama"
                                        placeholder="Nama">
                                    @error('nama')
                                        <div id="nama" class="form-text"></div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <input id="alamat" type="text"
                                        class="form-control @error('alamat') is-invalid @enderror" name="alamat"
                                        placeholder="alamat">
                                    @error('alamat')
                                        <div id="alamat" class="form-text"></div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="telephone">No telephone</label>
                                    <input id="telephone" type="text"
                                        class="form-control @error('telephone') is-invalid @enderror" name="telephone"
                                        placeholder="telephone">
                                    @error('telephone')
                                        <div id="telephone" class="form-text"></div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input id="email" type="text"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        placeholder="email">
                                    @error('email')
                                        <div id="email" class="form-text"></div>
                                    @enderror
                                </div> --}}

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary ">
                                        Tambah Data Donasi
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
