<?php
function dbConnect()
{
  $db = new mysqli("localhost", "root", "", "kopiHub");
  return $db;
}

function tgl_indo($tanggal){
    $bulan = array (
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);

    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

function konversiAngkaMenjadiBulan($bulan) {
    $monthNum = sprintf("%02s", $bulan);
    $monthName = date("F", strtotime($monthNum));
    return $monthName;
}

// Query update Stok Menu
function updateStokMenu($id_menu, $stok) {
    return "UPDATE menu SET stok = stok-'$stok' WHERE id_menu = '$id_menu';";
}

// Format Rupiah
function rupiah($angka){

    $hasil_rupiah = "Rp. " . number_format($angka,2,',','.');
    return $hasil_rupiah;

}

// Query Tambah Pembayaran
function addPembayaran($tanggal, $totalHarga, $noPesanan) {
    return "INSERT INTO pembayaran(tanggal, total_harga, no_pesanan) VALUES ('$tanggal', '$totalHarga', '$noPesanan')";
}

// Query Lihat Pesanan yang Selesai
function getPesananSelesai()
{
    $db = dbConnect();
    $sql = "SELECT * FROM pesanan WHERE status_pesanan = 2";
    return $db->query($sql);
}

// Query Lihat Pesanan yang BelumDibayar
function getPesananBelumDibayar()
{
    $db = dbConnect();
    $sql = "SELECT * FROM pesanan WHERE status_pesanan = 1";
    return $db->query($sql);
}

// Query Lihat Pesanan yang BelumDibuat
function getPesananBelumDibuat()
{
    $db = dbConnect();
    $sql = "SELECT * FROM pesanan WHERE status_pesanan = 0";
    return $db->query($sql);
}

// Query Lihat Pesanan
function getPesanan()
{
    $db = dbConnect();
    $sql = "SELECT * FROM pesanan";
    return $db->query($sql);
}

// Query Count Pesanan dengan status_pesanan = 2
function countPesananSelesai() {
    $db = dbConnect();
    $sql = "SELECT COUNT(*) FROM pesanan WHERE status_pesanan = 2";
    return $db->query($sql);
}

// Query Count Pesanan dengan status_pesanan = 2
function countPesananBelumDibayar() {
    $db = dbConnect();
    $sql = "SELECT COUNT(*) FROM pesanan WHERE status_pesanan = 1";
    return $db->query($sql);
}

// Query Count Pesanan dengan status_pesanan = 0
function countPesananBelumDibuat() {
    $db = dbConnect();
    $sql = "SELECT COUNT(*) FROM pesanan WHERE status_pesanan = 0";
    return $db->query($sql);
}

// Query update Pesanan
function updatePesanan($no_pesanan, $status_pesanan) {
    return "UPDATE pesanan SET pesanan.status_pesanan= '$status_pesanan' WHERE pesanan.no_pesanan = '$no_pesanan'";
}

// Query Tambah Pesanan
function addPesanan($noMeja, $statusPesanan, $jumlahPesanan, $subTotal)
{
  return "INSERT INTO pesanan(no_meja, status_pesanan, jumlah_pesanan, sub_total) VALUES ('$noMeja', '$statusPesanan', '$jumlahPesanan', '$subTotal')";
}
function addPesanandetail($nopesanan, $idmenu, $idpegawai, $qty)
{
  return "INSERT INTO detail_pesanan(no_pesanan, id_menu, id_pegawai, qty) VALUES ('$nopesanan', '$idmenu', '$idpegawai', '$qty')";
}

function getPesananBarista2()
{
    $db = dbConnect();
    $sql = "SELECT * FROM pesanan WHERE status_pesanan = 0";
    return $db->query($sql);
}

// Query Lihat Pesanan Khusus Dashboard Barista
function getPesananBarista()
{
  $db = dbConnect();
  $sql = "SELECT 
		detail_pesanan.*,
		(select no_meja from pesanan where no_pesanan=detail_pesanan.no_pesanan) meja,
		(select nama_menu from menu where id_menu=detail_pesanan.id_menu) menu
FROM detail_pesanan inner join pesanan on detail_pesanan.no_pesanan=pesanan.no_pesanan where pesanan.status_pesanan=0 group by detail_pesanan.no_pesanan;";
  return $db->query($sql);
}
function getPesananBaristadetail($id)
{
  $db = dbConnect();
  $sql = "SELECT 
		detail_pesanan.*,
		(select no_meja from pesanan where no_pesanan=detail_pesanan.no_pesanan) meja,
		(select nama_menu from menu where id_menu=detail_pesanan.id_menu) menu
FROM detail_pesanan inner join pesanan on detail_pesanan.no_pesanan=pesanan.no_pesanan where pesanan.status_pesanan=0 
                                                                                         and pesanan.no_pesanan='$id';";
  return $db->query($sql);
}

function getDataPesanan($no_pesanan)
{
  $db = dbConnect();
  $sql = "SELECT * FROM pesanan WHERE no_pesanan = $no_pesanan";
  return $db->query($sql);
}

function getMenu()
{
  $db = dbConnect();
  $sql = "SELECT * FROM menu";
  return $db->query($sql);
}

function getDataMenu($id_menu)
{
  $db = dbConnect();
  $sql = "SELECT * FROM menu WHERE id_menu = '$id_menu'";
  return $db->query($sql);
}

function getLaporanHarian($tanggal)
{
    $db = dbConnect();
    $sql = "SELECT pembayaran.tanggal as tanggal, pesanan.no_pesanan as np, pesanan.jumlah_pesanan as jp, pembayaran.total_harga as th FROM pembayaran INNER JOIN pesanan ON pembayaran.no_pesanan = pesanan.no_pesanan WHERE tanggal = '$tanggal'";
    return $db->query($sql);
}

function getLaporanBulanan($bulan, $tahun)
{
    $db = dbConnect();
    $sql = "SELECT tanggal, total_harga as total FROM pembayaran WHERE YEAR(tanggal) = '$tahun' AND MONTH(tanggal) = '$bulan'";
    return $db->query($sql);
}

function getTotalBulanan($bulan, $tahun)
{
    $db = dbConnect();
    $sql = "SELECT sum(total_harga) as total FROM pembayaran WHERE YEAR(tanggal) = '$tahun' AND MONTH(tanggal) = '$bulan'";
    return $db->query($sql);
}

function getTotalHarian()
{
  $db = dbConnect();
  $sql = "SELECT tanggal, SUM(total_harga) FROM pembayaran GROUP BY tanggal";
  return $result = $db->query($sql);
}

function getHapusMenu($id_menu)
{
  $db = dbConnect();

  $sql = "DELETE FROM menu WHERE id_menu = '$id_menu'";
  return $delete = $db->query($sql);

  if ($delete) {
    mysqli_close($db);
    header("location: view-lihat-menu.php");
    exit;
  } else {
    echo "Penghapusan menu gagal";
  }
}

function nav($title)
{
?>
  <!DOCTYPE html>
  <html>

  <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="../../style.css">

     <script src="https://code.jquery.com/jquery.min.js"></script>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script src="https://kit.fontawesome.com/f26d8b4cf2.js" crossorigin="anonymous"></script>

      <title><?php echo $title ?></title>
  </head>

  <nav class="navbar navbar-dark sticky-top" style="background-color: #293949">
    <div class="container-fluid">
      <a class="navbar-brand">KopiHub</a>
       <p class="h6" style="color: white;">Halo, <?= $_SESSION["nama"]; ?></p>
    </div>
  </nav>
<?php
}
function nav3()
{
?>
  <!DOCTYPE html>
  <html>

  <head>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  </head>

<?php
}

function nav2()
{
?>
  <!DOCTYPE html>
  <html>

  <head>
  <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="../../style.css">

     <script src="https://code.jquery.com/jquery.min.js"></script>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script src="https://kit.fontawesome.com/f26d8b4cf2.js" crossorigin="anonymous"></script>

  </head>

<?php
}

function showError($message)
{
?>
    <p class="login-box-msg text-danger">
        <i class="fa fa-ban"></i> <?php echo $message; ?>
    </p>
<?php
}
?>
