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

        <div class="container-fluid">
            <div class="page-header min-height-300 border-radius-xl mt-4" style="
            background-image: url('../../assets/img/curved-images/curved0.jpg');
            background-position-y: 50%;
          ">
                <span class="mask bg-gradient-primary opacity-6"></span>
            </div>
            <?php
            // Lakukan koneksi ke database
            include '../../keamanan/koneksi.php';

            // Periksa apakah session id_pengelola telah diset
            if (isset($_SESSION['id_pengelola'])) {
                $id_pengelola = $_SESSION['id_pengelola'];

                // Query SQL untuk mengambil data pengelola berdasarkan id_pengelola dari session
                $query = "SELECT * FROM pengelola WHERE id_pengelola = '$id_pengelola'";
                $result = mysqli_query($koneksi, $query);

                // Periksa apakah query berhasil dieksekusi
                if ($result) {
                    // Periksa apakah terdapat data pengelola
                    if (mysqli_num_rows($result) > 0) {
                        // Ambil data pengelola sebagai array asosiatif
                        $pengelola = mysqli_fetch_assoc($result);
            ?>
                        <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
                            <div class="row gx-4">
                                <div class="col-auto">
                                    <div class="avatar avatar-xl position-relative">
                                        <a href="javascript:void(0)" onclick="document.getElementById('editFotoProfile').click()">
                                            <?php if (!empty($pengelola['fp'])): ?>
                                                <img src="../../assets/img/fp_pengguna/pengelola/<?php echo $pengelola['fp']; ?>"
                                                    alt="profile_image" class="w-100 border-radius-lg shadow-sm" />
                                            <?php else: ?>
                                                <img src="../../assets/img/bruce-mars.jpg" alt="profile_image"
                                                    class="w-100 border-radius-lg shadow-sm" />
                                            <?php endif; ?>
                                        </a>
                                        <!-- Input file tersembunyi untuk memilih gambar -->
                                        <input type="file" class="d-none" id="editFotoProfile" name="editFotoProfile"
                                            accept="image/*" onchange="previewAndUpdateProfile(this)">

                                    </div>
                                </div>
                                <div class="col-auto my-auto">
                                    <div class="h-100">
                                        <h5 class="mb-1"><?php echo $pengelola['nama']; ?></h5>
                                        <p class="mb-0 font-weight-bold text-sm"><?php echo $pengelola['nama']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="editFotoProfileModal" tabindex="-1" aria-labelledby="editFotoProfileModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editFotoProfileModalLabel">Edit
                            Foto Profile
                        </h5>
                        <button type="button" class="btn-close" id="closeTambahModal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="gambar">
                            <img id="editFotoProfilePreview" src="#" alt="Preview Foto Profile" class="img-fluid">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            onclick="location.reload();">Close</button>
                        <button type="button" class="btn btn-primary" id="btnSaveProfile">Save
                            changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid py-4">
            <div class="row">

                <div class="d-flex justify-content-center">
                    <div class="col-12 col-xl-6">
                        <div class="card h-100">
                            <div class="card-header pb-0 p-3">
                                <div class="row">
                                    <div class="col-md-8 d-flex align-items-center">
                                        <h5 class="mb-0 text-center">Detail Profile Anda</h5>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <a href="javascript:;">
                                            <i class="fas fa-user-edit text-secondary text-sm" data-bs-toggle="modal"
                                                data-bs-target="#editprofile"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <ul class="list-group">
                                    <li class="list-group-item border-0 ps-0 text-sm">
                                        <strong class="text-dark">Full Name:</strong> &nbsp;
                                        <?php echo $pengelola['nama']; ?>
                                    </li>
                                    <li class="list-group-item border-0 ps-0 text-sm">
                                        <strong class="text-dark">Username:</strong> &nbsp;
                                        <?php echo $pengelola['username']; ?>
                                    </li>
                                    <li class="list-group-item border-0 ps-0 text-sm">
                                        <strong class="text-dark">Password:</strong> &nbsp;
                                        <?php echo $pengelola['password']; ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <?php include 'fitur/footer.php'; ?>

        </div>
        <!-- Modal -->
        <div class="modal fade" id="editprofile" tabindex="-1" aria-labelledby="editprofileLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editprofileLabel">Edit Data</h5>
                        <button type="button" class="btn-close" id="closeTambahModal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id_pengelola" value="<?php echo $pengelola['id_pengelola']; ?>"
                                id="">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama </label>
                                <input type="text" id="nama" name="nama" value="<?php echo $pengelola['nama']; ?>"
                                    class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" id="username" name="username"
                                    value="<?php echo $pengelola['username']; ?>" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="text" id="password" name="password"
                                    value="<?php echo $pengelola['password']; ?>" class="form-control" required>
                            </div>

                            <!-- Wrapper for the submit button to align it to the right -->
                            <div class="text-end">
                                <button type="button" id="closeTambahModal" data-bs-dismiss="modal" aria-label="Close"
                                    class="btn btn-secondary">Tutup</button>
                                <button type="button" onclick="submitEditForm()" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<?php
                    } else {
                        // Jika tidak ada data pengelola
                        echo "Tidak ada data pengelola.";
                    }
                } else {
                    // Jika query tidak berhasil dieksekusi
                    echo "Gagal mengambil data pengelola: " . mysqli_error($koneksi);
                }
            } else {
                // Jika session id_pengelola tidak diset
                echo "Session id_pengelola tidak tersedia.";
            }

            // Tutup koneksi ke database
            mysqli_close($koneksi);
