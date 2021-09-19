<?php
include("functions.php") ;
nav2();
?>

<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="bg-white">

    <div class="container">
        <center>
            <img src="https://cdn.discordapp.com/attachments/859080381517266944/865996965488754728/WhatsApp_Image_2021-07-03_at_12.23.31.jpeg" style="width: 10rem;" class="mt-5">
            <h1>KopiHub</h1>
            <div class="card mt-4  shadow p-3 mb-5 bg-white rounded" style="width: 45%;">
                <div class=" card-body">
                    <?php
                    if (isset($_GET["error"])) {
                        $error = $_GET["error"];
                        if ($error == 1) {
                            showError("Username atau Password tidak sesuai.");
                        } else
                            if ($error == 2) {
                            showError("Error database. Silahkan hubungi administrator!");
                        } else
                            if ($error == 3) {
                            showError("Koneksi ke Database gagal. Autentikasi gagal.");
                        } else
                            if ($error == 4) {
                            showError("Silahkan login terlebih dahulu!");
                        } else
                            showError("Error tidak diketahui!");
                    }

                    ?>
                    <div class="mt-3">
                        <form action="view/login/login.php" method="post">
                            <table class="table table-borderless">
                                <tr>
                                    <td>
                                        <input type="text" name="userid" id="txt_id" class="form-control" placeholder="Input Your ID" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="password" name="pass" id="txt_pass" class="form-control" placeholder="Input Your Passoword" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right"><input type="submit" name="TblLogin" value="Login" class="btn btn-primary"></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </center>
    </div>
</body>
</html>
