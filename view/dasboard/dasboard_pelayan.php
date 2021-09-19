<?php
require('../../functions.php');
session_start();
if (!isset($_SESSION["id_pegawai"])) {
    header("Location: ../../index.php?error=4");
}

nav("Lihat Pesanan");

dbConnect();
$pesananBelumDibuat = countPesananBelumDibuat()->fetch_array();
$pesananBelumDibayar = countPesananBelumDibayar()->fetch_array();
$pesananSelesai = countPesananSelesai()->fetch_array();
?>

<!DOCTYPE html>
<html lang="en">

<body>
<!--SIDEBAR-->
    <aside class="sidebar">
        <menu>
            <ul class="menu-content">

                <li>
                    <a href="../dasboard/dasboard_pelayan.php"><i class="fa fa-home">&nbsp;</i>Home</a>
                </li>
                <li>
                    <a href="../login/logout.php"><i class="fa fa-sign-out">&nbsp;</i> <span>Log Out</span> </a>
                </li>
            </ul>
        </menu>
    </aside>

<!--BODY-->
    <section class="jumbotron">


        <!--      INFORMATION HEADER-->
        <div class="information">
            <p class="h3">Dashboard Pelayan &nbsp;<span class="text-primary" onclick="showInformation()"><i class="fa fa-info-circle"></i></span></p>
            <dd>List dibawah merupakan pesanan pesanan yang sudah dipesan.</dd>
        </div>
        <hr>


        <!--        LIST SECTION-->
        <div class="table">
            <table class="table">
                <tbody>
                <tr>
                    <td>Total Pesanan Yang Belum Dibuat</td>
                    <td>:</td>
                    <td><?=$pesananBelumDibuat[0] ?></td>
                    <td colspan="3">
                        <div class="btn-detail" align="right">
                            <a href="list-pesanan/list-pesanan-belum-dibuat.php" class="btn btn-primary btn-sm">Detail</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Total Pesanan Yang Belum Dibayar</td>
                    <td>:</td>
                    <td><?=$pesananBelumDibayar[0] ?></td>
                    <td colspan="3">
                        <div class="btn-detail" align="right">
                            <a href="list-pesanan/list-pesanan-belum-dibayar.php" class="btn btn-primary btn-sm">Detail</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Total Pesanan Yang Selesai</td>
                    <td>:</td>
                    <td><?=$pesananSelesai[0] ?></td>
                    <td colspan="3">
                        <div class="btn-detail" align="right">
                            <a href="list-pesanan/list-pesanan-selesai.php" class="btn btn-primary btn-sm">Detail</a>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </section>
</body>
<script>
    function showInformation() {
        swal.fire({
            icon: "info",
            title: "Information",
            text: "Tekan tombol detail untuk melihat detail pesanan.",
            showConfirmButton: true,
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Alright!",
        });
    }
</script>
</html>
