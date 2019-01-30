<? header("Content-Type: text/html; charset=UTF-8");?>
<?php
session_start();
session_destroy();
header("location:index.php");
?>