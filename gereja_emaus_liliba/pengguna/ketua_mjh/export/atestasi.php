<!DOCTYPE html>
<html lang="en">
<?php include 'head_export.php'; ?>
<?php include 'nama_halaman.php'; ?>

<body translate="no">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h3 class="text-center">Data Export <?= $page_title ?> </h3>
                    </div>
                    <?php
                    // Ambil data checkout dari database
                    include '../../../keamanan/koneksi.php';

                    $search = isset($_GET['search']) ? $_GET['search'] : '';
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $limit = 10;
                    $offset = ($page - 1) * $limit;

                    // Query untuk mendapatkan data atestasi dengan pencarian, pagination, dan nama jemaat
                    $query = "SELECT atestasi.id_atestasi, atestasi.id_jemaat, atestasi.status, atestasi.gereja_asal, atestasi.gereja_tujuan, jemaat.nama, jemaat.pekerjaan, jemaat.nik, jemaat.jk, jemaat.tanggal_lahir, jemaat.tempat_lahir, kk.no_kk
          FROM atestasi
          JOIN jemaat ON atestasi.id_jemaat = jemaat.id_jemaat
          JOIN kk ON jemaat.id_kk = kk.id_kk
          WHERE atestasi.status LIKE ? OR atestasi.gereja_asal LIKE ? OR atestasi.gereja_tujuan LIKE ? OR atestasi.status LIKE ?
          LIMIT ?, ?";
                    $stmt = $koneksi->prepare($query);
                    $search_param = '%' . $search . '%';
                    $stmt->bind_param("ssssii", $search_param, $search_param, $search_param, $search_param, $offset, $limit);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Hitung total halaman
                    $total_query = "SELECT COUNT(*) as total
                FROM atestasi
                WHERE status LIKE ? OR gereja_asal LIKE ? OR gereja_tujuan LIKE ? OR status LIKE ?";
                    $stmt_total = $koneksi->prepare($total_query);
                    $stmt_total->bind_param("ssss", $search_param, $search_param, $search_param, $search_param);
                    $stmt_total->execute();
                    $total_result = $stmt_total->get_result();
                    $total_row = $total_result->fetch_assoc();
                    $total_pages = ceil($total_row['total'] / $limit);
                    ?>

                    <div class="card-body">
                        <div class="table-responsive">

                            <?php if ($result->num_rows > 0): ?>
                            <table id="example" class="table table-hover text-center mt-3"
                                style="border-collapse: separate; border-spacing: 0;">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                            Nomor
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                            Nama Majelis
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                            Nomor KK
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                            NIK
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                            Tanggal Lahir
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                            Tempat Lahir
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                            Jenis Kelamin
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                            Pekerjaan
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                            Gereja Asal
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                            Gereja Tujuan
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $nomor = $offset + 1; // Mulai nomor urut dari $offset + 1
                                        while ($row = $result->fetch_assoc()) :
                                        ?>
                                    <tr>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold"><?php echo $nomor; ?></span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold"><?php echo $row['nama']; ?></span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold"><?php echo $row['no_kk']; ?></span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold"><?php echo $row['nik']; ?></span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold"><?php echo $row['tanggal_lahir']; ?></span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold"><?php echo $row['tempat_lahir']; ?></span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold"><?php echo $row['jk']; ?></span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold"><?php echo $row['pekerjaan']; ?></span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold"><?php echo $row['gereja_asal']; ?></span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-xs font-weight-bold"><?php echo $row['gereja_tujuan']; ?></span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold"><?php echo $row['status']; ?></span>
                                        </td>

                                    </tr>
                                    <?php $nomor++;
                                        endwhile; ?>
                                </tbody>
                            </table>

                            <?php else: ?>
                            <p class="text-center mt-4">Data tidak ditemukan 😖.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- Pagination -->
                </div>
            </div>
        </div>
    </div>

    <?php include '../fitur/js_export.php'; ?>

</body>

</html>