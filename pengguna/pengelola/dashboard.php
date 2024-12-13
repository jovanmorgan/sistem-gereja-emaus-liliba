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

        <?php
        include '../../keamanan/koneksi.php';

        // Query data untuk chart
        $queries = [
            'atestasi' => "SELECT jemaat.nama, COUNT(atestasi.id_jemaat) as count FROM atestasi INNER JOIN jemaat ON atestasi.id_jemaat = jemaat.id_jemaat GROUP BY jemaat.nama ORDER BY count DESC LIMIT 5",
            'babtis' => "SELECT tanggal_babtis as tanggal, COUNT(id_jemaat) as count FROM babtis GROUP BY tanggal_babtis ORDER BY tanggal_babtis DESC",
            'nikah' => "SELECT tanggal_nikah as tanggal, COUNT(id_jemaat) as count FROM nikah GROUP BY tanggal_nikah ORDER BY tanggal_nikah DESC",
            'pindah_agama' => "SELECT tanggal_pindah as tanggal, COUNT(id_jemaat) as count FROM pindah_agama GROUP BY tanggal_pindah ORDER BY tanggal_pindah DESC",
            'sidi' => "SELECT tanggal_sidi as tanggal, COUNT(id_jemaat) as count FROM sidi GROUP BY tanggal_sidi ORDER BY tanggal_sidi DESC"
        ];

        $chartData = [];

        foreach ($queries as $key => $query) {
            $result = mysqli_query($koneksi, $query);
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = [
                    'label' => isset($row['nama']) ? $row['nama'] : $row['tanggal'],  // Sesuaikan label untuk atestasi
                    'count' => $row['count']
                ];
            }
            $chartData[$key] = $data;
        }

        // Query data untuk summary
        $tables = [
            'atestasi' => ['label' => 'Atestasi', 'icon' => 'fas fa-church', 'color' => '#FFC107'],
            'babtis' => ['label' => 'Babtis', 'icon' => 'fas fa-water', 'color' => '#DC3545'],
            'jemaat' => ['label' => 'Jemaat', 'icon' => 'fas fa-users', 'color' => '#0D6EFD'],
            'pindah_agama' => ['label' => 'Pindah Agama', 'icon' => 'fas fa-exchange-alt', 'color' => '#198754'],
            'sidi' => ['label' => 'Sidi', 'icon' => 'fas fa-book', 'color' => '#6C757D']
        ];

        $counts = [];

        foreach ($tables as $table => $details) {
            $query = "SELECT COUNT(*) as count FROM $table";
            $result = mysqli_query($koneksi, $query);
            $row = mysqli_fetch_assoc($result);
            $counts[$table] = $row['count'];
            mysqli_free_result($result);
        }

        mysqli_close($koneksi);

        // Convert data to JSON for Chart.js
        $chartDataJson = json_encode($chartData);
        ?>

        <script>
            var chartData = <?php echo $chartDataJson; ?>;
        </script>
        <div class="container-fluid py-4">

            <!-- Row for charts -->
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-lg">
                        <div class="card-header bg-gradient-primary text-white">
                            <h5 class="card-title">Atestasi</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="atestasiChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-lg">
                        <div class="card-header bg-gradient-success text-white">
                            <h5 class="card-title">Babtis</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="babtisChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-lg">
                        <div class="card-header bg-gradient-info text-white">
                            <h5 class="card-title">Nikah</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="nikahChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-lg">
                        <div class="card-header bg-gradient-danger text-white">
                            <h5 class="card-title">Pindah Agama</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="pindahAgamaChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-lg">
                        <div class="card-header bg-gradient-warning text-white">
                            <h5 class="card-title">Sidi</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="sidiChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row for summary cards -->
            <div class="row">
                <!-- Kartu Jumlah Data -->
                <?php foreach ($tables as $table => $details): ?>
                    <div class="col-xl-3 col-sm-6 mb-4">
                        <div class="card shadow-lg">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="numbers">
                                            <p class="text-sm mb-0 text-uppercase font-weight-bold">
                                                <?= $details['label']; ?>
                                            </p>
                                            <h5 class="font-weight-bolder mb-0">
                                                <?= $counts[$table]; ?>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <div
                                            class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                            <i class="<?= $details['icon']; ?> text-lg opacity-10" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php include 'fitur/footer.php'; ?>
    </main>

    <!-- Core JS Files -->
    <script src="../../assets/js/core/popper.min.js"></script>
    <script src="../../assets/js/core/bootstrap.min.js"></script>
    <script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="../../assets/js/plugins/chartjs.min.js"></script>
    <script>
        // Generate chart data for atestasi
        function generateChart(canvasId, chartData, label) {
            var ctx = document.getElementById(canvasId).getContext('2d');
            var labels = chartData.map(data => data.label);
            var dataCounts = chartData.map(data => data.count);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: dataCounts,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        var chartData = <?php echo $chartDataJson; ?>;

        // Generate charts for all categories
        generateChart('atestasiChart', chartData.atestasi, 'Atestasi Terbanyak');
        generateChart('babtisChart', chartData.babtis, 'Babtis Terbanyak');
        generateChart('nikahChart', chartData.nikah, 'Nikah Terbanyak');
        generateChart('pindahAgamaChart', chartData.pindah_agama, 'Pindah Agama Terbanyak');
        generateChart('sidiChart', chartData.sidi, 'Sidi Terbanyak');
    </script>

    <script>
        var win = navigator.platform.indexOf("Win") > -1;
        if (win && document.querySelector("#sidenav-scrollbar")) {
            var options = {
                damping: "0.5",
            };
            Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
        }
    </script>

    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>