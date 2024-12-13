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

        $queryStatus = "SELECT 
    status, 
    COUNT(*) as count 
    FROM atestasi 
    GROUP BY status";

        $resultStatus = mysqli_query($koneksi, $queryStatus);

        $statusData = [];
        $total = 0;

        while ($row = mysqli_fetch_assoc($resultStatus)) {
            $statusData[] = [
                'status' => $row['status'],
                'count' => $row['count']
            ];
            $total += $row['count'];
        }

        // Konversi data ke JSON untuk Chart.js
        $statusDataJson = json_encode($statusData);

        // Query untuk menghitung jumlah jemaat yang sudah dibaptis
        $querySudahBabtis = "SELECT COUNT(jemaat.id_jemaat) AS total_sudah FROM jemaat 
                     INNER JOIN babtis ON jemaat.id_jemaat = babtis.id_jemaat";

        // Query untuk menghitung jumlah jemaat yang belum dibaptis
        $queryBelumBabtis = "SELECT COUNT(jemaat.id_jemaat) AS total_belum FROM jemaat 
                     LEFT JOIN babtis ON jemaat.id_jemaat = babtis.id_jemaat 
                     WHERE babtis.id_jemaat IS NULL";

        $resultSudahBabtis = mysqli_query($koneksi, $querySudahBabtis);
        $resultBelumBabtis = mysqli_query($koneksi, $queryBelumBabtis);

        $sudahBabtis = mysqli_fetch_assoc($resultSudahBabtis)['total_sudah'];
        $belumBabtis = mysqli_fetch_assoc($resultBelumBabtis)['total_belum'];

        // Konversi ke format JSON untuk digunakan pada Chart.js
        $babtisData = json_encode([
            'sudahBabtis' => $sudahBabtis,
            'belumBabtis' => $belumBabtis
        ]);


        // Query data untuk chart
        $queries = [
            'pengelola' => "SELECT pengelola.nama, COUNT(id_pengelola) as count FROM pengelola GROUP BY nama ORDER BY nama DESC",
            'ketua_mjh' => "SELECT ketua_mjh.nama, COUNT(id_ketua_mjh) as count FROM ketua_mjh GROUP BY nama ORDER BY nama DESC",
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


        // Query untuk mendapatkan data rayon dan menghitung jumlah jemaat per rayon
        $query = "SELECT rayon.nama_rayon, COUNT(jemaat.id_rayon) as total_jemaat
          FROM rayon
          LEFT JOIN jemaat ON rayon.id_rayon = jemaat.id_rayon
          GROUP BY rayon.nama_rayon
          ORDER BY total_jemaat DESC";

        $result = mysqli_query($koneksi, $query);
        $rayonData = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $rayonData[] = [
                'label' => $row['nama_rayon'],
                'count' => $row['total_jemaat']
            ];
        }

        // Konversi data ke format JSON untuk Chart.js
        $rayonDataJson = json_encode($rayonData);

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
                <div class="col-lg-12 mb-4">
                    <div class="card shadow-lg">
                        <div class="card-header bg-gradient-success text-white">
                            <h5 class="card-title">Semua Data Rayon</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="rayonPieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-lg">
                        <div class="card-header bg-gradient-warning text-white">
                            <h5 class="card-title">Pengelola</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="pengelolaChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-lg">
                        <div class="card-header bg-gradient-info text-white">
                            <h5 class="card-title">Ketua MJH</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="ketua_mjhChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-lg">
                        <div class="card-header bg-gradient-primary text-white">
                            <h5 class="card-title">Status Atestasi</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="statusPieChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-lg">
                        <div class="card-header bg-gradient-primary text-white">
                            <h5 class="card-title">Status Babtis Jemaat</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="babtisStatusChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-lg">
                        <div class="card-header bg-gradient-info text-white">
                            <h5 class="card-title">Nikah Terbanyak</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="nikahChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-lg">
                        <div class="card-header bg-gradient-danger text-white">
                            <h5 class="card-title">Pindah Agama Terbanyak</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="pindahAgamaChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-lg">
                        <div class="card-header bg-gradient-warning text-white">
                            <h5 class="card-title">Sidi Terbanyak</h5>
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
    // Ambil data dari PHP
    var statusData = <?php echo $statusDataJson; ?>;
    var totalStatus = <?php echo $total; ?>;

    // Siapkan label, data, dan persentase
    var labels = statusData.map(data => `${data.status} (${((data.count / totalStatus) * 100).toFixed(1)}%)`);
    var dataCounts = statusData.map(data => data.count);

    // Warna untuk potongan pie
    var statusColors = ['#FF6384', '#36A2EB'];

    var ctxStatus = document.getElementById('statusPieChart').getContext('2d');
    new Chart(ctxStatus, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: dataCounts,
                backgroundColor: statusColors,
                borderColor: '#ffffff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var label = context.label || '';
                            return `${label}: ${context.raw} data`;
                        }
                    }
                }
            }
        }
    });

    // Ambil data dari PHP
    var babtisData = <?php echo $babtisData; ?>;

    // Siapkan data untuk chart
    var data = {
        labels: ['Sudah Babtis', 'Belum Babtis'],
        datasets: [{
            data: [babtisData.sudahBabtis, babtisData.belumBabtis],
            backgroundColor: ['#36A2EB', '#FF6384'], // Warna untuk setiap kategori
            borderColor: '#ffffff',
            borderWidth: 1
        }]
    };

    // Inisialisasi Chart.js
    var ctx = document.getElementById('babtisStatusChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var label = context.label || '';
                            var value = context.raw || 0;
                            var total = babtisData.sudahBabtis + babtisData.belumBabtis;
                            var percentage = ((value / total) * 100).toFixed(2);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });


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
    generateChart('pengelolaChart', chartData.pengelola, 'Data Pengelola');
    generateChart('ketua_mjhChart', chartData.ketua_mjh, 'Ketua MJH Pengelola');
    generateChart('nikahChart', chartData.nikah, 'Nikah Terbanyak');
    generateChart('pindahAgamaChart', chartData.pindah_agama, 'Pindah Agama Terbanyak');
    generateChart('sidiChart', chartData.sidi, 'Sidi Terbanyak');

    // Ambil data dari PHP
    var rayonData = <?php echo $rayonDataJson; ?>;

    // Siapkan label dan data untuk Chart.js
    var labels = rayonData.map(data => data.label);
    var dataCounts = rayonData.map(data => data.count);

    // Warna-warna untuk setiap potongan grafik
    var backgroundColors = [
        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
        '#FF9F40', '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'
    ];

    // Inisiasi Chart.js Pie Chart
    var ctx = document.getElementById('rayonPieChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Jemaat per Rayon',
                data: dataCounts,
                backgroundColor: backgroundColors,
                borderColor: '#ffffff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var label = context.label || '';
                            var value = context.raw || 0;
                            return `${label}: ${value} jemaat`;
                        }
                    }
                }
            }
        }
    });
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