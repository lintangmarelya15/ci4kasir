<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir</title>
    <script src="<?= base_url("assets/jquery-3.7.1.min.js") ?>"></script>
    <!-- Link Bootstrap -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <!-- Link FontAwesome -->
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome-free-6.6.0-web/css/all.min.css') ?>">
</head>

<body>
    <div class="container">
        <div class="row mt-3">
            <div class="col-12">
                <h3 class="text-center">Data Produk</h3>
                <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#modalTambahProduk"><i class="fa-solid fa-cart-plus"></i> Tambah Data</button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="container mt-5">
                    <table class="table table-bordered" id="produkTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan dimasukkan melalui AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Produk -->
        <div class="modal fade" id="modalTambahProduk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalTambahProduk" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h1 class="modal-title fs-5" id="modalTambahProdukLabel">Tambah Produk</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formProduk">
                            <div class="row mb-3">
                                <label for="namaProduk" class="col-sm-4 col-form-label">Nama Produk</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="namaProduk" name="namaProduk">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="hargaProduk" class="col-sm-4 col-form-label">Harga</label>
                                <div class="col-sm-8">
                                    <input type="number" step="0.01" class="form-control" id="hargaProduk">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="stokProduk" class="col-sm-4 col-form-label">Stok</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" id="stokProduk">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="simpanProduk" class="btn btn-primary float-end">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditProduk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditProduk" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h1 class="modal-title fs-5" id="modalEditProduk">Edit Produk</h1>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formProduk">
                        <div class="row mb-3">
                            <label for="namaProduk" class="col-sm-4 col-form-label">Nama Produk</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="namaProdukEdit" name="namaProduk">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="hargaProduk" class="col-sm-4 col-from-label">Harga</label>
                            <div class="col-sm-8">
                                <input type="number" step="0.01" class="form-control" id="hargaProdukEdit">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="stokProduk" class="col-sm-4 col-form-label">Stok</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="stokProdukEdit">
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" id="editProdukSimpan">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            // Fungsi untuk menampilkan produk
            function tampilProduk() {
                $.ajax({
                    url: '<?= base_url('produk/tampil') ?>',
                    type: 'GET',
                    dataType: 'json',
                    success: function(hasil) {
                        if (hasil.status === 'success') {
                            var produkTable = $('#produkTable tbody');
                            produkTable.empty();

                            var produk = hasil.produk;
                            var no = 1;

                            produk.forEach(function(item) {
                                var row = '<tr>' +
                                    '<td>' + no + '</td>' +
                                    '<td>' + item.nama_produk + '</td>' +
                                    '<td>' + item.harga + '</td>' +
                                    '<td>' + item.stok + '</td>' +
                                    '<td>' +
                                    '<button class="btn btn-warning btn-sm editProduk" data-id="' + item.produk_id + '" data-bs-toggle="modal" data-bs-target="#modalEditProduk"><i class="fa-solid fa-pencil"></i> Edit</button> ' +
                                    '<button class="btn btn-danger btn-sm hapusProduk" data-id="' + item.produk_id + '"><i class="fa-solid fa-trash-can"></i> Hapus</button> ' +
                                    '</td>' +
                                    '</tr>';
                                produkTable.append(row);
                                no++;
                            });
                        } else {
                            alert('Gagal mengambil data.');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan: ' + error);
                    }
                });
            }

            // Panggil fungsi tampilProduk untuk menampilkan data produk saat halaman pertama kali dimuat
            tampilProduk();

            // Simpan data produk baru
            $('#simpanProduk').on("click", function() {
                var formData = {
                    nama_produk: $('#namaProduk').val(),
                    harga: $('#hargaProduk').val(),
                    stok: $('#stokProduk').val()
                };

                $.ajax({
                    url: '<?= base_url('produk/simpan'); ?>',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(hasil) {
                        if (hasil.status === 'success') {
                            $("#modalTambahProduk").modal("hide");
                            $("#formProduk")[0].reset();
                            tampilProduk();
                            Swal.fire({
                                title: "Good job!",
                                text: "You clicked the button!",
                                icon: "success"
                            });
                        } else {
                            alert('Gagal menyimpan data: ' + JSON.stringify(hasil.errors));
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan: ' + error);
                    }
                });
            });
        });

        // Fungsi untuk menghapus produk
        $('#produkTable').on('click', '.hapusProduk', function() {
            var produkId = $(this).data('id');
            var konfirmasi = confirm("Apakah Anda yakin ingin menghapus produk ini?");

            if (konfirmasi) {
                $.ajax({
                    url: '<?= base_url('produk/hapus'); ?>/' + produkId,
                    type: 'POST',
                    dataType: 'json',
                    success: function(hasil) {
                        if (hasil.status === 'success') {
                            tampilProduk();
                            Swal.fire({
                                title: "Good job!",
                                text: "You clicked the button!",
                                icon: "success"
                            });
                        } else {
                            alert('Gagal menghapus data.');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan: ' + error);
                    }
                });
            }
        });

        // Fungsi untuk mengedit produk
        $(document).on('click', '.editProduk', function() {
            var row = $(this).closest('tr');
            document.getElementById('namaProdukEdit').value = row.find('td:eq(1)').text()
            document.getElementById('hargaProdukEdit').value = row.find('td:eq(2)').text()
            document.getElementById('stokProdukEdit').value = row.find('td:eq(3)').text()
            var id = $(this).data('id');
            $('#editProdukSimpan').off('click').on('click', function() {
                var formData = {
                    'id_produk': id,
                    'nama_produk': document.getElementById('namaProdukEdit').value,
                    'harga': document.getElementById('hargaProdukEdit').value,
                    'stok': document.getElementById('stokProdukEdit').value
                }

                if (confirm('Apakah anda yakin ingin edit produk ini')) {
                    $.ajax({
                        url: '<?= base_url('produk/updateProduk') ?>',
                        type: 'POST',
                        dataType: 'json',
                        data: formData,
                        success: function(response) {
                            console.log(response);
                            if (response.status == 'success') {
                                alert(response.message);
                                $("#modalEditProduk").modal('hide')
                                tampilProduk();
                                Swal.fire({
                                    title: "Good job!",
                                    text: "You clicked the button!",
                                    icon: "success"
                                });
                            } else {
                                alert('gagal edit item: ' + response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('terjadi kesalahan saat edit item. ');
                        }
                    });
                }
            })
        });
    </script>
</body>
<link rel="stylesheet" href="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>