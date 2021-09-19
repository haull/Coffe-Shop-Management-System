<?php
require('../../../functions.php');
session_start();
if (!isset($_SESSION["id_pegawai"])) {
    header("Location: ../../../index.php?error=4");
}

nav("Lihat Pesanan");

dbConnect();
$data = getPesananBelumDibayar()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../../../style.css">
</head>

<body>

<!--SIDEBAR-->
<aside class="sidebar">
    <menu>
        <ul class="menu-content">
            <?php
            if ($_SESSION['jabatan'] == 'kasir') {
                $link = "../dasboard-kasir.php";
            } else {
                $link = "../dasboard_pelayan.php";
            }
            ?>
            <li>
                <a href="<?= $link; ?>"><i class="fa fa-home">&nbsp;</i>Home</a>
            </li>
            <?php
            if ($_SESSION['jabatan'] == 'kasir') {
                ?>
                <li>
                    <a href="../../menu/view-lihat-menu.php"><i class="fa fa-book">&nbsp;</i> <span>Menu</span> </a>
                </li>
                <li>
                    <a href="../../pesanan/view-lihat-pesanan.php">
                        <i class="fa fa-shopping-basket">&nbsp;</i>
                        <span>Pesanan</span>
                    </a>
                    <ul class="dropdown">
                        <li class="sub-li"><a href="../list-pesanan/list-pesanan-selesai.php"><i class="fa fa-check">&nbsp;</i>Selesai</a></li>
                        <li class="sub-li"><a href="../list-pesanan/list-pesanan-belum-dibayar.php"><i class="fa fa-times">&nbsp;</i>Belum Dibayar</a></li>
                        <li class="sub-li"><a href="../list-pesanan/list-pesanan-belum-dibuat.php"><i class="fa fa-coffee ">&nbsp;</i>Belum Dibuat</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-file">&nbsp;</i><span>Laporan</span>
                    </a>
                    <ul class="dropdown">
                        <li class="sub-li"><a href="../../laporan_keuangan/view-laporan-harian.php"><i class="fa fa-calendar">&nbsp;</i>Laporan Harian</a></li>
                        <li class="sub-li"><a href="../../laporan_keuangan/view-laporan-bulanan.php"><i class="fa fa-calendar">&nbsp;</i>laporan bulanan</a></li>
                    </ul>
                </li>

                <?php
            }
            ?>
            <li>
                <a href="../../login/logout.php"><i class="fa fa-sign-out"></i> <span>Log Out</span> </a>
            </li>
        </ul>
    </menu>
</aside>

<!--BODY-->
<section class="jumbotron">

<!--    TITLE HEADER-->
    <div class="row mt-3">
        <div class="col">
            <h1 class="display-4">List Pesanan Belum Dibayar</h1>
            <hr>
        </div>
    </div>
    <div class="row">
        <?php foreach ($data as $barisdata) { ?>
<!--                CARD LIST-->
            <div class="col-sm-3">
                <div class="card bg-light" style="width: 15rem; margin-bottom: 25px">
                    <div class="card-header">
                        <p class="h5"> No Pesanan : <?= $barisdata["no_pesanan"]; ?></p>
                    </div>
                    <div class="card-body">
                        <table>
                            <tr>
                                <td>
                                    <p class="card-text">No Meja</p>
                                </td>
                                <td>&nbsp;</td>
                                <td align="right">
                                    <p class="card-text"> <?= $barisdata["no_meja"] ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="card-text">Status Pesanan</p>
                                </td>
                                <td>&nbsp;</td>
                                <td align="right">
                                    <p class="card-text text-warning"><?php
                                        if ($barisdata["status_pesanan"] == 1) {
                                            echo "Belum Dibayar";
                                        }
                                        ?> </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="card-text">Jumlah Pesanan</p>
                                </td>
                                <td>&nbsp;</td>
                                <td align="right">
                                    <p class="card-text"><?= $barisdata["jumlah_pesanan"] ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="card-text">Sub Total</p>
                                </td>
                                <td>&nbsp;</td>
                                <td align="right">
                                    <p class="card-text"><?= $barisdata["sub_total"] ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</section>
</body>
</html>
