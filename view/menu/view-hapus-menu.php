<?php
require('../../functions.php');
session_start();
if (!isset($_SESSION["id_pegawai"])) {
    header("Location: ../../index.php?error=4");
}

dbConnect();

$id_menu = dbConnect()->escape_string($_GET['id_menu']);
$dataMenu = getDataMenu($id_menu)->fetch_assoc();

if ($dataMenu["gambar_menu"] != "") {
    unlink("images/" . $dataMenu["gambar_menu"]);
}
if ($dataHapus = getHapusMenu($id_menu)) {
    echo 1;
} else {
    echo 0;
}
