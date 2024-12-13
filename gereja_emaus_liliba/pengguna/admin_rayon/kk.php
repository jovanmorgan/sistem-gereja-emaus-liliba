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

            // Query untuk mendapatkan data kk dengan pencarian, pagination, dan nama rayon
            $query = "SELECT kk.id_kk, kk.id_rayon, kk.no_kk, kk.nama_kepala_keluarga, rayon.nama_rayon
          FROM kk
          JOIN rayon ON kk.id_rayon = rayon.id_rayon
          WHERE kk.no_kk LIKE ? OR kk.nama_kepala_keluarga LIKE ?
          LIMIT ?, ?";
            $stmt = $koneksi->prepare($query);
            $search_param = '%' . $search . '%';
            $stmt->bind_param("ssii", $search_param, $search_param, $offset, $limit);
            $stmt->execute();
            $result = $stmt->get_result();

            // Hitung total halaman
            $total_query = "SELECT COUNT(*) as total
                FROM kk
                WHERE no_kk LIKE ? OR nama_kepala_keluarga LIKE ?";
            $stmt_total = $koneksi->prepare($total_query);
            $stmt_total->bind_param("ss", $search_param, $search_param);
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
                                                Nomor KK
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                                Nama Kepala Keluarga
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                                Nama Rayon
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
                                                    class="text-secondary text-xs font-weight-bold"><?php echo $row['no_kk']; ?></span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold"><?php echo $row['nama_kepala_keluarga']; ?></span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold"><?php echo $row['nama_rayon']; ?></span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <button class="btn btn-warning btn-sm"
                                                    onclick="openEditModal('<?php echo $row['id_kk']; ?>','<?php echo $row['id_rayon']; ?>', '<?php echo $row['no_kk']; ?>', '<?php echo $row['nama_kepala_keluarga']; ?>')">Edit</button>

                                                <button class="btn btn-danger btn-sm"
                                                    onclick="hapus('<?php echo $row['id_kk']; ?>')">Hapus</button>
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
                        <h5 class="modal-title" id="tambahDataModalLabel">Tambah <?php echo $page_title ?></h5>
                        <button type="button" class="btn-close" id="closeTambahModal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="tambahForm" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="id_rayon_tambah" class="form-label">Rayon</label>
                                <select id="id_rayon_tambah" name="id_rayon" class="form-select" required>
                                    <option value="" selected>Silakan diisi</option>
                                    <?php
                                    // Query to fetch rayon data
                                    $rayon_query = "SELECT id_rayon, nama_rayon FROM rayon";
                                    $rayon_result = mysqli_query($koneksi, $rayon_query);
                                    while ($row = mysqli_fetch_assoc($rayon_result)) {
                                        echo "<option value=\"{$row['id_rayon']}\">{$row['nama_rayon']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="no_kk" class="form-label">Nama KK</label>
                                <input type="text" id="no_kk" name="no_kk" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="nama_kepala_keluarga" class="form-label">Nama KK</label>
                                <input type="text" id="nama_kepala_keluarga" name="nama_kepala_keluarga"
                                    class="form-control" required>
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

        <?php
        include '../../keamanan/koneksi.php';

        // Query untuk mendapatkan data rayon
        $rayon_query = "SELECT id_rayon, nama_rayon FROM rayon";
        $rayon_result = mysqli_query($koneksi, $rayon_query);
        ?>
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
                            <input type="hidden" id="edit_id_kk" name="id_kk">

                            <div class="mb-3">
                                <label for="edit_id_rayon" class="form-label">Rayon</label>
                                <select id="edit_id_rayon" name="id_rayon" class="form-select" required>
                                    <option value="" selected>Silakan diisi</option>
                                    <?php
                                    // Mengisi opsi dengan data rayon
                                    while ($row = mysqli_fetch_assoc($rayon_result)) {
                                        echo "<option value=\"{$row['id_rayon']}\">{$row['nama_rayon']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit_no_kk" class="form-label">Nomor KK</label>
                                <input type="text" id="edit_no_kk" name="no_kk" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_nama_kepala_keluarga" class="form-label">Nama Kepala Keluarga</label>
                                <input type="text" id="edit_nama_kepala_keluarga" name="nama_kepala_keluarga"
                                    class="form-control" required>
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
        function openEditModal(id_kk, id_rayon, no_kk, nama_kepala_keluarga) {
            let editModal = new bootstrap.Modal(document.getElementById('editModal'));
            document.getElementById('edit_id_kk').value = id_kk;
            document.getElementById('edit_no_kk').value = no_kk;
            document.getElementById('edit_nama_kepala_keluarga').value = nama_kepala_keluarga;

            // Set the selected option for id_rayon
            let selectElement = document.getElementById('edit_id_rayon');
            selectElement.value = id_rayon;

            editModal.show();
        }
        </script>

        <?php include 'fitur/proses_modal.php'; ?>
        <?php include 'fitur/footer.php'; ?>

    </main>

</body>

</html>