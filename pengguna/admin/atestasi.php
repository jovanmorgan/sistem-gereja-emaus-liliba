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
            include '../../keamanan/koneksi.php';

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
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                                Aksi
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
                                            <td class="align-middle text-center">
                                                <button class="btn btn-warning btn-sm"
                                                    onclick="openEditModal('<?php echo $row['id_atestasi']; ?>','<?php echo $row['id_jemaat']; ?>', '<?php echo $row['gereja_asal']; ?>', '<?php echo $row['gereja_tujuan']; ?>', '<?php echo $row['status']; ?>')">Edit</button>

                                                <button class="btn btn-danger btn-sm"
                                                    onclick="hapus('<?php echo $row['id_atestasi']; ?>')">Hapus</button>
                                            </td>
                                        </tr>
                                        <?php $nomor++;
                                            endwhile; ?>
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

        <!-- Modal Tambah -->
        <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data <?php echo $page_title ?></h5>
                        <button type="button" class="btn-close" id="closeTambahModal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="tambahForm" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="id_jemaat_tambah" class="form-label">Nama Jemaat</label>
                                <select id="id_jemaat_tambah" name="id_jemaat" class="form-select" required>
                                    <option value="" selected>Silakan pilih jemaat</option>
                                    <?php
                                    // Query to fetch jemaat data
                                    $jemaat_query = "SELECT id_jemaat, nama FROM jemaat";
                                    $jemaat_result = mysqli_query($koneksi, $jemaat_query);
                                    while ($row = mysqli_fetch_assoc($jemaat_result)) {
                                        echo "<option value=\"{$row['id_jemaat']}\">{$row['nama']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="gereja_asal" class="form-label">Gereja Asal</label>
                                <input type="text" id="gereja_asal" name="gereja_asal" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="gereja_tujuan" class="form-label">Gereja Tujuan</label>
                                <input type="text" id="gereja_tujuan" name="gereja_tujuan" class="form-control"
                                    required>
                            </div>
                            <!-- Select Status Sidi -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status Ateistasi</label>
                                <select id="status" name="status" class="form-control" required>
                                    <option value="">Pilih Status Ateistasi</option>
                                    <option value="Sudah Pernah">Sudah Pernah</option>
                                    <option value="Belum Pernah">Belum Pernah</option>
                                </select>
                            </div>
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
                        <h5 class="modal-title" id="editDataModalLabel">Edit Data <?php echo $page_title ?></h5>
                        <button type="button" class="btn-close" id="closeEditModal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" method="POST" enctype="multipart/form-data">
                            <input type="hidden" id="edit_id_atestasi" name="id_atestasi">

                            <div class="mb-3">
                                <label for="edit_id_jemaat" class="form-label">Nama Jemaat</label>
                                <select id="edit_id_jemaat" name="id_jemaat" class="form-select" required>
                                    <option value="" selected>Silakan pilih jemaat</option>
                                    <?php
                                    // Query to fetch jemaat data
                                    $jemaat_query = "SELECT id_jemaat, nama FROM jemaat";
                                    $jemaat_result = mysqli_query($koneksi, $jemaat_query);
                                    while ($row = mysqli_fetch_assoc($jemaat_result)) {
                                        echo "<option value=\"{$row['id_jemaat']}\">{$row['nama']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit_gereja_asal" class="form-label">Gereja Asal</label>
                                <input type="text" id="edit_gereja_asal" name="gereja_asal" class="form-control"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_gereja_tujuan" class="form-label">Gereja Tujuan</label>
                                <input type="text" id="edit_gereja_tujuan" name="gereja_tujuan" class="form-control"
                                    required>
                            </div>
                            <!-- Select Status Sidi -->
                            <div class="mb-3">
                                <label for="edit_status" class="form-label">Status Ateistasi</label>
                                <select id="edit_status" name="status" class="form-control" required>
                                    <option value="">Pilih Status Ateistasi</option>
                                    <option value="Sudah Pernah">Sudah Pernah</option>
                                    <option value="Belum Pernah">Belum Pernah</option>
                                </select>
                            </div>
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
        function openEditModal(id_atestasi, id_jemaat, gereja_asal, gereja_tujuan, status) {
            let editModal = new bootstrap.Modal(document.getElementById('editModal'));
            document.getElementById('edit_id_atestasi').value = id_atestasi;
            document.getElementById('edit_id_jemaat').value = id_jemaat;
            document.getElementById('edit_gereja_asal').value = gereja_asal;
            document.getElementById('edit_gereja_tujuan').value = gereja_tujuan;
            document.getElementById('edit_status').value = status;

            // Set the selected option for id_jemaat
            let selectElement = document.getElementById('edit_id_jemaat');
            selectElement.value = id_jemaat;

            editModal.show();
        }
        </script>

        <?php include 'fitur/proses_modal.php'; ?>
        <?php include 'fitur/footer.php'; ?>

    </main>

</body>

</html>