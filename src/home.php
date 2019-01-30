<? header("Content-Type: text/html; charset=UTF-8");?>
<?php
session_start();
if(isset($_SESSION["username"])) {
    $login = $_SESSION["username"];
    if(isset($_SESSION["role"])) {
        $pozicia = $_SESSION["role"];

    }
}
else {
    header("location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Prihlásené... </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
<?php
include "menu.php";
?>

<div class="container">
<div class="alert alert-success alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Úspech!</strong> Prihlásenie bolo úspešné!
</div>


<h3>Vitajte.
    <small> <br><br>Login: <?php
        if(isset($login)) {
            echo $login;
        }
        ?>
        <br>Pozícia: <?php
        if(isset($pozicia)) {
            echo $pozicia;
        }
        ?>
        </small></h3>
        <br>

    <a class="btn btn-primary" href="change_pswd.php" role="button"> Zmeniť heslo </a>
    <br>
</div>

</body>
</html>

