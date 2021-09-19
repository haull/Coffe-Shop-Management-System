<?php
require "../../../functions.php";

$db = dbConnect();

$no_pesanan = $db->escape_string($_POST["no_pesanan"]);
$totalHarga = $db->escape_string($_POST["total_harga"]);
$status_pesanan = 2;
$tanggal = date("Y-m-d");

$ubahPesanan = updatePesanan($no_pesanan, $status_pesanan);
$tambahPembayaran = addPembayaran($tanggal, $totalHarga, $no_pesanan);

if (mysqli_query($db, $ubahPesanan)) {
    if ($db->affected_rows > 0) {
            if (mysqli_query($db, $tambahPembayaran)) {
                if ($db->affected_rows > 0) {
                    echo 1;
                } else {
                    echo 0;
                }
            }  else {
                echo "total harga Tidak ada";
            }
    } else {
        echo 0;
    }
} else {
    echo  "No Pesanan Tidak ada";
}

