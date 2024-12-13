 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script>
function submitForm() {
    var form = document.getElementById('tambahForm');
    var formData = new FormData(form);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'proses/<?php echo $page_title_proses ?>/tambah.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = xhr.responseText.trim();
            console.log(response); // Debugging

            if (response === 'success') {
                form.reset();
                var modal = bootstrap.Modal.getInstance(document.getElementById('tambahDataModal'));
                if (modal) {
                    modal.hide();
                }


                Swal.fire({
                    title: "Berhasil!",
                    text: "Data berhasil ditambahkan",
                    icon: "success",
                    timer: 1200, // 1,2 detik
                    showConfirmButton: false, // Tidak menampilkan tombol OK
                }).then(() => {
                    location.reload();
                })
            } else if (response === 'rayon_sudah_ada') {
                Swal.fire({
                    title: "Error",
                    text: "Data rayon sudah dipromosikan, silakan pilih data roti lainnya",
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
                    text: "Gagal menambahkan data",
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

function submitEditForm() {
    var form = document.getElementById('editForm');
    var formData = new FormData(form);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'proses/<?php echo $page_title_proses ?>/edit.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = xhr.responseText.trim();
            console.log(response); // Debugging

            if (response === 'success') {
                form.reset();
                var modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
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


function hapus(id) {
    Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal",
        dangerMode: true,
    }).then((result) => {
        if (result.isConfirmed) {
            // Jika pengguna mengonfirmasi untuk menghapus
            var xhr = new XMLHttpRequest();

            xhr.open('POST', 'proses/<?php echo $page_title_proses ?>/hapus.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {

                if (xhr.status === 200) {
                    var response = xhr.responseText.trim();
                    if (response === 'success') {
                        Swal.fire({
                            title: 'Sukses!',
                            text: 'Data berhasil dihapus.',
                            icon: 'success',
                            timer: 1200, // 1,2 detik
                            showConfirmButton: false // Menghilangkan tombol OK
                        }).then(() => {
                            location.reload()
                        })
                    } else if (response === 'error') {
                        Swal.fire({
                            title: 'Error',
                            text: 'Gagal menghapus Data.',
                            icon: 'error',
                            timer: 2000, // 2 detik
                            showConfirmButton: false // Menghilangkan tombol OK
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Terjadi kesalahan saat mengirim data.',
                            icon: 'error',
                            timer: 2000, // 2 detik
                            showConfirmButton: false // Menghilangkan tombol OK
                        });
                    }
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Terjadi kesalahan saat mengirim data.',
                        icon: 'error',
                        timer: 2000, // 2 detik
                        showConfirmButton: false // Menghilangkan tombol OK
                    });
                }
            };
            xhr.send("id=" + id);
        } else {
            // Jika pengguna membatalkan penghapusan
            Swal.fire({
                title: 'Penghapusan dibatalkan',
                icon: 'info',
                timer: 1500, // 1,5 detik
                showConfirmButton: false // Menghilangkan tombol OK
            });
        }
    });
}
 </script>