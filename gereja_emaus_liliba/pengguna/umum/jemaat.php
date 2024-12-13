<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Gereja Emanuel Liliba</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="keywords" />
    <meta content="" name="description" />

    <!-- Favicons -->
    <link href="../../assets/img/gereja/logo.jpg" rel="icon" />
    <link href="img/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800|Montserrat:300,400,700"
        rel="stylesheet" />

    <!-- Bootstrap CSS File -->
    <link href="lib/bootstrap/css/bootstrap.min.css?v=<?= time(); ?>" rel="stylesheet" />

    <!-- Libraries CSS Files -->
    <link href="lib/font-awesome/css/font-awesome.min.css?v=<?= time(); ?>" rel="stylesheet" />
    <link href="lib/animate/animate.min.css?v=<?= time(); ?>" rel="stylesheet" />
    <link href="lib/ionicons/css/ionicons.min.css?v=<?= time(); ?>" rel="stylesheet" />
    <link href="lib/owlcarousel/assets/owl.carousel.min.css?v=<?= time(); ?>" rel="stylesheet" />
    <link href="lib/magnific-popup/magnific-popup.css?v=<?= time(); ?>" rel="stylesheet" />
    <link href="lib/ionicons/css/ionicons.min.css?v=<?= time(); ?>" rel="stylesheet" />

    <!-- Main Stylesheet File -->
    <link href="css/style.css?v=<?= time(); ?>" rel="stylesheet" />

</head>

