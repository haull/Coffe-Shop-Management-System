<?php
require('../../functions.php');
 session_start();
 if (!isset($_SESSION["id_pegawai"])) {
     header("Location: ../../index.php?error=4");
 }

dbConnect();

nav("Tambah Menu");
?>
<style>
    .gambar {
        max-width: 250px;
        max-height: 250px;
    }
</style>

<!--BODY-->
<body>
    <div class="container-fluid mt-4" align="center">
        <h1>Tambah Menu</h1>
            <form action="crud/tambah-menu.php" method="post" class="mt-5" enctype="multipart/form-data">
            <table class="table-sm">
                <tr>
                    <td width="25%">ID Menu</td>
                    <td width="50%"><input type="text" id="txt_id" name="idMenu" class="form-control" placeholder="Masukan ID Menu" required></td>
                </tr>
                <tr>
                    <td>Nama Menu</td>
                    <td><input type="text" id="txt_nama" name="nama" class="form-control" placeholder="Masukan Nama Menu" required></td>
                </tr>
                <tr>
                    <td>Deskripsi</td>
                    <td><input type="text" id="txt_desc" name="deskripsi" class="form-control" placeholder="Masukan Deskripsi Menu" required></td>
                </tr>
                <tr>
                    <td>Harga</td>
                    <td><input type="text" id="txt_harga" name="harga" class="form-control" placeholder="Masukan Harga Menu" required></td>
                </tr>
                <tr>
                    <td>Stok</td>
                    <td><input type="number" id="txt_stok" name="stok" class="form-control" placeholder="Masukan Stok Menu" required></td>
                </tr>
                <tr>
                    <td>Gambar</td>
                    <td><input type="file" name="gambar" class="form-control" id="file" ></td>
                </tr>
                <tr>
                    <td></td>
                    <td align="right">
                        <img align="left" class="gambar mb-3" src="default.jpg" alt="Pilih Gambar" id="gambar" onError="$(this).hide();">
                        <a href="view-lihat-menu.php" class="btn btn-outline-secondary">Batal</a>
                        <input type="submit" name="TblSimpan" value="Simpan" class="btn btn-success">
                    </td>
                </tr>
            </table>
            </form>
    </div>
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#gambar').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

    $("#file").change(function() {
        $('#gambar').show();
        readURL(this);
    });

</script>
</body>
