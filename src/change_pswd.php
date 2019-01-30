<? header("Content-Type: text/html; charset=UTF-8");?>
<?php

session_start();
include 'database/connect.php';

if(isset($_SESSION["username"])) {
    $login = $_SESSION["username"];
    if(isset($_SESSION["role"])) {
        $pozicia = $_SESSION["role"];

    }
}
else {
    header("location:index.php");
}


$message = "";
$zmenene=0;

if(isset($_POST["zmena"])){
    if(empty($_POST["password1"]) || empty($_POST["password2"]) ||empty($_POST["password3"]) ){
        $message = '<label>Vyplň všetky údaje!</label>';
    }
    else{
        $hash1=hash('sha256', $_POST["password1"]);
        $hash2=hash('sha256', $_POST["password2"]);
        $hash3=hash('sha256', $_POST["password3"]);

        $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
        $query = $db->prepare($sql);
        $query->execute(array($login,$hash1 ));
        $count = $query->rowCount();
        $r = $query->fetch(PDO::FETCH_OBJ);
        if(!($count > 0)){
            $message = '<label>Zlé staré heslo!</label>';
        }
        else{
            $iduser =$r->id;
            if($hash2 != $hash3){
                $message = '<label>Heslá sa nezhodujú!</label>';
            }
            else{
                $sql = "UPDATE users SET password = ? WHERE username = ? AND id = ?";
                $query = $db->prepare($sql);
                $query->execute(array($hash3,$login,$iduser ));
                $zmenene=1;
            }
        }




    }
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Zmeniť heslo </title>
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
include 'menu.php';
?>
<br />
<div class="container" style="width:500px;">
    <?php
    if($zmenene == 1){
        echo '
            <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Úspech!</strong> Heslo bolo zmenené!
            </div>';
    }
    ?>

    <form method="post">
        <label>Staré heslo</label>
        <input type="password" name="password1" class="form-control" />
        <br>
        <label>Nové heslo</label>
        <input type="password" name="password2" class="form-control" />
        <br>
        <label>Znovu nové heslo</label>
        <input type="password" name="password3" class="form-control" />
        <br>
        <?php
        if(isset($message)) {
            echo '<label class="text-danger">'.$message.'</label>';
        }
        ?>
        <input type="submit" name="zmena" class="btn btn-primary" value="Zmeniť" />
    </form>

</div>
<br />
</body>
</html>


