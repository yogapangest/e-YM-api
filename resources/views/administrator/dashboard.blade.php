@extends('administrator.layouts.app')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>

            <div class="container-fluid">

                <div class="card justify-content-start">
                    <div class="row">
                        <div class="col-lg-8">
                            <canvas id="donationChart" width="1500" height="710"></canvas>
                        </div>
                        <div class="col-lg-4">
                            <div class="card card-statistic-1">
                                <div class="card-wrap">
                                    <div class="card-icon bg-danger">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                    <div class="card-header">
                                        <h4>Jumlah Donasi</h4>
                                    </div>
                                    <div class="card-body" id="totalDonasiAdminFormatted">
                                        <!-- Jumlah Donasi akan diisi dengan JavaScript -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="container-fluid">

                <div class="card justify-content-start">
                    <div class="row">
                        <div class="col-lg-8">
                            <h2 class="text-center">Jumlah Pemasukan Uang Donasi Per Bulan</h2>
                            <div class="card card-statistic-1">
                                <canvas id="donationBarChart" width="1500" height="600"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-danger">
                                    <i class="far fa-file"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Jumlah Donasi</h4>
                                    </div>
                                    <div class="card-body" id="totalDonasiFormatted">
                                        <!-- Jumlah Donasi akan diisi dengan JavaScript -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Jumlah Distribusi</h4>
                            </div>
                            <div class="card-body" id="totalDistribusi">
                                <!-- Jumlah Distribusi akan diisi dengan JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Jumlah Donatur</h4>
                            </div>
                            <div class="card-body" id="totalDonatur">
                                <!-- Jumlah Donatur akan diisi dengan JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="far fa-file"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Jumlah Arsip</h4>
                            </div>
                            <div class="card-body" id="totalArsip">
                                <!-- Jumlah Arsip akan diisi dengan JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Jumlah Program</h4>
                            </div>
                            <div class="card-body" id="totalProgram">
                                <!-- Jumlah Program akan diisi dengan JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Guest</h4>
                            </div>
                            <div class="card-body" id="totalGuest">
                                <!-- Total Guest akan diisi dengan JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "{{ url('/api/dashboard') }}",
                method: 'GET',
                success: function(data) {
                    console.log(data)
                    $('#totalDistribusi').text(data.totalDistribusi);
                    $('#totalArsip').text(data.totalArsip);
                    $('#totalDonatur').text(data.totalDonatur);
                    $('#totalProgram').text(data.totalProgram);
                    $('#totalGuest').text(data.totalGuest);
                    $('#totalDonasiFormatted').text(data.totalDonasiFormatted);
                    $('#totalDonasiAdminFormatted').text(data.totalDonasiAdminFormatted);

                    var ctx = $('#donationChart');
                    if (ctx.length) {
                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.months,
                                datasets: [{
                                    label: 'Total Donasi',
                                    data: data.donationDataAdmin,
                                    backgroundColor: "#6777EF",
                                    borderColor: "#2E3192",
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    }

                    var ctxBar = $('#donationBarChart');
                    if (ctxBar.length) {
                        new Chart(ctxBar, {
                            type: 'bar',
                            data: {
                                labels: data.months,
                                datasets: [{
                                    label: 'Total Donasi per Bulan',
                                    data: data.donationData,
                                    backgroundColor: "#6777EF",
                                    borderColor: "#2E3192",
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error fetching data: " + textStatus, errorThrown);
                }
            });
        });
    </script>
@endsection
