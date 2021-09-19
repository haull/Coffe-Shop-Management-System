<?php
require('../../functions.php');
session_start();
if (!isset($_SESSION["id_pegawai"])) {
    header("Location: ../../index.php?error=4");
}

nav("Lihat Pesanan");

dbConnect();
$data = getPesanan()->fetch_all(MYSQLI_ASSOC);
$dataBarista = getPesananBarista2()->fetch_all(MYSQLI_ASSOC);
?>

    <!--SIDEBAR-->
    <aside class="sidebar">
        <menu>
            <ul class="menu-content">
                <li>
                    <?php if ($_SESSION['jabatan'] == "kasir") {
                        echo '<a href="../dasboard/dasboard-kasir.php"><i class="fa fa-home">&nbsp;</i>Home</a>';
                    }

                    if ($_SESSION['jabatan'] == "barista") {
                        echo '<a href="../dasboard/dasboard_barista.php"><i class="fa fa-home">&nbsp;</i>Home</a>';
                    }
                    ?>
                </li>
                <li>
                    <a href="../menu/view-lihat-menu.php"><i class="fa fa-book">&nbsp;</i> <span>Menu</span> </a>
                </li>
                <li><a href="../pesanan/view-lihat-pesanan.php"><i class="fa fa-shopping-basket">&nbsp;</i>
                        <span>Pesanan</span></a>
                    <?php
                    if ($_SESSION['jabatan'] == 'kasir') {
                        ?>
                        <ul class="dropdown">
                            <li class="sub-li"><a href="../dasboard/list-pesanan/list-pesanan-selesai.php"><i class="fa fa-check">&nbsp;</i>Selesai</a></li>
                            <li class="sub-li"><a href="../dasboard/list-pesanan/list-pesanan-belum-dibayar.php"><i class="fa fa-times">&nbsp;</i>Belum Dibayar</a></li>
                            <li class="sub-li"><a href="../dasboard/list-pesanan/list-pesanan-belum-dibuat.php"><i class="fa fa-coffee">&nbsp;</i>Belum Dibuat</a></li>
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
                            <li class="sub-li"><a href="../laporan_keuangan/view-laporan-harian.php"><i class="fa fa-calendar">&nbsp;</i>Laporan Harian</a></li>
                            <li class="sub-li"><a href="../laporan_keuangan/view-laporan-bulanan.php"><i class="fa fa-calendar">&nbsp;</i>laporan bulanan</a></li>
                        </ul>
                    </li>
                        <?php
                }
                ?>
                <li>
                    <a href="../login/logout.php"><i class="fa fa-sign-out">&nbsp;</i> <span>Log Out</span> </a>
                </li>
            </ul>
        </menu>
    </aside>

    <!--TITLE HEADER-->
    <div class="jumbotron">

        <!--BUTTON TAMBAH PESANAN BUAT KASIR-->
        <div class="row mt-3">
            <div class="col">
                <?php
                if ($_SESSION['jabatan'] == 'kasir') {
                    ?>
                    <div class="card" style="width: fit-content;">
                        <div class="card-header">
                            <i class="fa fa-info-circle"></i>     Informasi
                        </div>
                        <div class="card-body">
                            <p class="card-text">Silahkan tekan tombol tambah untuk menambah pesanan.</p>
                            <div class="btn-tambah" style="margin-bottom: 20px">
                                <a href="view-tambah-pesanan.php" class="btn btn-success"><i class="fa fa-plus">&nbsp;</i> Tambah Pesanan</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>

<!--        TAMPILAN INFORMASI BARISTA-->
        <div class="information">
            <p class="h3">List Pesanan</p>
            <dd>List dibawah merupakan campuran list pesanan yang telah dipesan.
            </dd>
        </div>
        <hr>


        <div class="row">
        <!--    TAMPILAN CARD BARISTA-->
        <?php
        if ($_SESSION['jabatan'] == 'barista') {
            ?>
            <?php foreach ($dataBarista as $barisdata) { ?>
                <div class="col-sm-6">
                    <div class="card" style="width: 25rem; margin-bottom: 25px">
                        <div class="card-title">
                            <h4 class="card-title" align="center">Rincian Pesanan</h4>
                            <hr class="bg-dark border-2 ">
                            <div class="card-body">
                                <table class="table-sm" width="100%">
                                    <tr>
                                        <td>
                                            <h5>No Pesanan</h5>
                                        </td>
                                        <td>
                                            <h5 align="right"><?php echo $barisdata["no_pesanan"] ?></h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5>No Meja</h5>
                                        </td>
                                        <td>
                                            <h5 align="right"> <?php echo $barisdata["no_meja"] ?></h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5>Status Pesanan</h5>
                                        </td>
                                        <td align="right">
                                            <?php
                                            if ($barisdata["status_pesanan"] == 0) {
                                                $status = "text-danger";
                                            }
                                            ?>
                                            <h5 class="<?php echo $status ?>"><?php if($barisdata["status_pesanan"] == 0) { echo "Belum Dibuat"; } ?> </h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5>Jumlah Pesanan</h5>
                                        </td>
                                        <td>
                                            <h5 align="right"><?php echo $barisdata["jumlah_pesanan"] ?></h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5>Sub Total</h5>
                                        </td>
                                        <td>
                                            <h5 align="right"><?php echo $barisdata["sub_total"] ?></h5>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else
            ?>
<!--TAMPILAN CARD KASIR-->
            <?php
            if ($_SESSION['jabatan'] == 'kasir') {
                foreach ($data as $barisdata) { ?>

            <div class="col-sm-6">
                <div class="card" style="width: 25rem; margin-bottom: 25px">
                    <div class="card-body">
                        <h4 class="card-title" align="center">Rincian Pesanan</h4>
                        <hr class="bg-dark border-2 ">
                        <div class="card-body">
                            <table class="table-sm" width="100%">
                                <tr>
                                    <td>
                                        <h5>No Pesanan</h5>
                                    </td>
                                    <td>
                                        <h5 align="right"><?php echo $barisdata["no_pesanan"] ?></h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>No Meja</h5>
                                    </td>
                                    <td>
                                        <h5 align="right"> <?php echo $barisdata["no_meja"] ?></h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Status Pesanan</h5>
                                    </td>
                                    <td align="right">
                                        <?php
                                        if ($barisdata["status_pesanan"] == 0) {
                                            $status = "text-danger";
                                        } else if ($barisdata["status_pesanan"] == 1) {
                                            $status = "text-warning";
                                        } else if ($barisdata["status_pesanan"] == 2) {
                                            $status = "text-success";
                                        }
                                        ?>
                                        <h5 class="<?php echo $status ?>"><?php
                                            if ($barisdata["status_pesanan"] == 0) {
                                                echo "Belum dibuat";
                                            } else
                                                if ($barisdata["status_pesanan"] == 1) {
                                                    echo "Belum dibayar";
                                                } else
                                                    if ($barisdata["status_pesanan"] == 2) {
                                                        echo "Selesai";
                                                    } else {
                                                        echo "error";
                                                    }

                                            ?> </h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Jumlah Pesanan</h5>
                                    </td>
                                    <td>
                                        <h5 align="right"><?php echo $barisdata["jumlah_pesanan"] ?></h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Sub Total</h5>
                                    </td>
                                    <td>
                                        <h5 align="right"><?php echo $barisdata["sub_total"] ?></h5>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
            <?php
            }
        ?>
        </div>
    </div>
<?php
