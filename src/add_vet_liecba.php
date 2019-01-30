<? header("Content-Type: text/html; charset=UTF-8");?>
<?php
session_start();
if(isset($_SESSION["username"])) {
    if(isset($_SESSION["role"])) {
        if(!$_SESSION["role"] == "sestra"){
            header("location:home.php");
        }
    }
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
$diagnoza = '';
$cena = '';
$datum_zahajenia = '';
$datum_ukoncenia = '';
$changed = 0;
include 'database/connect.php';
if(isset($_POST["added"])){
  $diagnoza = $_POST["Diagnoza"];
  $cena = $_POST["Cena"];
  $datum_zahajenia = $_POST["Datum_zahajenia"];
  $datum_ukoncenia = $_POST["Datum_ukoncenia"];
  $veterinar_id = $_SESSION["id3"];
  $zviera_id = $_POST["ID_Zvierata"];
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
    $query1 = $db->query('SELECT * FROM Liecba');
    $max_id_liecby = 0;
    while($r = $query1->fetch()) {
      if($r['ID_Liecby'] > $max_id_liecby) {
        $max_id_liecby = $r['ID_Liecby'];
      }
    }
    $max_id_liecby += 1;
    $sql = "INSERT INTO Liecba (ID_Liecby,  Diagnoza, Cena, Datum_zahajenia, Datum_ukoncenia, ID_Zvierata, ID_Veterinara) VALUES(?, ?, ?, ?, ?, ?, ?)";
    $query = $db->prepare($sql);
    $query->execute(array($max_id_liecby, $diagnoza, $cena, $datum_zahajenia, $datum_ukoncenia, $zviera_id, $veterinar_id));
    $message = '';
    $diagnoza = '';
    $cena = '';
    $datum_zahajenia = '';
    $datum_ukoncenia = '';
    $changed = 1;
  }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pridať liečbu</title>
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
    if ($changed == 1) {
      echo '<div class="alert alert-success">';
      echo '<strong>Úspech!</strong> Pridanie bolo úspešné! </div>';
    }
    ?>
    <h3 align="">Pridať novú liečbu</h3><br />
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
        <label>Zviera*</label>
        <select name = "ID_Zvierata" class="custom-select mb-3">
          <option value="">--- Vybrať ---</option>
          <?php
            include 'database/connect.php';
            $sql = "SELECT * FROM Zviera";
            $query = $db->prepare($sql);
            $query->execute();
            while($r = $query->fetch(PDO::FETCH_OBJ)) {
          ?>
          <option value="<? echo $r->ID_Zvierata; ?>">
              <?php
                echo $r->Meno;
                echo" ";
                echo $r->Datum_narodenia;
                echo " ";
                echo $r->Datum_poslednej_prehliadky;
              ?>
          </option>
          <?
            }
          ?>
        </select>
        <br />
        <input type="submit" name="added" class="btn btn-primary" value="Pridať" />
    </form>
    <br />
    <h6 align="">* - povinné údaje</h6><br />
</div>

</body>
</html>
