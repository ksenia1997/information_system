<? header("Content-Type: text/html; charset=UTF-8");?>
<?php

session_start();
if(isset($_SESSION["username"])) {
    if(isset($_SESSION["role"])) {
        if(!$_SESSION["role"] == "admin"){
            header("location:home.php");
        }
    }
}
else {
    header("location:index.php");
}
// pripojenie k databaze
include 'database/connect.php';

if(isset($_POST["delete"])){

    $sql = "DELETE FROM users WHERE id = ?";
    $query = $db->prepare($sql);
    $query->execute(array($_POST["delete"]));
    header("location:administrate.php");

}

?>

