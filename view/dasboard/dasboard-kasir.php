<?php
require('../../functions.php');
 session_start();
 if (!isset($_SESSION["id_pegawai"])) {
     header("Location: ../../index.php?error=4");
 }

nav("Lihat Pesanan");

dbConnect();
$data = getPesananBelumDibayar()->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
<style>

</style>

<!--SIDEBAR-->
  <aside class="sidebar">
    <menu>
      <ul class="menu-content dropdown">
        <li>
            <a href="#"><i class="fa fa-home">&nbsp;</i>Home</a>
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
                  <li class="sub-li"><a href="list-pesanan/list-pesanan-selesai.php"><i class="fa fa-check">&nbsp;</i>Selesai</a></li>
                  <li class="sub-li"><a href="list-pesanan/list-pesanan-belum-dibayar.php"><i class="fa fa-times">&nbsp;</i>Belum Dibayar</a></li>
                  <li class="sub-li"><a href="list-pesanan/list-pesanan-belum-dibuat.php"><i class="fa fa-coffee ">&nbsp;</i>Belum Dibuat</a></li>
              </ul>
          </li>
        <li>
            <a href="#">
                <i class="fa fa-file">&nbsp;</i><span>Laporan</span>
            </a>
            <ul class="dropdown">
                <li class="sub-li"><a href="../laporan_keuangan/view-laporan-harian.php"><i class="fa fa-calendar">&nbsp;</i>Laporan Harian</a></li>
                <li class="sub-li"><a href="../laporan_keuangan/view-laporan-bulanan.php"><i class="fa fa-calendar">&nbsp;</i>laporan bulanan</a></li>
            </ul>
        </li>
        <li>
          <a href="../login/logout.php"><i class="fa fa-sign-out"></i> <span>Log Out</span> </a>
        </li>
      </ul>
    </menu>
  </aside>
<!--BODY SECTION-->
  <section class="jumbotron">
<!--      INFORMATION HEADER-->
      <div class="information">
          <p class="h3">Dashboard Kasir &nbsp;<span class="text-primary" onclick="showInformation()"><i class="fa fa-info-circle"></i></span></p>
          <dd>List dibawah merupakan pesanan yang belum dibayar.</dd>
      </div>
      <hr>
      <div class="row">
<!--          INFORMATION BODY-->
      <?php
      if ( getPesananBelumDibayar()->num_rows <= 0) {
          ?>
          <div class="item-empty">
          <div class="pic-empty-states">
            <img  class="empty-pic" src="../../assets/Empty%20State.png">
          </div>
              <h5 class="title-empty" >Data Kosong</h5>
              <dd class="desc-empty">pesanan tersebut belum dibuat coba kontak barista!</dd>
          </div>
              <?php
      }
      foreach ($data as $barisdata) {
          ?>
<!--CARD LIST-->
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
                                      <h5>Total Harga</h5>
                                  </td>
                                      <input type="number" id="total_harga" hidden readonly value="<?= $barisdata["sub_total"] ?>"/>
                                  <td>
                                      <h5 align="right"><?php echo $barisdata["sub_total"] ?></h5>
                                  </td>
                              </tr>
                          </table>
                      </div>
                      <hr class="bg-dark">
                      <div class="btn-bayar" align="right">
                          <a onclick="doSave(<?= $barisdata["no_pesanan"]; ?>)"
                             class="btn btn-primary">Bayar</a>
                      </div>
                  </div>
              </div>
          </div>
      <?php
      } ?>
      </div>
  </section>
</body>
<script>
    function showInformation() {
        swal.fire({
            icon: "info",
            title: "Information",
            text: "Tekan tombol bayar setelah pelanggan membayar pesanan.",
            showConfirmButton: true,
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Alright!",
        });
    }

    function doSave(id) {
        let noPesanan = id;
        let totalharga = $("#total_harga").val();

        $.ajax({
            data: "no_pesanan=" + noPesanan + "&total_harga=" + totalharga ,
            url: "crud/update-dasboard-kasir.php",
            type: "POST",
            success: function (response) {

                if (response == 1) {
                    swal.fire({
                        title: "Sukses di update!",
                        text: "Sukses data diubah",
                        icon: "success",
                        button: "OK!",
                    })
                        .then((value) => {
                            location.reload();
                        });

                } else {
                    swal.fire({
                        title: "Gagal di update!",
                        text: "Data gagal diubah",
                        icon: "error",
                        button: "OK!",
                    })
                        .then((value) => {
                            location.reload();
                        });
                }
            }
        })
    }
</script>
</html>

