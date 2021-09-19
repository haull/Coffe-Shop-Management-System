<?php
require "../../../functions.php";

$db = dbConnect();

    $no_pesanan = $db->escape_string($_POST["no_pesanan"]);
    $status_pesanan = 1;
    $ubahPesanan = updatePesanan($no_pesanan, $status_pesanan);
    if (mysqli_query($db, $ubahPesanan)) {
        if ($db->affected_rows > 0) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo  "No Pesanan Tidak ada";
    }
