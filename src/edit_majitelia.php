<? header("Content-Type: text/html; charset=UTF-8");?>
<?php

session_start();
if(isset($_SESSION["username"])) {


}
else {
    header("location:index.php");
}
// pripojenie k databaze
include 'database/connect.php';

$zmenene =0;
if(isset($_POST["show"])){

    if(isset($_POST["show"])){
        $_SESSION["id4"] = $_POST["show"];
        header("location:show_majitelove_zvery.php");
    }

}

if(isset($_POST["delete"])){

    if(isset($_SESSION["role"])) {
        if(($_SESSION["role"] == "sestra" )){
            header("location:home.php");
        }
    }
    $sql = "SELECT * FROM Zviera WHERE ID_Majitela = ?";
    $query = $db -> prepare($sql);
    $query->execute(array($_POST["delete"]));
    while($r = $query->fetch(PDO::FETCH_OBJ)) {
      $sql2 = "SELECT * FROM Liecba WHERE ID_Zvierata = ?";
      $query2 = $db->prepare($sql2);
      $query2->execute(array($r->ID_Zvierata));
      while($row = $query2->fetch(PDO::FETCH_OBJ)) {
          $sql1 = "DELETE FROM Podany_liek WHERE ID_Liecby = ?";
          $query1 = $db->prepare($sql1);
          $query1->execute(array($row->ID_Liecby));
      }
      $sql3 = "DELETE FROM Liecba WHERE ID_Zvierata = ?";
      $query3 = $db->prepare($sql3);
      $query3->execute(array($r->ID_Zvierata));

      $sql4 = "DELETE FROM Zviera WHERE ID_Zvierata = ?";
      $query4 = $db->prepare($sql4);
      $query4->execute(array($r->ID_Zvierata));
    }

    $sql5 = "DELETE FROM Majitel WHERE ID_Majitela = ?";
    $query5 = $db->prepare($sql5);
    $query5->execute(array($_POST["delete"]));
    header("location:majitelia.php");
}


if(isset($_POST["edit"])or $_POST["added"]){
    if(isset($_SESSION["role"])) {
        if(($_SESSION["role"] == "sestra" )){
            header("location:home.php");
        }
    }

    if(isset($_POST["edit"])){
        //hladanie v databazi
        include 'database/connect.php';
        $sql = "SELECT * FROM  Majitel WHERE ID_Majitela = ? ";
        $query = $db->prepare($sql);
        $query->execute(array($_POST["edit"]));

        $count = $query->rowCount();
        $r = $query->fetch(PDO::FETCH_OBJ);

        // premenne pre prihlasenie
        $meno = $r->Meno;
        $priezvisko = $r->Priezvisko;
        $titul = $r->Titul;
        $adresa = $r->Adresa;
        $id_majitela =$_POST["edit"];

    }

    function check_if_letter($s) {
        for ($i = 0; $i < strlen($s); $i++){
            $char = $s[$i];
            if (is_numeric($char)) {
                return false;
            }
        }
        return true;
    }


    if(isset($_POST["added"])){
      $meno = $_POST["Meno"];
      $priezvisko = $_POST["Priezvisko"];
      $titul = $_POST["Titul"];
      $adresa = $_POST["Adresa"];
      $id_majitela =$_POST["added"];
      if((empty($meno)) || (empty($priezvisko))
        || (empty($adresa))) {
            $message = '<label>Vyplňte všetky údaje.</label>';
      }
      else if (!check_if_letter($meno)) {
        $meno = '';
        $message = '<label>Meno nesmie obsahovať čísla.</label>';
      }
      else if (!check_if_letter($priezvisko)) {
        $priezvisko = '';
        $message = '<label>Priezvisko nesmie obsahovať čísla.</label>';
      }
      else if ((strlen($meno) > 20)) {
        $meno = '';
        $message = '<label>Prekročená maximálna veľkosť údaju.</label>';
      }
      else if ((strlen($priezvisko) > 30)) {
        $priezvisko = '';
        $message = '<label>Prekročená maximálna veľkosť údaju.</label>';
      }
      else if ((strlen($titul) > 15)) {
        $titul = '';
        $message = '<label>Prekročená maximálna veľkosť údaju.</label>';
      }
      else if ((strlen($adresa) > 30)){
        $adresa = '';
        $message = '<label>Prekročená maximálna veľkosť údaju.</label>';
      }
      else {
        $sql = "UPDATE Majitel SET  Meno = ?, Priezvisko = ?, Titul = ?, Adresa = ? WHERE ID_Majitela = ?";
        $query = $db->prepare($sql);
        $query->execute(array( $meno, $priezvisko, $titul, $adresa, $id_majitela));
        $zmenene = 1;
      }
    }

}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Upraviť majiteľa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
</head>
<body>
<?include 'menu.php';?>
<br />
<div class="container" style="width:500px;">
    <?php
    if(isset($message))
    {
        echo '<label class="text-danger">'.$message.'</label>';
    }
    if ($zmenene == 1) {
      echo '<div class="alert alert-success">';
      echo '<strong>Úspech!</strong> Úprava bola úspešná! </div>';
    }
    ?>
    <h3 align="">Upraviť majiteľa</h3><br />
    <form method="post">
        <label>Meno*</label>
        <input type="text" name="Meno" class="form-control" value = "<?php echo $meno;?>"/>
        <br />
        <label>Priezvisko*</label>
        <input type="text" name="Priezvisko" class="form-control" value = "<?php echo $priezvisko;?>"/>
        <br />
        <label>Titul</label>
        <input type="text" name="Titul" class="form-control" value = "<?php echo $titul;?>"/>
        <br />
        <label>Adresa*</label>
        <input type="text" name="Adresa" class="form-control" value = "<?php echo $adresa;?>"/>
        <br />
        <button type="submit"class="btn btn-outline-danger" Name = "added" Value="<?php echo $id_majitela?>">Upraviť</button>
    </form>
    <br />
    <h6 align="">* - povinné údaje</h6><br />
</div>

</body>
</html>