?>
    </main>

    <!-- Loading Element -->
    <div class="loading" style="display: none;">
        <div class="spinner"></div>
    </div>

    <!-- CSS for Loading Spinner -->
    <style>
        .loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        // Variabel global untuk menyimpan instance Cropper
        var cropper;

        const loding = document.querySelector('.loading');

        // Fungsi untuk menampilkan gambar yang dipilih dan menampilkan modal
        function previewAndUpdateProfile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#editFotoProfilePreview').attr('src', e.target.result);
                    $('#editFotoProfileModal').modal('show');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Fungsi untuk memotong gambar dan menyimpannya
        function cropImage() {
            var croppedCanvas = cropper.getCroppedCanvas({
                width: 200, // Tentukan lebar gambar yang diinginkan
                height: 200 // Tentukan tinggi gambar yang diinginkan
            });
            var croppedDataUrl = croppedCanvas.toDataURL();

            // Tampilkan elemen .loading sebelum mengirimkan permintaan AJAX
            loding.style.display = 'flex';

            // Simpan data gambar ke server menggunakan AJAX
            $.ajax({
                type: 'POST',
                url: 'proses/akun/foto_profile.php',
                data: {
                    imageBase64: croppedDataUrl
                },
                success: function(response) {

                    // Sembunyikan elemen .loading setelah permintaan AJAX selesai
                    loding.style.display = 'none';

                    // Tampilkan sweet alert dengan pesan respon tanpa tombol OK dan hilang dalam 1,5 detik
                    swal({
                        title: "Sukses!",
                        text: "Foto profile berhasil diperbarui.",
                        icon: "success",
                        timer: 1500,
                        buttons: false
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    // Tampilkan sweet alert dengan pesan error
                    swal("Error!", xhr.responseText, "error");
                }
            });

            // Sembunyikan modal pemotongan gambar
            $('#editFotoProfileModal').modal('hide');
        }

        $(document).ready(function() {
            $('#editFotoProfileModal').on('shown.bs.modal', function() {
                // Inisialisasi Cropper setelah modal ditampilkan
                var containerWidth = $('.gambar').width();
                var containerHeight = $('.gambar').height();
                cropper = new Cropper($('#editFotoProfilePreview')[0], {
                    aspectRatio: 1, // 1:1 aspect ratio
                    viewMode: 1, // Crop mode
                    minContainerWidth: containerWidth, // Set minimum container width to match image container width
                    minContainerHeight: containerHeight, // Set minimum container height to match image container height
                });
            });

            $('#btnSaveProfile').on('click', function() {
                cropImage();
            });

            $('#editFotoProfileModal').on('hidden.bs.modal', function() {
                // Hapus cropper ketika modal ditutup
                if (cropper) {
                    cropper.destroy();
                }
            });
        });

        function submitEditForm() {
            var form = document.getElementById('editForm');
            var formData = new FormData(form);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'proses/akun/data_profile.php', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = xhr.responseText.trim();
                    console.log(response); // Debugging

                    if (response === 'success') {
                        form.reset();
                        var modal = bootstrap.Modal.getInstance(document.getElementById('editprofile'));
                        if (modal) {
                            modal.hide();
                        }

                        Swal.fire({
                            title: "Berhasil!",
                            text: "Data berhasil diperbarui",
                            icon: "success",
                            timer: 1200, // 1,2 detik
                            showConfirmButton: false, // Tidak menampilkan tombol OK
                        }).then(() => {
                            location.reload();
                        });
                    } else if (response === 'rayon_sudah_ada') {
                        Swal.fire({
                            title: "Error",
                            text: "Data rayon sudah dipromosikan, silakan pilih data rayon lainnya",
                            icon: "info",
                            timer: 2000, // 2 detik
                            showConfirmButton: false,
                        });
                    } else if (response === 'data_tidak_lengkap') {
                        Swal.fire({
                            title: "Error",
                            text: "Data yang anda masukan belum lengkap",
                            icon: "info",
                            timer: 2000, // 2 detik
                            showConfirmButton: false,
                        });
                    } else if (response === 'error_password_length') {
                        Swal.fire({
                            title: "Error",
                            text: "Password harus terdiri dari minimal 8 karakter.",
                            icon: "info",
                            timer: 2000, // 2 detik
                            showConfirmButton: false,
                        });
                    } else if (response === 'error_password_strength') {
                        Swal.fire({
                            title: "Error",
                            text: "Password harus mengandung huruf besar, huruf kecil, dan angka.",
                            icon: "info",
                            timer: 2000, // 2 detik
                            showConfirmButton: false,
                        });
                    } else if (response === 'data_sudah_ada') {
                        Swal.fire({
                            title: "Error",
                            text: "Data username sudah ada, silakan masukan data username lainnya",
                            icon: "info",
                            timer: 2000, // 2 detik
                            showConfirmButton: false,
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "Gagal memperbarui data",
                            icon: "error",
                            timer: 2000, // 2 detik
                            showConfirmButton: false,
                        });
                    }
                } else {
                    Swal.fire({
                        title: "Error",
                        text: "Terjadi kesalahan saat mengirim data",
                        icon: "error",
                        timer: 2000, // 2 detik
                        showConfirmButton: false,
                    });
                }
            };
            xhr.send(formData);
        }
    </script>

    <!-- Core JS Files -->
    <script src="../../assets/js/core/popper.min.js"></script>
    <script src="../../assets/js/core/bootstrap.min.js"></script>
    <script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="../../assets/js/plugins/chartjs.min.js"></script>

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