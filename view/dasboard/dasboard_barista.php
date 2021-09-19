<?php
require('../../functions.php');
session_start();
if (!isset($_SESSION["id_pegawai"])) {
    header("Location: ../../index.php?error=4");
}

nav("Barista");

$nopesanan = array();
$no = 1;
dbConnect();
$data = getPesananBarista()->fetch_all(MYSQLI_ASSOC);

?>

<body>
<!--SIDEBAR-->
<aside class="sidebar">
    <menu>
        <ul class="menu-content">

            <li>
                <a href="#"><i class="fa fa-home">&nbsp;</i> Home</a>
            </li>
            <li>
                <a href="../menu/view-lihat-menu.php"><i class="fa fa-book">&nbsp;</i> <span>Menu</span> </a>
            </li>
            <li><a href="../pesanan/view-lihat-pesanan.php"><i class="fa fa-shopping-basket">&nbsp;</i>
                    <span>Pesanan</span></a></li>
            <li>
                <a href="../login/logout.php"><i class="fa fa-sign-out">&nbsp;</i> <span>Log Out</span> </a>
            </li>
        </ul>
    </menu>
</aside>
<!--INFORMATION HEADER-->
<section class="jumbotron">
    <div class="information">
        <p class="h3">Dashboard Barista &nbsp;<span class="text-primary" onclick="showInformation()"><i
                        class="fa fa-info-circle"></i></span></p>
        <dd>List dibawah merupakan pesanan yang belum dibuat tekan tombol selesai apabila pesanan sudah dibuatkan.
        </dd>
    </div>
    <hr>
<!--    INFORMATION BODY-->
    <div class="row">
        <?php
        if ( getPesananBarista()->num_rows <= 0) {
            ?>
            <div class="item-empty">
                <div class="pic-empty-states">
                    <img  class="empty-pic" src="../../assets/Empty%20State.png">
                </div>
                <h5 class="title-empty" >Data Kosong</h5>
                <dd class="desc-empty">Tidak ada pesanan saat ini.</dd>
            </div>
            <?php
        }
        foreach ($data as $row) { ?>
<!--                CARD LIST SECTION-->
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" align="center">No Pesanan <?= $row["no_pesanan"] ?></h5>
                        <input type="text" name="no_pesanan" id="no_pesanan" value="<?= $row["no_pesanan"] ?>" hidden
                               readonly>
                        <hr>
                        <p class="card-text">Rincian Pesanan :</p>
                        <table class="table table-bordered table-responsive">
                            <tr>
                                <td>Nama Menu</td>
                                <td>Jumlah</td>
                            </tr>
                            <?php
                            $dataDetail = getPesananBaristadetail($row['no_pesanan'])->fetch_all(MYSQLI_ASSOC);
                            foreach ($dataDetail as $row) { ?>
                                <tr>
                                    <td><?= $row['menu']; ?></td>
                                    <td><?= $row['qty']; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                        <div class="btn-selesai" align="right" style="margin-top: 20px;">
                            <a class="btn btn-primary" onclick="doSave(<?= $row["no_pesanan"] ?>)">Selesai</a>
                        </div>
                    </div>
                </div>
                <div class="card">

                </div>
            </div>
            <?php

        }
        ?>
    </div>
</section>
</body>
<script>
    function doSave(id) {
        let noPesanan = id;
        $.ajax({
            data: "no_pesanan=" + noPesanan,
            url: "crud/update-dasboard-barista.php",
            type: "POST",
            success: function (response) {

                if (response == 1) {
                    swal.fire({
                        title: "Sukses di update!",
                        text: "Sukses data diubah",
                        icon: "success",
                        button: "OK!",
                    })
                        .then((value) => {
                            location.reload();
                        });

                } else {
                    swal.fire({
                        title: "Gagal di update!",
                        text: "Data gagal diubah",
                        icon: "error",
                        button: "OK!",
                    })
                        .then((value) => {
                            location.reload();
                        });
                }
            }
        })

    }

    function showInformation() {
        swal.fire({
            icon: "info",
            title: "Information",
            text: "Tekan tombol selesai apabila pesanan sudah dibuat.",
            showConfirmButton: true,
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Alright!",
        });
    }
</script>
