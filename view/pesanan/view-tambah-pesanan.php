<?php
require('../../functions.php');
session_start();
if (!isset($_SESSION["id_pegawai"])) {
    header("Location: ../../index.php?error=4");
}

?>
<!DOCTYPE html>
<html>

<head>
    <?php nav("Tambah Pesanan"); ?>
</head>

<!--BODY-->
<body>
<h1 align="center">Tambah Pesanan</h1>
<div class="row">
    <div class="col-sm-6 offset-sm-3">
        <form role="form" id="frm-data">
            <table align="center" class="table-sm table table-condensed">
                <tr>
                    <td>No Meja</td>
                    <td colspan="2"><input type="text" id="no_meja" name="noMeja" class="form-control"
                                           placeholder="Masukan No Meja"></td>
                </tr>


                <tr>
                    <td>Pilih Menu</td>

                    <td>
                        <select name="slc_menu" id="slc-menu" class="form-control">
                            <option value="">- Pilih Menu -</option>
                            <?php
                            dbConnect();
                            $data = getMenu()->fetch_all(MYSQLI_ASSOC);
                            foreach ($data as $row) { ?>
                                <option value="<?= $row['id_menu']; ?>,<?= $row['stok']; ?>"
                                        data-harga="<?= $row['harga']; ?>"><?= $row['nama_menu']; ?></option>
                            <?php } ?>
                        </select>
                        Stok <span class="text_stok"></span>

                    </td>
                    <td>
                        <input type="text" id="txt_jumlah" name="txt_jumlah" class="form-control" placeholder="jumlah">
                    </td>
                    <td>
                        <i class="btn btn-xs btn-success" id="add-menu"><i class="icon icon-plus"></i></i>
                    </td>
                <tr>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <td>Nama Menu</td>
                            <td>Jumlah</td>
                            <td>Sub Total</td>
                        </tr>
                        </thead>
                        <tbody id="result_menu">

                        </tbody>
                    </table>
                </tr>
                <tr>
                    <td>Jumlah Pemesanan</td>
                    <td><input type="number" id="jumlah_pemesanan" name="jumlah_pemesanan" class="form-control"
                               placeholder="0" readonly>
                    </td>
                </tr>
                <tr>
                    <td>Total Harga</td>
                    <td><input type="number" id="total_harga" name="total_harga" class="form-control" placeholder="0"
                               readonly></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </form>

        <div class="button" align="right">
            <button value="Submit" class="btn btn-success" name="btnSubmit" id="btn-save"> Simpan</button>
        </div>

    </div>
</div>

</body>
<script>
    $(document).ready(function () {
        var jumlah;
        let stok;
        var checkStok;
        $("#btn-save").click(function () {
            doSave();
        })

        $('#slc-menu').on('change', function () {
            var expl = $(this).val().split(",");
            $(".text_stok").text(expl[1]);

            stok = parseInt(expl[1]);
        });
        window.arrayItem = [];
        var i = 0;
        window.arrayPesanan = [];
        window.arrayTotal = [];
        var jumlah_pesanan = 0;
        var jumlah_total = 0;
        var jumlah_total2 = 0;
        var jumlah_pesanan2 = 0;

        $("#add-menu").click(function () {

            ++i;
            var id = $("select[name='slc_menu']").val().split(",");
            var menu = $("select[name='slc_menu']").find(':selected').text();

            jumlah = parseInt($("#txt_jumlah").val());
            var harga = $("select[name='slc_menu']").find(':selected').data('harga');

            var check = true;
            $.each(arrayItem, function (key, value) {
                if (menu == value) {
                    check = false;
                }
            })
            console.log(jumlah);
            console.log("Ini stok : " + stok);
            if (jumlah > stok) {
                checkStok = false;
            } else {
                console.log(true);
                checkStok = true;
            }

            if (check === false) {
                swal.fire({
                    icon: "info",
                    title: "Failed",
                    text: "Menu sudah di inputkan!",
                    showConfirmButton: true,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Alright!",
                });
                return false;
            }

            if (jumlah <= 0) {
                swal.fire({
                    icon: "info",
                    title: "Failed",
                    text: "Jumlah Menu Kosong",
                    showConfirmButton: true,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Alright!",
                });
                $("input[name='txt_jumlah']").focus();
                return false;
            }

            if (checkStok == false) {
                swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "Data Jumlah melebihi data stok!",
                    showConfirmButton: true,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Alright!",
                });
                $("input[name='txt_jumlah']").focus();
                return false;
            }


            var append_id = "result_menu";

            $("#" + append_id).append('<tr id="item' + i + '"><td style="vertical-align:middle"><span>' + menu + '</span><input type="hidden" name="id_menu[]" value="' + id[0] + '"></td><td class="text_pesanan" style="vertical-align:middle"<span>' + jumlah + '</span><input type="hidden" name="jumlah[]" value="' + jumlah + '"></td><td class="text_total" style="vertical-align:middle"<span>' + parseInt(harga) * parseInt(jumlah) + '</span></td><td align="center"><button type="button" class="btn btn-danger btn-xs" onclick="deleteItem(' + i + ',' + parseInt(harga) * parseInt(jumlah) + ',' + jumlah + ')"><i class="icon icon-trash"></i></button></td></tr>');
            arrayItem.push(menu);

            jumlah_pesanan = parseInt(arrayPesanan[1]) + parseInt(jumlah);
            jumlah_total = parseInt(arrayTotal[1]) + (parseInt(jumlah) * parseInt(harga));


            $("button").addClass("");
            $("select[name='slc_menu']").val("");
            $("input[name='txt_jumlah']").val("");
            $(".text_stok").text("");
            jumlah_total2 = 0;
            jumlah_pesanan2 = 0;
            $('#result_menu tr').each(function () {
                jumlah_pesanan2 += parseInt($(this).find(".text_pesanan").text());
                jumlah_total2 += parseInt($(this).find(".text_total").text());
            });
            $("#jumlah_pemesanan").val(jumlah_pesanan2);
            $("#total_harga").val(jumlah_total2);

        });
    });

    function deleteItem(id, total, jumlah) {
        var jumlah_pesanan = $("#jumlah_pemesanan").val() - parseInt(jumlah);
        var jumlah_total = $("#total_harga").val() - parseInt(total);

        $("#jumlah_pemesanan").val(jumlah_pesanan);
        $("#total_harga").val(jumlah_total);
        arrayItem.remove($("#item" + id + " td span").first().text());
        $("#item" + id).remove();
    }

    Array.prototype.remove = function (x) {
        var i;
        for (i in this) {
            if (this[i].toString() == x.toString()) {
                this.splice(i, 1)
            }
        }
    }

    function doSave() {

        $.ajax({
            type: "POST",
            data: $("#frm-data").serialize(),

            url: "crud/tambah-pesanan.php",

            beforeSend: function () {

            },

            success: function (reponse) {
                if (reponse == 1) {
                    swal.fire({
                        title: "Informasi!",
                        text: "berhasil",
                        icon: "info",
                        button: "OK!",
                    }).then((value) => {
                        location.reload();
                    });

                } else {
                    swal.fire({
                        title: "Informasi!",
                        text: "error",
                        icon: "error",
                        button: "OK!",
                    }).then((value) => {
                        location.reload();
                    });
                }

            }

        })

    }
</script>

</html>
