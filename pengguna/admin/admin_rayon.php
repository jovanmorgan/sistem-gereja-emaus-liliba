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
            // Ambil data admin_rayon dari database
            include '../../keamanan/koneksi.php';

            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = 10;
            $offset = ($page - 1) * $limit;

            // Query untuk mendapatkan data admin_rayon dengan pencarian, pagination, dan gabungan dengan tabel rayon
            $query = "SELECT admin_rayon.*, rayon.nama_rayon FROM admin_rayon 
          LEFT JOIN rayon ON admin_rayon.id_rayon = rayon.id_rayon 
          WHERE admin_rayon.id_admin_rayon LIKE ? 
          OR admin_rayon.nama LIKE ? 
          OR admin_rayon.username LIKE ? 
          OR admin_rayon.password LIKE ? 
          LIMIT ?, ?";
            $stmt = $koneksi->prepare($query);
            $search_param = '%' . $search . '%';
            $stmt->bind_param("ssssii", $search_param, $search_param, $search_param, $search_param, $offset, $limit);
            $stmt->execute();
            $result = $stmt->get_result();

            // Hitung total halaman
            $total_query = "SELECT COUNT(*) as total FROM admin_rayon 
                LEFT JOIN rayon ON admin_rayon.id_rayon = rayon.id_rayon 
                WHERE admin_rayon.id_admin_rayon LIKE ? 
                OR admin_rayon.nama LIKE ? 
                OR admin_rayon.username LIKE ? 
                OR admin_rayon.password LIKE ?";
            $stmt_total = $koneksi->prepare($total_query);
            $stmt_total->bind_param("ssss", $search_param, $search_param, $search_param, $search_param);
            $stmt_total->execute();
            $total_result = $stmt_total->get_result();
            $total_row = $total_result->fetch_assoc();
            $total_pages = ceil($total_row['total'] / $limit);
            ?>

            <!-- HTML Table -->
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
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                                    Nama</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                                    Username</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                                    Password</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                                    Nama Rayon</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                                    Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $nomor = $offset + 1;
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
                                                            class="text-secondary text-xs font-weight-bold"><?php echo $row['username']; ?></span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span
                                                            class="text-secondary text-xs font-weight-bold"><?php echo $row['password']; ?></span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span
                                                            class="text-secondary text-xs font-weight-bold"><?php echo $row['nama_rayon']; ?></span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <button class="btn btn-warning btn-sm"
                                                            onclick="openEditModal('<?php echo $row['id_admin_rayon']; ?>', '<?php echo $row['nama']; ?>', '<?php echo $row['username']; ?>', '<?php echo $row['password']; ?>', '<?php echo $row['id_rayon']; ?>')">Edit</button>
                                                        <button class="btn btn-danger btn-sm"
                                                            onclick="hapus('<?php echo $row['id_admin_rayon']; ?>')">Hapus</button>
                                                    </td>
                                                </tr>
                                            <?php
                                                $nomor++;
                                            endwhile;
                                            ?>
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
                                <label for="nama" class="form-label">Nama Ketua mjh</label>
                                <input type="text" id="nama" name="nama" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="text" id="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="id_rayon" class="form-label">Rayon</label>
                                <select id="id_rayon" name="id_rayon" class="form-control" required>
                                    <option value="" selected>Silakan pilih</option>
                                    <?php
                                    // Ambil data rayon dari database
                                    $rayon_query = "SELECT * FROM rayon";
                                    $rayon_result = $koneksi->query($rayon_query);
                                    while ($rayon = $rayon_result->fetch_assoc()) {
                                        echo "<option value='{$rayon['id_rayon']}'>{$rayon['nama_rayon']}</option>";
                                    }
                                    ?>
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
                        <h5 class="modal-title" id="editDataModalLabel">Edit <?php echo $page_title ?></h5>
                        <button type="button" class="btn-close" id="closeEditModal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" method="POST" enctype="multipart/form-data">
                            <input type="hidden" id="id_admin_rayon" name="id_admin_rayon">
                            <div class="mb-3">
                                <label for="edit_nama" class="form-label">Nama </label>
                                <input type="text" id="edit_nama" name="nama" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_username" class="form-label">Username</label>
                                <input type="text" id="edit_username" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_password" class="form-label">Password</label>
                                <input type="text" id="edit_password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_id_rayon" class="form-label">Rayon</label>
                                <select id="edit_id_rayon" name="id_rayon" class="form-control" required>
                                    <option value="" selected>Silakan pilih</option>
                                    <?php
                                    // Ambil data rayon dari database
                                    $rayon_query = "SELECT * FROM rayon";
                                    $rayon_result = $koneksi->query($rayon_query);
                                    while ($rayon = $rayon_result->fetch_assoc()) {
                                        echo "<option value='{$rayon['id_rayon']}'>{$rayon['nama_rayon']}</option>";
                                    }
                                    ?>
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
            function openEditModal(id_admin_rayon, nama, username, password, id_rayon) {
                let editModal = new bootstrap.Modal(document.getElementById('editModal'));
                document.getElementById('id_admin_rayon').value = id_admin_rayon;
                document.getElementById('edit_nama').value = nama;
                document.getElementById('edit_username').value = username;
                document.getElementById('edit_password').value = password;
                document.getElementById('edit_id_rayon').value = id_rayon; // Set selected rayon
                editModal.show();
            }
        </script>
        <?php include 'fitur/proses_modal.php'; ?>
        <?php include 'fitur/footer.php'; ?>

    </main>

</body>

</html>