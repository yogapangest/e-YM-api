<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>e-YM</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('landingpage/img/eym.png') }}" rel="icon">
    <link href="{{ asset('landingpage/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('landingpage/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('landingpage/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('landingpage/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('landingpage/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('landingpage/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('landingpage/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('landingpage/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('landingpage/css/style.css') }}" rel="stylesheet">

    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Your other head content -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<body>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top ">
        <div class="container d-flex align-items-center">

            <h1 class="logo me-auto"><a class="navbar-brand" href="{{ asset('landingpage/img/eym.png') }}">
                    <img src="{{ asset('landingpage/img/eym.png') }}" alt="Logo" class="logo">
                </a></h1>
            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                    <li><a class="nav-link scrollto" href="#penyaluran">Penyaluran</a></li>
                    <li><a class="nav-link scrollto" href="#program">Program</a></li>
                    <li><a class="nav-link scrollto" href="#donasi">Donasi</a></li>
                    <li><a class="nav-link scrollto" href="#rekening_donasi">Rekening Donasi</a></li>
                    <li><a class="nav-link scrollto" href="#footer">Tentang Kita</a></li>
                    <li><a class="getstarted scrollto" href="{{ route('auth') }}">Login <i
                                class="fas fa-sign-in-alt"></i></a></li>

                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center" style="margin-top: 20px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1"
                    data-aos="fade-up" data-aos-delay="200">
                    <h1>Elektronik Yatim Mandiri</h1>
                    <h2>Selamat Datang di Website e-YM Cabang Banyuwangi. Yatim
                        Mandiri adalah Lembaga Amil Zakat Nasional (LAZNAS) milik
                        masyarakat Indonesia yang berkhidmat mengangkat harkat
                        sosial kemanusiaan yatim dhuafa dengan dana ZISWAF (Zakat,
                        Infaq, Shadaqah, Wakaf) serta dana lainnya yang halal dan legal,
                        dari perorangan, kelompok, perusahaan/lembaga.</h2>
                    <div class="d-flex justify-content-center justify-content-lg-start" style="margin-top: -40px;">
                        <a href="#about" class="btn-get-started scrollto">Get Started</a>
                        <a href="https://www.youtube.com/watch?v=tyY9uldxdEk&t=160s"
                            class="glightbox btn-watch-video"><i class="bi bi-play-circle"></i><span>Watch
                                Video</span></a>
                    </div>
                </div>
                <div class="col-lg-5 order-1 order-lg-2 hero-img d-flex align-items-center justify-content-center"
                    data-aos="zoom-in" data-aos-delay="200">
                    <img src="{{ asset('landingpage/img/hero-img.png') }}" class="img-fluid animated" alt="">
                </div>
            </div>
        </div>

    </section>
    <!-- End Hero -->

    <!-- ======= Penyaluran Section ======= -->
    <section id="penyaluran" class="penyaluran section-bg">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Penyaluran Bantuan Yatim Mandiri Cabang Banyuwangi</h2>
            </div>

            <div class="scrollable-content">
                <div class="grid-container" id="konten-penyaluran-container">
                    <!-- Konten penyaluran akan dimuat di sini oleh JavaScript -->
                </div>
            </div>
            <div class="text-center" style="color: #000000;" id="empty-message" style="display: none;">Konten Penyaluran
                Belum Diisi</div>

            <div id="detail-view" class="detail-view" onclick="hideDetail()">
                <div class="detail-content" onclick="event.stopPropagation()">
                    <span class="close-btn" onclick="hideDetail()">&times;</span>
                    <img id="detail-image" src="" alt="Detail Foto" class="img-thumbnail mb-3"
                        width="300">
                    <h2 id="detail-title"></h2>
                    <p id="detail-description"></p>
                </div>
            </div>

        </div>
    </section>
    <!-- End Services Section -->

    <!-- ======= About Us Section ======= -->
    <section id="program" class="program section-bg" style="background-color: #ffffff">
        <div class="container" data-aos="fade-up">

            <div class="grid-container" id="konten-program-container">
                <!-- Konten program akan dimuat di sini oleh JavaScript -->
            </div>
            <div class="text-center" id="empty-message" style="color: rgb(0, 0, 0); display: none;">
                Konten Program Belum Diisi
            </div>


        </div>
    </section><!-- End About Us Section -->

    <!-- ======= Donasi Section ======= -->
    <section id="donasi" class="donasi" style="background-color: #37517e">
        <div class="container" data-aos="fade-up">

            <div class="row content">
                <div class="col-lg-6">
                    <h2>Perumpamaan orang-orang yang menginfakkan
                        hartanya di jalan Allah adalah seperti (orang-
                        orang yang menabur) sebutir biji (benih) yang
                        menumbuhkan tujuh tangkai, pada setiap
                        tangkai ada seratus biji. Allah melipatgandakan
                        (pahala) bagi siapa yang Dia kehendaki. Allah
                        Mahaluas lagi Maha Mengetahui.
                        (QS. Al-Baqarah 261)</h2>
                </div>
                <div class="col-lg-6 button-container">
                    <a href="{{ route('auth') }}">
                        <button class="rounded-button">Donasi</button>
                    </a>

                </div>
            </div>

        </div>
    </section><!-- End Donas Section -->

    <!-- ======= Atm Section ======= -->
    <section id="rekening_donasi" class="atm" style="background-color: #ffffff">
        <div class="container" data-aos="fade-up">

            <div class="row">
                <div class="col-lg-6 d-flex align-items-center justify-content-center" data-aos="fade-right"
                    data-aos-delay="100">
                    <img src="{{ asset('landingpage/img/barcode.png') }}" class="img-fluid" alt="">
                </div>
                <div class="col-lg-6 pt-4 pt-lg-0 content" data-aos="fade-left" data-aos-delay="100">
                    <h3>Rekening Donasi</h3>

                    <div class="atm-content">

                        <div class="atm-info">
                            <div class="atm-logo">
                                <img src="{{ asset('landingpage/img/bsi.png') }}" alt="Logo ATM" width="150px">
                            </div>
                            <div class="account-number">
                                <p>7001201454</p>
                            </div>
                        </div>

                        <div class="atm-info mt-2">
                            <div class="atm-logo">
                                <img src="{{ asset('landingpage/img/bca.png') }}" alt="Logo ATM" width="130px">
                            </div>
                            <div class="account-number">
                                <p>0101358363</p>
                            </div>
                        </div>

                        <div class="atm-info">
                            <div class="atm-logo">
                                <img src="{{ asset('landingpage/img/mandiri.png') }}" alt="Logo ATM" width="150px">
                            </div>
                            <div class="account-number">
                                <p>1400003117703</p>
                            </div>
                        </div>

                        <h4 class="mt-3">a.n Yayasan Yatim Mandiri
                        </h4>

                    </div>

                </div>
            </div>

        </div>
    </section><!-- End Atm Section -->

    <!-- ======= Lokasi Section ======= -->
    {{-- <section id="lokasi" class="lokasi">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Lokasi Yatim Mandiri Cabang Banyuwangi</h2>
                </div>

                <div class="row">

                    <div class="col-lg-12 d-flex align-items-stretch">
                        <div class="info">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3948.8842549922347!2d114.37168017405705!3d-8.214393782425995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd15b070776f463%3A0x6ed30de20d3d8121!2sYatim%20Mandiri%20Banyuwangi%3A%20Lembaga%20Amil%20Zakat%20Nasional!5e0!3m2!1sid!2sid!4v1713601654197!5m2!1sid!2sid"
                                width="1200" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>

                    </div>

                </div>

            </div>
        </section> --}}
    <!-- End Contact Section -->

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6 footer-contact d-flex align-items-center justify-content-center">
                        <img src="{{ asset('landingpage/img/eym1.png') }}" alt="Logo ATM" width="130px">
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Lokasi</h4>
                        <p>Jl. Imam Bonjol No.35, Tukangkayu,
                            Kec. Banyuwangi, Kabupaten
                            Banyuwangi, Jawa Timur 68411</p>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Kontak</h4>
                        <p>Telp +62 821-3200-4007
                            Email:yatimmandiri@gmail.com
                        </p>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Sosial Media</h4>
                        <div class="social-links mt-3">
                            <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                            <a href="#" class="youtube"><i class="bx bxl-youtube"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="container footer-bottom clearfix" style="margin-top: -30px;">
            <div class="copyright">
                &copy; Copyright <strong><span>e-YM</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
            </div>
        </div>
    </footer><!-- End Footer -->

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('landingpage/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('landingpage/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('landingpage/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('landingpage/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('landingpage/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('landingpage/vendor/waypoints/noframework.waypoints.js') }}"></script>
    <script src="{{ asset('landingpage/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('landingpage/js/main.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <script>
        // konten program
        $(document).ready(function() {
            $.ajax({
                url: '/api/admin/manajemen/kontenprogram',
                method: 'GET',
                success: function(data) {
                    var container = $('#konten-program-container');
                    var emptyMessage = $('#empty-message');

                    if (Array.isArray(data.kontenprogram) && data.kontenprogram.length > 0) {
                        emptyMessage.hide(); // Sembunyikan pesan jika ada data

                        data.kontenprogram.forEach(function(konten_program, index) {
                            var gridItem = $(
                                '<div class="grid-item single-item" data-aos="zoom-in" data-aos-delay="200"></div>'
                            );
                            var iconBox = $('<div class="icon-box rounded-4"></div>');
                            var icon = $('<div class="icon"></div>');
                            var imagePath = '/file/kontenprogram/' + konten_program.foto;

                            icon.append('<img src="' + imagePath +
                                '" alt="Foto" class="img-thumbnail" width="500">');
                            iconBox.append(icon);
                            iconBox.append('<h2>' + konten_program.nama_kontenprogram +
                                '</h2>');
                            gridItem.append(iconBox);
                            container.append(gridItem);
                        });

                        if (data.kontenprogram.length > 4) {
                            container.css('overflow', 'hidden');
                            var totalWidth = container[0].scrollWidth;

                            setInterval(function() {
                                container.animate({
                                    scrollLeft: totalWidth
                                }, 5000, function() {
                                    container.scrollLeft(0);
                                });
                            }, 5000);
                        }
                    } else {
                        emptyMessage.show(); // Tampilkan pesan jika tidak ada data
                    }
                },
                error: function(xhr, status, error) {
                    console.error('There has been a problem with your AJAX operation:', error);
                    $('#empty-message').show(); // Tampilkan pesan jika terjadi error
                }
            });
        });
    </script>

    <script>
        // konten penyaluran
        $(document).ready(function() {
            $.ajax({
                url: '/api/admin/manajemen/kontenpenyaluran',
                method: 'GET',
                success: function(data) {
                    if (Array.isArray(data.kontenpenyaluran) && data.kontenpenyaluran.length > 0) {
                        var container = $('#konten-penyaluran-container');
                        var emptyMessage = $('#empty-message');
                        emptyMessage.hide();

                        data.kontenpenyaluran.forEach(function(konten_penyaluran) {
                            var gridItem = $(
                                '<div class="grid-item" data-aos="zoom-in" data-aos-delay="200"></div>'
                            );
                            var iconBox = $('<div class="icon-box rounded-4"></div>');
                            var icon = $('<div class="icon"></div>');
                            var imagePath = '/file/kontenpenyaluran/' + konten_penyaluran.foto;

                            icon.append('<img src="' + imagePath +
                                '" alt="Foto" class="img-thumbnail" width="300">');
                            iconBox.append(icon);
                            iconBox.append('<h2 class="nama_penyaluran">' + konten_penyaluran
                                .nama_penyaluran + '</h2>');
                            iconBox.append(
                                '<p class="full-description" style="display: none;">' +
                                konten_penyaluran.deskripsi + '</p>');
                            iconBox.append(
                                '<div class="read-more-btn-container"><button class="read-more-btn">Berita Selengkapnya</button></div>'
                            );
                            gridItem.append(iconBox);
                            container.append(gridItem);
                        });

                        // Hitung total lebar konten di dalam container
                        var totalWidth = container[0].scrollWidth;

                        // Cek apakah perlu melakukan animasi
                        if (totalWidth > container.width()) {
                            setInterval(function() {
                                var currentScrollLeft = container.scrollLeft();
                                container.animate({
                                    scrollLeft: currentScrollLeft +
                                        300 // Menggerakkan sebesar 300 piksel ke kanan
                                }, 2000); // Durasi animasi 2 detik
                            }, 3000); // Interval setiap 3 detik
                        }
                    } else {
                        $('#empty-message').show();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('There has been a problem with your AJAX operation:', error);
                    $('#empty-message').show();
                }
            });
        });

        $(document).on('click', '.read-more-btn', function(event) {
            event.stopPropagation();
            var gridItem = $(this).closest('.grid-item');
            var imagePath = gridItem.find('.icon img').attr('src');
            var title = gridItem.find('.nama_penyaluran').text();
            var description = gridItem.find('.full-description').text();

            $('#detail-image').attr('src', imagePath);
            $('#detail-title').text(title);
            $('#detail-description').text(description);

            $('#detail-view').show();
        });

        function hideDetail() {
            $('#detail-view').hide();
        }
    </script>

</body>

</html>
