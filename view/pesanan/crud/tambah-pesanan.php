<?php

require('../../../functions.php');
session_start();
if (!isset($_SESSION["id_pegawai"])) {
    header("Location: ../../index.php?error=4");
}

$db = dbConnect();
if ($db->connect_errno == 0) {
    $noMeja = $db->escape_string($_POST["noMeja"]);
    $statusPesanan = 0;
    $pesanan = $_POST["id_menu"];
    $jumlah = $_POST["jumlah"];
    $jumlahPemesanan = $db->escape_string($_POST["jumlah_pemesanan"]);
    $subTotal = $db->escape_string($_POST["total_harga"]);

    $queryPesanan = addPesanan($noMeja, $statusPesanan, $jumlahPemesanan, $subTotal);

    if (mysqli_query($db, $queryPesanan)) {
        if ($db->affected_rows > 0) {
            $query = "select no_pesanan from pesanan order by no_pesanan DESC";
            $data = mysqli_query($db, $query);
            $row = mysqli_fetch_array($data);
            $psn = $row['no_pesanan'];

            $count = count($pesanan);

            for ($i = 0; $i < $count; $i++) {
                $data = array(
                    "no_pesanan" => $psn,
                    "id_menu" => $pesanan[$i],
                    "qty" => $jumlah[$i],
                );

                $nopesan = $data['no_pesanan'];
                $idmenu = $data['id_menu'];
                $jml = $data['qty'];


                $queryPesanan = addPesanandetail($nopesan, $idmenu, $_SESSION['id_pegawai'], $jml);
                $queryUpdateStokMenu = updateStokMenu($idmenu, $jml);
                mysqli_query($db, $queryPesanan);
                mysqli_query($db, $queryUpdateStokMenu);
            }
            if ($db->affected_rows > 0) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
} else {
    echo 0;
}
