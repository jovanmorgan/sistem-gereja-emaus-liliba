<?php include 'fitur/nama_halaman.php'; ?>
<?php include 'fitur/nama_halaman_proses.php'; ?>
<?php include 'fitur/penggunah.php'; ?>
<!DOCTYPE html>
<html lang="en">

<!-- Head -->
<?php include 'fitur/head.php'; ?>

<body class="g-sidenav-show bg-gray-100">
    <!-- aside -->
    <?php include 'fitur/aside.php'; ?>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- navbar -->
        <?php include 'fitur/navbar.php'; ?>

        <div class="container-fluid py-4" id>
            <?php include 'fitur/sercing_table.php'; ?>
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
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                    Aksi</th>
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
                                                    <td class="align-middle text-center">
                                                        <button class="btn btn-warning btn-sm" onclick="openEditModal(
                        '<?php echo $row['id_jemaat']; ?>',
                        '<?php echo $row['id_rayon']; ?>',
                        '<?php echo $row['id_kk']; ?>',
                        '<?php echo $row['nik']; ?>',
                        '<?php echo $row['nama']; ?>',
                        '<?php echo $row['jk']; ?>',
                        '<?php echo $row['tempat_lahir']; ?>',
                        '<?php echo $row['tanggal_lahir']; ?>',
                        '<?php echo $row['status_dalam_rumah']; ?>',
                        '<?php echo $row['gol_darah']; ?>',
                        '<?php echo $row['suku']; ?>',
                        '<?php echo $row['status_tempat_rumah']; ?>',
                        '<?php echo $row['pendidikan_terakhir']; ?>',
                        '<?php echo $row['pekerjaan']; ?>',
                        '<?php echo $row['penghasilan']; ?>',
                        '<?php echo $row['status_marital']; ?>',
                        '<?php echo $row['status_babtis']; ?>',
                        '<?php echo $row['status_sidi']; ?>',
                        '<?php echo $row['status_nikah']; ?>',
                        '<?php echo $row['keper_setaan']; ?>',
                        '<?php echo $row['jenis_bantuan_sosial']; ?>',
                        '<?php echo $row['jenis_diakonia']; ?>',
                        '<?php echo $row['keterangan']; ?>'
                    )">Edit</button>
                                                        <button class="btn btn-danger btn-sm"
                                                            onclick="hapus('<?php echo $row['id_jemaat']; ?>')">Hapus</button>
                                                    </td>
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
                                <!-- Pagination with icons -->
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
                                        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                            <li class="page-item <?php if ($i == $page) {
                                                                        echo 'active';
                                                                    } ?>">
                                                <a class="page-link"
                                                    href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
                                            </li>
                                        <?php } ?>
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
                                <!-- End Pagination with icons -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahDataModalLabel">Tambah <?php echo $page_title ?></h5>
                        <button type="button" class="btn-close" id="closeTambahModal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="tambahForm" method="POST" action="proses/jemaat/tambah.php"
                            enctype="multipart/form-data">
                            <!-- Input Nama Jemaat -->
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Jemaat</label>
                                <input type="text" id="nama" name="nama" class="form-control" required>
                            </div>

                            <!-- Select Rayon -->
                            <div class="mb-3">
                                <label for="id_rayon" class="form-label">Rayon</label>
                                <select id="id_rayon" name="id_rayon" class="form-control" required>
                                    <option value="">Pilih Rayon</option>
                                    <?php
                                    include '../../keamanan/koneksi.php';
                                    $query_rayon = "SELECT id_rayon, nama_rayon FROM rayon";
                                    $result_rayon = $koneksi->query($query_rayon);
                                    while ($row_rayon = $result_rayon->fetch_assoc()) {
                                        echo "<option value='" . $row_rayon['id_rayon'] . "'>" . $row_rayon['nama_rayon'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Select Kepala Keluarga -->
                            <div class="mb-3">
                                <label for="id_kk" class="form-label">Nomor Kepala Keluarga</label>
                                <select id="id_kk" name="id_kk" class="form-control" required>
                                    <option value="">Pilih Kepala Keluarga</option>
                                    <?php
                                    include '../../keamanan/koneksi.php';
                                    $query_kk = "SELECT id_kk, no_kk FROM kk";
                                    $result_kk = $koneksi->query($query_kk);
                                    while ($row_kk = $result_kk->fetch_assoc()) {
                                        echo "<option value='" . $row_kk['id_kk'] . "'>" . $row_kk['no_kk'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Input NIK -->
                            <div class="mb-3">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" id="nik" name="nik" class="form-control" required>
                            </div>

                            <!-- Input Jenis Kelamin -->
                            <div class="mb-3">
                                <label for="jk" class="form-label">Jenis Kelamin</label>
                                <select id="jk" name="jk" class="form-control" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>

                            <!-- Input Tempat Lahir -->
                            <div class="mb-3">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" required>
                            </div>

                            <!-- Input Tanggal Lahir -->
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control"
                                    required>
                            </div>

                            <!-- Input Status dalam Rumah -->
                            <div class="mb-3">
                                <label for="status_dalam_rumah" class="form-label">Status dalam Rumah</label>
                                <input type="text" id="status_dalam_rumah" name="status_dalam_rumah"
                                    class="form-control" required>
                            </div>

                            <!-- Input Golongan Darah -->
                            <div class="mb-3">
                                <label for="gol_darah" class="form-label">Golongan Darah</label>
                                <select id="gol_darah" name="gol_darah" class="form-control">
                                    <option value="">Pilih Golongan Darah</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                </select>
                            </div>

                            <!-- Input Suku -->
                            <div class="mb-3">
                                <label for="suku" class="form-label">Suku</label>
                                <input type="text" id="suku" name="suku" class="form-control" required>
                            </div>

                            <!-- Input Status Merital -->
                            <div class="mb-3">
                                <label for="status_marital" class="form-label">Status Merital</label>
                                <input type="text" id="status_marital" name="status_marital" class="form-control"
                                    required>
                            </div>

                            <!-- Input Status Babtis -->
                            <div class="mb-3">
                                <label for="status_babtis" class="form-label">Status Babtis</label>
                                <select id="status_babtis" name="status_babtis" class="form-control">
                                    <option value="">Pilih Status Babtis</option>
                                    <option value="Sudah">Sudah</option>
                                    <option value="Belum">Belum</option>
                                </select>
                            </div>

                            <!-- Input Pendidikan Terakhir -->
                            <div class="mb-3">
                                <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                                <input type="text" id="pendidikan_terakhir" name="pendidikan_terakhir"
                                    class="form-control" required>
                            </div>

                           

                            <!-- Input Pekerjaan -->
                            <div class="mb-3">
                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                <input type="text" id="pekerjaan" name="pekerjaan" class="form-control" required>
                            </div>

                            <!-- Input Penghasilan -->
                            <div class="mb-3">
                                <label for="penghasilan" class="form-label">Penghasilan</label>
                                <input type="text" id="penghasilan" name="penghasilan" class="form-control" required>
                            </div>

                            <!-- Select Status Tempat Rumah -->
                            <div class="mb-3">
                                <label for="status_tempat_rumah" class="form-label">Status Tempat Rumah</label>
                                <select id="status_tempat_rumah" name="status_tempat_rumah" class="form-control"
                                    required>
                                    <option value="">Pilih Status Tempat Rumah</option>
                                    <option value="Milik Sendiri">Milik Sendiri</option>
                                    <option value="Sewa">Sewa</option>
                                    <option value="Menumpang">Menumpang</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                            <!-- Select Status Sidi -->
                            <div class="mb-3">
                                <label for="status_sidi" class="form-label">Status Sidi</label>
                                <select id="status_sidi" name="status_sidi" class="form-control" required>
                                    <option value="">Pilih Status Sidi</option>
                                    <option value="Sudah">Sudah</option>
                                    <option value="Belum">Belum</option>
                                </select>
                            </div>

                            <!-- Select Status Nikah -->
                            <div class="mb-3">
                                <label for="status_nikah" class="form-label">Status Nikah</label>
                                <select id="status_nikah" name="status_nikah" class="form-control" required>
                                    <option value="">Pilih Status Nikah</option>
                                    <option value="Kawin">Kawin</option>
                                    <option value="Belum Kawin">Belum Kawin</option>
                                </select>
                            </div>

                            <!-- Input Keper Setaan -->
                            <div class="mb-3">
                                <label for="keper_setaan" class="form-label">Keper Setaan</label>
                                <input type="text" id="keper_setaan" name="keper_setaan" class="form-control" required>
                            </div>

                            <!-- Input Jenis Bantuan Sosial -->
                            <div class="mb-3">
                                <label for="jenis_bantuan_sosial" class="form-label">Jenis Bantuan Sosial</label>
                                <input type="text" id="jenis_bantuan_sosial" name="jenis_bantuan_sosial"
                                    class="form-control" required>
                            </div>

                            <!-- Input Jenis Diakonia -->
                            <div class="mb-3">
                                <label for="jenis_diakonia" class="form-label">Jenis Diakonia</label>
                                <input type="text" id="jenis_diakonia" name="jenis_diakonia" class="form-control"
                                    required>
                            </div>

                            <!-- Textarea Keterangan -->
                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea id="keterangan" name="keterangan" class="form-control" rows="3"
                                    required></textarea>
                            </div>

                            <!-- Wrapper for the submit button to align it to the right -->
                            <div class="text-end">
                                <button type="button" id="closeTambahModal" data-bs-dismiss="modal" aria-label="Close"
                                    class="btn btn-secondary">Tutup</button>
                                <button type="button" onclick="submitForm()" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editDataModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDataModalLabel">Edit <?php echo $page_title ?></h5>
                        <button type="button" class="btn-close" id="closeEditModal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" method="POST" enctype="multipart/form-data">
                            <!-- Hidden input for ID Jemaat -->
                            <input type="hidden" id="edit_id" name="id_jemaat">

                            <!-- Input Nama Jemaat -->
                            <div class="mb-3">
                                <label for="edit_nama" class="form-label">Nama Jemaat</label>
                                <input type="text" id="edit_nama" name="nama" class="form-control" required>
                            </div>

                            <!-- Select Rayon -->
                            <div class="mb-3">
                                <label for="edit_id_rayon" class="form-label">Rayon</label>
                                <select id="edit_id_rayon" name="id_rayon" class="form-control" required>
                                    <option value="">Pilih Rayon</option>
                                    <?php
                                    $query_rayon = "SELECT id_rayon, nama_rayon FROM rayon";
                                    $result_rayon = $koneksi->query($query_rayon);
                                    while ($row_rayon = $result_rayon->fetch_assoc()) {
                                        echo "<option value='" . $row_rayon['id_rayon'] . "'>" . $row_rayon['nama_rayon'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Select Kepala Keluarga -->
                            <div class="mb-3">
                                <label for="edit_id_kk" class="form-label">Nomor Kepala Keluarga</label>
                                <select id="edit_id_kk" name="id_kk" class="form-control" required>
                                    <option value="">Pilih Kepala Keluarga</option>
                                    <?php
                                    $query_kk = "SELECT id_kk, no_kk FROM kk";
                                    $result_kk = $koneksi->query($query_kk);
                                    while ($row_kk = $result_kk->fetch_assoc()) {
                                        echo "<option value='" . $row_kk['id_kk'] . "'>" . $row_kk['no_kk'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Input NIK -->
                            <div class="mb-3">
                                <label for="edit_nik" class="form-label">NIK</label>
                                <input type="text" id="edit_nik" name="nik" class="form-control" required>
                            </div>

                            <!-- Input Jenis Kelamin -->
                            <div class="mb-3">
                                <label for="edit_jk" class="form-label">Jenis Kelamin</label>
                                <select id="edit_jk" name="jk" class="form-control" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>

                            <!-- Input Tempat Lahir -->
                            <div class="mb-3">
                                <label for="edit_tempat_lahir" class="form-label">Tempat Lahir</label>
                                <input type="text" id="edit_tempat_lahir" name="tempat_lahir" class="form-control"
                                    required>
                            </div>

                            <!-- Input Tanggal Lahir -->
                            <div class="mb-3">
                                <label for="edit_tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" id="edit_tanggal_lahir" name="tanggal_lahir" class="form-control"
                                    required>
                            </div>

                            <!-- Input Status dalam Rumah -->
                            <div class="mb-3">
                                <label for="edit_status_dalam_rumah" class="form-label">Status dalam Rumah</label>
                                <input type="text" id="edit_status_dalam_rumah" name="status_dalam_rumah"
                                    class="form-control" required>
                            </div>

                            <!-- Input Golongan Darah -->
                            <div class="mb-3">
                                <label for="edit_gol_darah" class="form-label">Golongan Darah</label>
                                <select id="edit_gol_darah" name="gol_darah" class="form-control">
                                    <option value="">Pilih Golongan Darah</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                </select>
                            </div>

                            <!-- Input Suku -->
                            <div class="mb-3">
                                <label for="edit_suku" class="form-label">Suku</label>
                                <input type="text" id="edit_suku" name="suku" class="form-control" required>
                            </div>

                            <!-- Input Status Merital -->
                            <div class="mb-3">
                                <label for="edit_status_marital" class="form-label">Status Merital</label>
                                <input type="text" id="edit_status_marital" name="status_marital" class="form-control"
                                    required>
                            </div>

                            <!-- Input Status Babtis -->
                            <div class="mb-3">
                                <label for="edit_status_babtis" class="form-label">Status Babtis</label>
                                <select id="edit_status_babtis" name="status_babtis" class="form-control">
                                    <option value="">Pilih Status Babtis</option>
                                    <option value="Sudah">Sudah</option>
                                    <option value="Belum">Belum</option>
                                </select>
                            </div>

                            <!--  -->
                            <!-- Input Pendidikan Terakhir -->
                            <div class="mb-3">
                                <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                                <input type="text" id="edit_pendidikan_terakhir" name="pendidikan_terakhir"
                                    class="form-control" required>
                            </div>

                           

                            <!-- Input Pekerjaan -->
                            <div class="mb-3">
                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                <input type="text" id="edit_pekerjaan" name="pekerjaan" class="form-control" required>
                            </div>

                            <!-- Input Penghasilan -->
                            <div class="mb-3">
                                <label for="penghasilan" class="form-label">Penghasilan</label>
                                <input type="text" id="edit_penghasilan" name="penghasilan" class="form-control"
                                    required>
                            </div>

                            <!-- Select Status Tempat Rumah -->
                            <div class="mb-3">
                                <label for="status_tempat_rumah" class="form-label">Status Tempat Rumah</label>
                                <select id="edit_status_tempat_rumah" name="status_tempat_rumah" class="form-control"
                                    required>
                                    <option value="">Pilih Status Tempat Rumah</option>
                                    <option value="Milik Sendiri">Milik Sendiri</option>
                                    <option value="Sewa">Sewa</option>
                                    <option value="Menumpang">Menumpang</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                            <!-- Select Status Sidi -->
                            <div class="mb-3">
                                <label for="status_sidi" class="form-label">Status Sidi</label>
                                <select id="edit_status_sidi" name="status_sidi" class="form-control" required>
                                    <option value="">Pilih Status Sidi</option>
                                    <option value="Sudah">Sudah</option>
                                    <option value="Belum">Belum</option>
                                </select>
                            </div>

                            <!-- Select Status Nikah -->
                            <div class="mb-3">
                                <label for="status_nikah" class="form-label">Status Nikah</label>
                                <select id="edit_status_nikah" name="status_nikah" class="form-control" required>
                                    <option value="">Pilih Status Nikah</option>
                                    <option value="Kawin">Kawin</option>
                                    <option value="Belum Kawin">Belum Kawin</option>
                                </select>
                            </div>

                            <!-- Input Keper Setaan -->
                            <div class="mb-3">
                                <label for="keper_setaan" class="form-label">Keper Setaan</label>
                                <input type="text" id="edit_keper_setaan" name="keper_setaan" class="form-control"
                                    required>
                            </div>

                            <!-- Input Jenis Bantuan Sosial -->
                            <div class="mb-3">
                                <label for="jenis_bantuan_sosial" class="form-label">Jenis Bantuan Sosial</label>
                                <input type="text" id="edit_jenis_bantuan_sosial" name="jenis_bantuan_sosial"
                                    class="form-control" required>
                            </div>

                            <!-- Input Jenis Diakonia -->
                            <div class="mb-3">
                                <label for="jenis_diakonia" class="form-label">Jenis Diakonia</label>
                                <input type="text" id="edit_jenis_diakonia" name="jenis_diakonia" class="form-control"
                                    required>
                            </div>

                            <!-- Textarea Keterangan -->
                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea id="edit_keterangan" name="keterangan" class="form-control" rows="3"
                                    required></textarea>
                            </div>


                            <!-- Wrapper for the submit button to align it to the right -->
                            <div class="text-end">
                                <button type="button" id="closeEditModal" data-bs-dismiss="modal" aria-label="Close"
                                    class="btn btn-secondary">Tutup</button>
                                <button type="button" onclick="submitEditForm()" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function openEditModal(id_jemaat, id_rayon, id_kk, nik, nama, jk, tempat_lahir, tanggal_lahir,
                status_dalam_rumah, gol_darah, suku, status_tempat_rumah, pendidikan_terakhir,
                pekerjaan, penghasilan, status_marital, status_babtis, status_sidi, status_nikah,
                keper_setaan, jenis_bantuan_sosial, jenis_diakonia, keterangan) {
                // Pastikan bootstrap.Modal diimpor dengan benar
                let editModal = new bootstrap.Modal(document.getElementById('editModal'));

                // Mengisi field edit dengan data yang diambil dari tabel
                document.getElementById('edit_id').value = id_jemaat;
                document.getElementById('edit_id_rayon').value = id_rayon;
                document.getElementById('edit_id_kk').value = id_kk;
                document.getElementById('edit_nama').value = nama;
                document.getElementById('edit_nik').value = nik;
                document.getElementById('edit_jk').value = jk;
                document.getElementById('edit_tempat_lahir').value = tempat_lahir;
                document.getElementById('edit_tanggal_lahir').value = tanggal_lahir;
                document.getElementById('edit_status_dalam_rumah').value = status_dalam_rumah;
                document.getElementById('edit_gol_darah').value = gol_darah;
                document.getElementById('edit_suku').value = suku;
                document.getElementById('edit_status_marital').value = status_marital;
                document.getElementById('edit_status_babtis').value = status_babtis;
                document.getElementById('edit_pendidikan_terakhir').value = pendidikan_terakhir;
                document.getElementById('edit_pekerjaan').value = pekerjaan;
                document.getElementById('edit_penghasilan').value = penghasilan;
                document.getElementById('edit_status_tempat_rumah').value = status_tempat_rumah;
                document.getElementById('edit_status_sidi').value = status_sidi;
                document.getElementById('edit_status_nikah').value = status_nikah;
                document.getElementById('edit_keper_setaan').value = keper_setaan;
                document.getElementById('edit_jenis_bantuan_sosial').value = jenis_bantuan_sosial;
                document.getElementById('edit_jenis_diakonia').value = jenis_diakonia;
                document.getElementById('edit_keterangan').value = keterangan;

                // Tampilkan modal
                editModal.show();
            }
        </script>

        <?php include 'fitur/proses_modal.php'; ?>
        <?php include 'fitur/footer.php'; ?>

    </main>

</body>

</html>