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

                    <div class="card-body">
                        <div class="table-responsive">

                            <?php if ($result->num_rows > 0): ?>
                                <table id="example" class="table table-hover text-center mt-3"
                                    style="border-collapse: separate; border-spacing: 0;">
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
                                        $nomor = $offset + 1; // Mulai nomor urut dari $offset + 1
                                        while ($row = $result->fetch_assoc()) :
                                            $warna = ($row['status_dalam_rumah'] === "Kepala Keluarga") ? "background-color: #2fa07b;" : "background-color: white;";
                                        ?>
                                            <tr style="<?php echo $warna; ?>">
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

    <!-- Tautan ke file jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Tautan ke file JavaScript DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js"></script>
    <!-- Tautan ke file JavaScript untuk ekspor -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'pdfHtml5',
                        text: 'PDF A3',
                        customize: function(doc) {
                            doc.pageSize = 'A3';
                            doc.content[1].table.headerRows = 1;
                            doc.content[1].table.body[0].forEach(function(col) {
                                col.fillColor = '#ffffff';
                            });
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'PDF A4',
                        customize: function(doc) {
                            doc.pageSize = 'A4';
                            doc.content[1].table.headerRows = 1;
                            doc.content[1].table.body[0].forEach(function(col) {
                                col.fillColor = '#cccccc';
                            });
                        }
                    },
                    'copy', 'csv', 'excel', 'print'
                ]
            });
        });
    </script>

</body>

</html>