
<?php
require ("../../functions.php");
$db = dbConnect();
$output = '';

nav3();

if (isset($_POST["export_excel"])) {
    $bulan = $db->escape_string($_POST['slc_bulan1']);
    $tahun = $db->escape_string($_POST['tahun1']);

    $no =1;
    $data = getLaporanBulanan($bulan, $tahun);
    $data2 = getTotalBulanan($bulan, $tahun)->fetch_array();
    if (mysqli_num_rows($data) > 0) {
        $output .= '
            <table class="table table-bordered" bordered="1">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Total</th>
            </tr>
        ';
        while ($row = mysqli_fetch_array($data)) {
            $output .= '
                <tr>
                    <td>'. $no++ .'</td>
                    <td>'. $row["tanggal"].'</td>
                    <td>'. $row["total"].'</td>
                </tr>
            ';
        }
        $output .= '<tr><td colspan="2">Total Pendapatan : </td><td>'. $data2[0] .'</td></tr>';
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=laporan.xls");
        echo $output;
    } else {
        echo '<div class="alert alert-danger" role="alert" align="center">
                <h4 class="alert-heading">Warning!</h4>
                <p>Data tidak ada, Cek kembali tabel data laporan bulanan</p>
                <a href="javascript:history.back()" class="btn btn-danger">Kembali</a>
               </div>';
    }
} else {
    echo '<div class="alert alert-danger" role="alert" align="center">
                <h4 class="alert-heading">Warning!</h4>
                <p>Data tidak ada, Cek kembali tabel data laporan bulanan</p>
                <a href="javascript:history.back()" class="btn btn-danger">Kembali</a>
               </div>';
}

