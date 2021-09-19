<html>
<?php
require('../../functions.php');
session_start();
if (!isset($_SESSION["id_pegawai"])) {
    header("Location: ../../index.php?error=4");
}

nav("Lihat Menu");

dbConnect();
$data = getMenu()->fetch_all(MYSQLI_ASSOC);
?>

<!--SideBar-->
<aside class="sidebar">
    <menu>
        <ul class="menu-content">
            <li>
                <?php if ($_SESSION['jabatan'] == "kasir") {
                    echo '<a href="../dasboard/dasboard-kasir.php"><i class="fa fa-home">&nbsp;</i>Home</a>';
                }

                if ($_SESSION['jabatan'] == "pelayan") {
                    echo '<a href="../dasboard/dasboard_pelayan.php"><i class="fa fa-home">&nbsp;</i>Home</a>';
                }

                if ($_SESSION['jabatan'] == "barista") {
                    echo '<a href="../dasboard/dasboard_barista.php"><i class="fa fa-home">&nbsp;</i>Home</a>';
                }
                ?>
            </li>
            <li>
                <a href="../menu/view-lihat-menu.php"><i class="fa fa-book">&nbsp;</i> <span>Menu</span> </a>
            </li>
            <li>
                <a href="../pesanan/view-lihat-pesanan.php"><i
                            class="fa fa-shopping-basket"></i>&nbsp;<span>Pesanan</span></a>
                <?php
                if ($_SESSION['jabatan'] == 'kasir') {
                    ?>
                    <ul class="dropdown">
                        <li class="sub-li"><a href="../dasboard/list-pesanan/list-pesanan-selesai.php"><i
                                        class="fa fa-check">&nbsp;</i>Selesai</a></li>
                        <li class="sub-li"><a href="../dasboard/list-pesanan/list-pesanan-belum-dibayar.php"><i
                                        class="fa fa-times">&nbsp;</i>Belum Dibayar</a></li>
                        <li class="sub-li"><a href="../dasboard/list-pesanan/list-pesanan-belum-dibuat.php"><i
                                        class="fa fa-coffee ">&nbsp;</i>Belum Dibuat</a></li>
                    </ul>
                    <?php
                }
                ?>
            </li>
            <?php
            if ($_SESSION['jabatan'] == 'kasir') {
                ?>
                <li>
                    <a href="#">
                        <i class="fa fa-file">&nbsp;</i><span>Laporan</span>
                    </a>
                    <ul class="dropdown">
                        <li class="sub-li"><a href="../laporan_keuangan/view-laporan-harian.php"><i
                                        class="fa fa-calendar">&nbsp;</i>Laporan Harian</a></li>
                        <li class="sub-li"><a href="../laporan_keuangan/view-laporan-bulanan.php"><i
                                        class="fa fa-calendar">&nbsp;</i>laporan bulanan</a></li>
                    </ul>
                </li>
                <?php
            }
            ?>
            <li>
                <a href="../login/logout.php"><i class="fa fa-sign-out"></i>&nbsp;<span>Log Out</span> </a>
            </li>
        </ul>
    </menu>
</aside>

<body>
<!--BODY-->
<div class="jumbotron">
    <?php
    if ($_SESSION['jabatan'] == "barista") {
        ?>
        <!--                    INFORMATION HEADER-->
        <div class="card" style="width: 34rem;">
            <div class="card-header">
                <i class="fa fa-info-circle"></i> Informasi
            </div>
            <div class="card-body">
                <p class="card-text">Silahkan tekan tombol tambah untuk menambah menu.</p>
                <div class="btn-tambah" style="margin-bottom: 20px">
                    <a href="view-tambah-menu.php" class="btn btn-success"><i class="fa fa-plus">&nbsp;</i> Tambah Menu</a>
                </div>
            </div>
        </div>
        <br>
        <?php
    }
    ?>

    <!--        TITLE HEADER-->
    <div class="title" align="center">
        <h1 class="display-4">Menu</h1>
        <hr>
    </div>

    <div class="row mt-3">
        <?php foreach ($data as $row) : ?>
            <!--            CARD LIST-->
            <div class="col-md-4">
                <div class="card mb-4" style="width: 18rem;">
                    <?php
                    if ($row["gambar_menu"] == "") {
                        $namagambar = "default.jpg";
                    } else
                        $namagambar = $row["gambar_menu"];
                    ?>
                    <img src="../menu/images/<?php echo $namagambar; ?>" class="card-img-top" width="80" height="250">
                    <div class="card-body">
                        <div class="judul_menu" align="left">
                            <p class="h2"><?= $row["nama_menu"]; ?></p>
                        </div>
                        <div class="isi_menu">
                            <dd class="deskripsi_menu" style="color: #6e7d88">
                                <?= $row['deskripsi']; ?>
                            </dd>
                            <?php
                            if ($row["stok"] <= 5) {
                                $stok = "text-warning";
                            } else {
                                $stok = "text-dark";
                            }
                            ?>
                            <p class="<?= $stok ?>">Stok : <?= $row["stok"]; ?></p>
                            <hr>
                            <p class="h5">Harga : Rp.<?= $row["harga"]; ?></p>
                        </div>

                        <?php
                        if ($_SESSION['jabatan'] == "barista") {
                            ?>
                            <div class="btn_hapus_barista" align="right">
                                <button onclick="doDelete('<?= $row['id_menu']; ?>')"
                                   class="btn btn-outline-danger"><i class="fa fa-trash">&nbsp;</i> Hapus</button>
                                <a>&nbsp;</a>
                                <a href="view-ubah-menu.php?id_menu=<?php echo $row['id_menu']; ?>"
                                   class="btn btn-primary"><i class="fa fa-edit">&nbsp;</i> Ubah</a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>
</body>

<script>
    function doDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    data: "id_menu=" + id,
                    url: "view-hapus-menu.php",

                    success: function (response) {
                        if (response == 1) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                                .then(value => {
                                    location.reload();
                                });
                        } else {
                            Swal.fire(
                                'Gagal!',
                                'You clicked the button!',
                                'error'
                            )
                                .then(value => {
                                    location.reload();
                                });
                        }
                    }
                })
            }
        })
    }

</script>

</html>
