<?php
require('../../functions.php');
session_start();
if (!isset($_SESSION["id_pegawai"])) {
    header("Location: ../../index.php?error=4");
}

nav("laporan bulanan");

$db = dbConnect();
?>

<body>
<!--SIDEBAR-->
<aside class="sidebar">
    <menu>
        <ul class="menu-content dropdown">
            <li>
                <a href="../dasboard/dasboard-kasir.php"><i class="fa fa-home">&nbsp;</i>Home</a>
            </li>
            <li>
                <a href="../menu/view-lihat-menu.php"><i class="fa fa-book">&nbsp;</i> <span>Menu</span> </a>
            </li>
            <li>
                <a href="../pesanan/view-lihat-pesanan.php">
                    <i class="fa fa-shopping-basket">&nbsp;</i>
                    <span>Pesanan</span>
                </a>
                <ul class="dropdown">
                    <li class="sub-li"><a href="../dasboard/list-pesanan/list-pesanan-selesai.php"><i
                                    class="fa fa-check">&nbsp;</i>Selesai</a></li>
                    <li class="sub-li"><a href="../dasboard/list-pesanan/list-pesanan-belum-dibayar.php"><i
                                    class="fa fa-times">&nbsp;</i>Belum Dibayar</a></li>
                    <li class="sub-li"><a href="../dasboard/list-pesanan/list-pesanan-belum-dibuat.php"><i
                                    class="fa fa-coffee ">&nbsp;</i>Belum Dibuat</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-file">&nbsp;</i><span>Laporan</span>
                </a>
                <ul class="dropdown">
                    <li class="sub-li"><a href="../laporan_keuangan/view-laporan-harian.php"><i class="fa fa-calendar">&nbsp;</i>Laporan
                            Harian</a></li>
                    <li class="sub-li"><a href="../laporan_keuangan/view-laporan-bulanan.php"><i class="fa fa-calendar">&nbsp;</i>laporan
                            bulanan</a></li>
                </ul>
            </li>
            <li>
                <a href="../login/logout.php"><i class="fa fa-sign-out"></i> <span>Log Out</span> </a>
            </li>
        </ul>
    </menu>
</aside>

<!--BODY-->
<section class="jumbotron">
    <!--    FILTER LAPORAN-->
    <div class="filter-laporan">
        <form method="post">
            <dd>Silahkan Pilih bulan dan tahun untuk memfilter data.</dd>
            <p>Bulan :
                <select name="slc_bulan" id="slc_bulan">
                    <option>--Pilih Bulan--</option>
                    <option value="01">Januari</option>
                    <option value="02">Februari</option>
                    <option value="03">Maret</option>
                    <option value="04">April</option>
                    <option value="05">Mei</option>
                    <option value="06">Juni</option>
                    <option value="07">Juli</option>
                    <option value="08">Agustus</option>
                    <option value="09">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
                &nbsp;
                &nbsp;
                &nbsp;
                &nbsp;
                &nbsp;
                &nbsp;
                &nbsp;
                Tahun : <input type="text" width="20%" placeholder="Masukkan Tahun" name="tahun" id="tahun">
            </p>
            <div class="btn_cari" style="margin-left: 440px">
                <button class="btn btn-primary" id="toggleVisibilityButton" name="btn_cari" id="btn-cari">Cari!</button>
            </div>
        </form>
        <hr>
        <!--        TAMPILAN LAPORAN-->
        <div class="row justify-content-center">
            <div class="col-md  -12">
                <?php
                        if (isset($_POST['btn_cari'])) {
                        $bulan = $db->escape_string($_POST['slc_bulan']);
                        $tahun = $db->escape_string($_POST['tahun']);
                        $no = 1;
                        $data = getLaporanBulanan($bulan, $tahun)->fetch_all(MYSQLI_ASSOC);

                        $bulan2 = konversiAngkaMenjadiBulan($bulan);

                        if (getLaporanBulanan($bulan, $tahun)->num_rows <= 0) {
                            ?>
                            <div class="item-empty">
                                <div class="pic-empty-states">
                                    <img  class="empty-pic" src="../../assets/Empty%20State.png">
                                </div>
                                <h5 class="title-empty" >Data Kosong</h5>
                                <dd class="desc-empty">Tidak data pada bulan <?= $bulan2; ?> dan tahun <?= $tahun; ?>.</dd>
                            </div>
                <?php
                            $display = "hidden";
                        } else {
                            $display = "visible";
                        }
                        ?>
                <div class="tampilan-tabel">
                    <table class="table table-responsive" id="displaytable" style="width: 100%; visibility: <?= $display; ?> ">
                        <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <?php
                        foreach ($data as $dataLaporan) :
                            ?>
                            <tr>
                                <td scope="row"><?= $no++ ?></td>
                                <td><?= $dataLaporan['tanggal']; ?></td>
                                <td><?php
                                    $value = (int)$dataLaporan['total'];
                                    echo rupiah($value);
                                    ?></td>
                            </tr>
                        <?php
                        endforeach;

                        $data2 = getTotalBulanan($bulan, $tahun)->fetch_all(MYSQLI_ASSOC);
                        foreach ($data2

                        as $total) :
                        ?>
                        <tr>
                            <td colspan="2" align="center"> Total Pendapatan :</td>
                            <td>
                                <?php
                                $value = (int)$total['total'];
                                echo rupiah($value);
                                ?>
                            </td>
                            <?php endforeach;
                            }
                            ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!--            BUTTON EXPORT-->
            <form action="excel.php" method="post">

                <div class="btn-export-to-excel" align="right" style="visibility: <?= $display; ?>">
                    <input type="hidden" name="slc_bulan1" id="slc_bulan1" value="<?= $bulan; ?>">
                    <input type="hidden" name="tahun1" id="tahun1" value="<?= $tahun; ?>">
                    <button name="export_excel" onclick="exceldo()" class="btn btn-success btn-lg"><i
                                class="fa fa-file-excel-o">&nbsp;</i> Export to Excel
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
</body>
</html>