<body id="body">
    <!-- Header Section -->
    <header id="header">
        <div class="container d-flex justify-content-between align-items-center">
            <div id="logo">
                <h1>
                    <a href="#body" class="scrollto">Gereja <span>Emaus</span> Liliba</a>
                </h1>
            </div>

            <nav id="nav-menu-container">
                <ul class="nav-menu d-flex">
                    <li><a href="home">Home</a></li>
                    <li><a href="home#about">Tentang Gereja</a></li>
                    <li><a href="home#services">Detail</a></li>
                    <li><a href="home#contact">Kontak</a></li>
                    <li><a href="../../berlangganan/login">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content Section -->
    <main id="main">
        <div class="container-fluid py-4">
            <section class="section">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow">
                            <div class="card-body text-center">
                                <div class="card-header pb-0">
                                    <h3 class="text-center">Table Rayon</h3>
                                </div>
                                <div class="garis"></div>
                                <style>
                                .garis {
                                    width: 50%;
                                    height: 1.5px;
                                    background-color: grey;
                                    margin: 0 auto 30px;
                                }
                                </style>
                                <!-- Search Form -->
                                <form method="GET" action="">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control"
                                            placeholder="Cari rayon..." name="search"
                                            style="height: 45px;"
                                            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                        <button class="btn btn-outline-secondary" type="submit">Cari</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <?php
            // Ambil data jemaat dari database
            include '../../keamanan/koneksi.php';

            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = 10;
            $offset = ($page - 1) * $limit;

            // Query untuk mendapatkan data jemaat dengan pencarian dan pagination
            $query = "
        SELECT 
            jemaat.*, 
            rayon.nama_rayon, 
            kk.no_kk 
        FROM jemaat
        LEFT JOIN rayon ON jemaat.id_rayon = rayon.id_rayon
        LEFT JOIN kk ON jemaat.id_kk = kk.id_kk
        WHERE 
            jemaat.nik LIKE ? OR 
            jemaat.nama LIKE ? OR 
            jemaat.jk LIKE ? OR 
            jemaat.tempat_lahir LIKE ?
        LIMIT ?, ?";
            $stmt = $koneksi->prepare($query);
            $search_param = '%' . $search . '%';
            $stmt->bind_param("ssssii", $search_param, $search_param, $search_param, $search_param, $offset, $limit);
            $stmt->execute();
            $result = $stmt->get_result();

            // Hitung total halaman
            $total_query = "
        SELECT COUNT(*) as total 
        FROM jemaat
        LEFT JOIN rayon ON jemaat.id_rayon = rayon.id_rayon
        LEFT JOIN kk ON jemaat.id_kk = kk.id_kk
        WHERE 
            jemaat.nik LIKE ? OR 
            jemaat.nama LIKE ? OR 
            jemaat.jk LIKE ? OR 
            jemaat.tempat_lahir LIKE ?";
            $stmt_total = $koneksi->prepare($total_query);
            $stmt_total->bind_param("ssss", $search_param, $search_param, $search_param, $search_param);
            $stmt_total->execute();
            $total_result = $stmt_total->get_result();
            $total_row = $total_result->fetch_assoc();
            $total_pages = ceil($total_row['total'] / $limit);
            ?>
            <div class="row">
                <div class="col-12 mt-4">
                    <div class="card mb-4">
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <?php if ($result->num_rows > 0): ?>
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Nomor</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Nama Rayon</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Nomor Kepala Keluarga</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                NIK</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Nama</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Jenis Kelamin</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Tempat Lahir</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Tanggal Lahir</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Status Dalam Rumah</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Golongan Darah</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Suku</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Status Tempat Rumah</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Pendidikan Terakhir</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Pendidikan Saat Ini</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Pekerjaan</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Penghasilan</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Status Merital</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Status Babtis</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Status Sidi</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Status Nikah</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Keper Sertaan</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Jenis Bantuan Sosial</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Jenis Diakonia</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $nomor = $offset + 1;
                                            while ($row = $result->fetch_assoc()):
                                            ?>
                                        <tr>
                                            <td class="align-middle text-center"><?php echo $nomor++; ?></td>
                                            <td class="align-middle text-center"><?php echo $row['nama_rayon']; ?></td>
                                            <td class="align-middle text-center"><?php echo $row['no_kk']; ?></td>
                                            <td class="align-middle text-center"><?php echo $row['nik']; ?></td>
                                            <td class="align-middle text-center"><?php echo $row['nama']; ?></td>
                                            <td class="align-middle text-center"><?php echo $row['jk']; ?></td>
                                            <td class="align-middle text-center"><?php echo $row['tempat_lahir']; ?>
                                            </td>
                                            <td class="align-middle text-center"><?php echo $row['tanggal_lahir']; ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php echo $row['status_dalam_rumah']; ?></td>
                                            <td class="align-middle text-center"><?php echo $row['gol_darah']; ?></td>
                                            <td class="align-middle text-center"><?php echo $row['suku']; ?></td>
                                            <td class="align-middle text-center">
                                                <?php echo $row['status_tempat_rumah']; ?></td>
                                            <td class="align-middle text-center">
                                                <?php echo $row['pendidikan_terakhir']; ?></td>
                                            
                                            <td class="align-middle text-center"><?php echo $row['pekerjaan']; ?></td>
                                            <td class="align-middle text-center"><?php echo $row['penghasilan']; ?></td>
                                            <td class="align-middle text-center"><?php echo $row['status_marital']; ?>
                                            </td>
                                            <td class="align-middle text-center"><?php echo $row['status_babtis']; ?>
                                            </td>
                                            <td class="align-middle text-center"><?php echo $row['status_sidi']; ?></td>
                                            <td class="align-middle text-center"><?php echo $row['status_nikah']; ?>
                                            </td>
                                            <td class="align-middle text-center"><?php echo $row['keper_setaan']; ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php echo $row['jenis_bantuan_sosial']; ?></td>
                                            <td class="align-middle text-center"><?php echo $row['jenis_diakonia']; ?>
                                            </td>
                                            <td class="align-middle text-center"><?php echo $row['keterangan']; ?></td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>

                                </table>
                                <?php else: ?>
                                <p class="text-center mt-4">Data tidak ditemukan.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pagination Section -->
            <section class="section">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <nav aria-label="Page navigation example" style="margin-top: 2.2rem;">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item <?php if ($page <= 1) {
                                                                    echo 'disabled';
                                                                } ?>">
                                            <a class="page-link" href="<?php if ($page > 1) {
                                                                            echo "?page=" . ($page - 1) . "&search=" . $search;
                                                                        } ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <li class="page-item <?php if ($i == $page) {
                                                                        echo 'active';
                                                                    } ?>">
                                            <a class="page-link"
                                                href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
                                        </li>
                                        <?php endfor; ?>
                                        <li class="page-item <?php if ($page >= $total_pages) {
                                                                    echo 'disabled';
                                                                } ?>">
                                            <a class="page-link" href="<?php if ($page < $total_pages) {
                                                                            echo "?page=" . ($page + 1) . "&search=" . $search;
                                                                        } ?>" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Footer Section -->
    <footer id="footer" class="py-4 bg-light">
        <div class="container text-center">
            <div class="copyright">
                &copy; Copyright <strong>Gereja Moria Liliba</strong>.
            </div>
            <div class="credits">
                Dibuat Oleh Tirsa
            </div>
        </div>
    </footer>

    <!-- Back-to-Top Button -->
    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="lib/jquery/jquery.min.js?v=<?= time(); ?>"></script>
    <script src="lib/jquery/jquery-migrate.min.js?v=<?= time(); ?>"></script>
    <script src="lib/bootstrap/js/bootstrap.bundle.min.js?v=<?= time(); ?>"></script>
    <script src="lib/easing/easing.min.js?v=<?= time(); ?>"></script>
    <script src="lib/superfish/hoverIntent.js?v=<?= time(); ?>"></script>
    <script src="lib/superfish/superfish.min.js?v=<?= time(); ?>"></script>
    <script src="lib/wow/wow.min.js?v=<?= time(); ?>"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js?v=<?= time(); ?>"></script>
    <script src="lib/magnific-popup/magnific-popup.min.js?v=<?= time(); ?>"></script>
    <script src="lib/sticky/sticky.js?v=<?= time(); ?>"></script>

    <!-- Contact Form JavaScript File -->
    <script src="contactform/contactform.js?v=<?= time(); ?>"></script>

    <!-- Template Main Javascript File -->
    <script src="js/main.js?v=<?= time(); ?>"></script>
</body>


</html>