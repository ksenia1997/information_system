<? header("Content-Type: text/html; charset=UTF-8");?>
<?php

session_start();
if(!isset($_SESSION["username"])) {
    header("location:index.php");
}
// pripojenie k databaze
include 'database/connect.php';

if(isset($_POST["show"])){
    $_SESSION["id2"] = $_POST["show"];
    header("location:podavat_liek.php");
}

$zmenene =0;
if(isset($_POST["delete"])){
    $sql = "DELETE FROM Podany_liek WHERE ID_Liecby = ?";
    $query = $db->prepare($sql);
    $query->execute(array($_POST["delete"]));

    $sql = "DELETE FROM Liecba WHERE ID_Liecby = ?";
    $query = $db->prepare($sql);
    $query->execute(array($_POST["delete"]));

    header("location:liecba.php");
}


if(isset($_POST["edit"])or $_POST["added"]){
  if(isset($_POST["edit"])){
      //hladanie v databazi
      include 'database/connect.php';
      $sql = "SELECT * FROM Liecba WHERE ID_Liecby = ? ";
      $query = $db->prepare($sql);
      $query->execute(array($_POST["edit"]));

      $count = $query->rowCount();
      $r = $query->fetch(PDO::FETCH_OBJ);

      // premenne pre prihlasenie
      $message = "";
      $diagnoza = $r->Diagnoza;
      $cena = $r->Cena;
      $datum_zahajenia = $r->Datum_zahajenia;
      $datum_ukoncenia = $r->Datum_ukoncenia;
      $id_liecby = $r->ID_Liecby;
  }

  function check_if_float($s) {
    $counter = 0;
    for ($i = 0; $i < strlen($s); $i++) {
        $char = $s[$i];
        if (($char == '.') && ($counter == 0) && ($i != 0)) {
            $counter += 1;
        }
        else if (!is_numeric($char)) {
            return false;
        }
    }
    return true;
}

    if(isset($_POST["added"])){
        $diagnoza = $_POST["Diagnoza"];
        $cena = $_POST["Cena"];
        $datum_zahajenia = $_POST["Datum_zahajenia"];
        $datum_ukoncenia = $_POST["Datum_ukoncenia"];
        $id_liecby = $_POST["added"];
        if(empty($diagnoza) || (empty($datum_zahajenia))) {
              $message = '<label>Vyplňte všetky údaje.</label>';
        }
        else if ((!empty($datum_ukoncenia)) && (strcmp($datum_zahajenia, $datum_ukoncenia) > 0)) {
          $message = '<label>Datum ukončenia musí byť neskôr než datum zahájenia.</label>';
        }
        else if ((!empty($cena)) && (!(check_if_float($cena)))) {
          $cena = '';
          $message = '<label>Cena musí být číslo.</label>';
        }

        else {

          $sql = "UPDATE Liecba SET  Diagnoza = ?, Cena = ?, Datum_zahajenia = ?, Datum_ukoncenia = ? WHERE ID_Liecby = ?";
          $query = $db->prepare($sql);
          $query->execute(array( $diagnoza, $cena, $datum_zahajenia, $datum_ukoncenia, $id_liecby));
          $zmenene = 1;

        }
    }

}



?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Upraviť liečbu</title>
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
    <h3 align="">Upraviť liečbu</h3><br />
    <form method="post">
        <label>Diagnoza*</label>
        <input type="text" name="Diagnoza" class="form-control" value = "<?php echo $diagnoza;?>" />
        <br />
        <label>Cena</label>
        <input type="text" name="Cena" class="form-control" value = "<?php echo $cena;?>"/>
        <br />
        <label>Datum zahajenia*</label>
        <input type="date" name="Datum_zahajenia" class="form-control" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" value = "<?php echo $datum_zahajenia;?>"/>
        <br />
        <label>Datum ukončenia</label>
        <input type="date" name="Datum_ukoncenia" class="form-control" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}"  value = "<?php echo $datum_ukoncenia;?>"/>
        <br />
        <button type="submit"class="btn btn-outline-danger" Name = "added" Value="<?php echo $id_liecby?>">Upraviť</button>
    </form>
    <h6 align="">* - povinné údaje</h6><br />
</div>

<br />
</body>
</html>
