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

            // Query untuk mendapatkan data babtis dengan pencarian, pagination, dan nama jemaat
            $query = "SELECT babtis.id_babtis, babtis.id_jemaat, babtis.nama_saksi, babtis.pelayanan, babtis.tanggal_babtis, babtis.tempat, jemaat.nama, kk.no_kk, rayon.nama_rayon
          FROM babtis
          JOIN jemaat ON babtis.id_jemaat = jemaat.id_jemaat
          JOIN kk ON jemaat.id_kk = kk.id_kk
          JOIN rayon ON jemaat.id_rayon = rayon.id_rayon
          WHERE babtis.nama_saksi LIKE ? OR babtis.pelayanan LIKE ? OR babtis.tanggal_babtis LIKE ? OR babtis.tempat LIKE ?
          LIMIT ?, ?";
            $stmt = $koneksi->prepare($query);
            $search_param = '%' . $search . '%';
            $stmt->bind_param("ssssii", $search_param, $search_param, $search_param, $search_param, $offset, $limit);
            $stmt->execute();
            $result = $stmt->get_result();

            // Hitung total halaman
            $total_query = "SELECT COUNT(*) as total
                FROM babtis
                WHERE nama_saksi LIKE ? OR pelayanan LIKE ? OR tanggal_babtis LIKE ? OR tempat LIKE ?";
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
                                                    Nama Rayon
                                                </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                                    Nama Saksi
                                                </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                                    Pelayanan
                                                </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                                    Tanggal_babtis Pelayanan
                                                </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                                    Tempat
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
                                                            class="text-secondary text-xs font-weight-bold"><?php echo $row['nama_rayon']; ?></span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span
                                                            class="text-secondary text-xs font-weight-bold"><?php echo $row['nama_saksi']; ?></span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span
                                                            class="text-secondary text-xs font-weight-bold"><?php echo $row['pelayanan']; ?></span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span
                                                            class="text-secondary text-xs font-weight-bold"><?php echo $row['tanggal_babtis']; ?></span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span
                                                            class="text-secondary text-xs font-weight-bold"><?php echo $row['tempat']; ?></span>
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
                                <label for="nama_saksi" class="form-label">Nama Saksi</label>
                                <input type="text" id="nama_saksi" name="nama_saksi" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="pelayanan" class="form-label">Pelayanan</label>
                                <input type="text" id="pelayanan" name="pelayanan" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_babtis" class="form-label">Tanggal_babtis Pelayanan</label>
                                <input type="date" id="tanggal_babtis" name="tanggal_babtis" class="form-control"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="tempat" class="form-label">Tempat</label>
                                <input type="text" id="tempat" name="tempat" class="form-control" required>
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
                            <input type="hidden" id="edit_id_babtis" name="id_babtis">

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
                                <label for="edit_nama_saksi" class="form-label">Nama Saksi</label>
                                <input type="text" id="edit_nama_saksi" name="nama_saksi" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_pelayanan" class="form-label">Pelayanan</label>
                                <input type="text" id="edit_pelayanan" name="pelayanan" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_tanggal_babtis" class="form-label">Tanggal_babtis Pelayanan</label>
                                <input type="date" id="edit_tanggal_babtis" name="tanggal_babtis" class="form-control"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_tempat" class="form-label">Tempat</label>
                                <input type="text" id="edit_tempat" name="tempat" class="form-control" required>
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
            function openEditModal(id_babtis, id_jemaat, nama_saksi, pelayanan, tanggal_babtis, tempat) {
                let editModal = new bootstrap.Modal(document.getElementById('editModal'));
                document.getElementById('edit_id_babtis').value = id_babtis;
                document.getElementById('edit_id_jemaat').value = id_jemaat;
                document.getElementById('edit_nama_saksi').value = nama_saksi;
                document.getElementById('edit_pelayanan').value = pelayanan;
                document.getElementById('edit_tanggal_babtis').value = tanggal_babtis;
                document.getElementById('edit_tempat').value = tempat;

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