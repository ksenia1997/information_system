<? header("Content-Type: text/html; charset=UTF-8");?>
<?php
session_start();
if(!isset($_SESSION["username"])) {
  header("location:index.php");
}
$cas_podania = '';
$miesto_podania = '';
$datum_podania = '';
$changed = 0;
include 'database/connect.php';
if(isset($_POST["added"])){
  $cas_podania = $_POST["Cas_podania"];
  $datum_podania = $_POST["Datum_podania"];
  $miesto_podania = $_POST["Miesto_podania"];
  if(empty($cas_podania) || (empty($datum_podania)) || (empty($miesto_podania))) {
        $message = '<label>Vyplňte všetky údaje.</label>';
  }
  else {
    $query1 = $db->query('SELECT * FROM Podany_liek');
    $sql = "INSERT INTO Podany_liek(Rodne_cislo, ID_Lieku, ID_Liecby, Datum_podania, Miesto_podania, Cas_podania) VALUES(?, ?, ?, ?, ?, ?)";
    $query = $db->prepare($sql);
    $query->execute(array($_POST["Rodne_cislo"], $_POST["ID_Lieku"], $_SESSION["id2"], $datum_podania, $miesto_podania, $cas_podania));
    $changed = 1;
    $cas_podania = '';
    $miesto_podania = '';
    $datum_podania = '';
    $message = '';
  }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pridať podavanie lieku</title>
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
    <h3 align="">Pridať podavanie lieku</h3><br />
    <form method="post">
        <label>Personal*</label>
        <select name = "Rodne_cislo" class="custom-select mb-3">
          <option value="">--- Vybrať ---</option>
          <?php
            include 'database/connect.php';
            $sql = "SELECT * FROM Personal";
            $query = $db->prepare($sql);
            $query->execute();
            while($r = $query->fetch(PDO::FETCH_OBJ)) {
          ?>
          <option value="<? echo $r->Rodne_cislo; ?>">
              <?php
                echo $r->Meno;
                echo" ";
                echo $r->Priezvisko;
                echo" ";
                echo $r->Typ;
              ?>
            </option>
          <?
            }
          ?>
        </select>
        <br />
        <label>Liek*</label>
        <select name = "ID_Lieku" class="custom-select mb-3">
          <option value="">--- Vybrať ---</option>
          <?php
            include 'database/connect.php';
            $sql = "SELECT * FROM Liek";
            $query = $db->prepare($sql);
            $query->execute();
            while($r = $query->fetch(PDO::FETCH_OBJ)) {
          ?>
          <option value="<? echo $r->ID_Lieku; ?>">
              <?php
                echo $r->Nazov;
                echo" ";
                echo $r->Davkovanie;
                echo" ";
                echo $r->Specificka_doba_podavania;
                echo" ";
                echo $r->Typ;
                echo" ";
                echo $r->Ucinna_latka;
              ?>
            </option>
          <?
            }
          ?>
        </select>
        <br />
        <label>Cas podania*</label>
        <input type="time" name="Cas_podania" class="form-control" required value = "<?php echo $cas_podania;?>" />
        <br />
        <label>Miesto podania*</label>
        <input type="text" name="Miesto_podania" class="form-control" value = "<?php echo $miesto_podania;?>"/>
        <br />
        <label>Datum podania*</label>
        <input type="date" name="Datum_podania" class="form-control" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" value = "<?php echo $datum_podania;?>"/>
        <br />
        <input type="submit" name="added" class="btn btn-primary" value="Pridať" />
    </form>
    <br />
    <h6 align="">* - povinné údaje</h6><br />
</div>
</body>
</html>
