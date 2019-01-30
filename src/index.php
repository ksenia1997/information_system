<? header("Content-Type: text/html; charset=UTF-8");?>
<?php

session_start();
// premenne pre prihlasenie
$message = "";
$login="";

// pripojenie k databaze
include 'database/connect.php';

if(isset($_POST["login"])){
    if(!empty($_POST["username"])){
        $login = $_POST["username"];
    }
    if(empty($_POST["username"]) || empty($_POST["password"])){
        $message = '<label>Vyplň meno a heslo!</label>';
   }
   else{
        $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
        $query = $db->prepare($sql);
        $query->execute(array($_POST["username"],hash('sha256', $_POST["password"]) ));
        $count = $query->rowCount();
        $r = $query->fetch(PDO::FETCH_OBJ);
        if($count > 0){
             $_SESSION["username"] = $_POST["username"];
             $_SESSION["role"] = $r->role;
             header("location:home.php");
        }
        else{
             $message = '<label>Zlé používateľské meno či heslo!</label>';
        }
   }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
<br />
<div class="container" style="width:500px;">
    <?php
    if(isset($message)) {
        echo '<label class="text-danger">'.$message.'</label>';
    }
    ?>
    <h3 align="">Veterinarna klinika</h3><br />
    <h4 align="">Prosím prihláste sa:</h4><br />
    <form method="post">
        <label>Prihlasovacie meno</label>
        <input type="text" name="username" class="form-control" value="<?php echo $login;?>"/>
        <br />
        <label>Heslo</label>
        <input type="password" name="password" class="form-control" />
        <br />
        <input type="submit" name="login" class="btn btn-primary" value="Prihlásiť" />
    </form>
</div>
<br />
</body>
</html>


