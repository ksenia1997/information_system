<? header("Content-Type: text/html; charset=UTF-8");?>
<?php
session_start();
if(isset($_SESSION["username"])) {
  if(isset($_SESSION["role"])) {
    if(($_SESSION["role"] == "sestra" )){
      header("location:home.php");
    }
  }
}
//include 'menu.php';
include 'database/connect.php';
$meno = '';
$datum_narodenia = '';
$datum_poslednej_prehliadky = '';
$majitel_id = '';
$changed = 0;


if(isset($_POST["added"])){
  $meno = $_POST["Meno"];
  $datum_narodenia = $_POST["Datum_narodenia"];
  $datum_poslednej_prehliadky = $_POST["Datum_poslednej_prehliadky"];
  $majitel_id = $_POST["Majitel_id"];
  if((empty($meno)) || (empty($datum_poslednej_prehliadky)) || (empty($majitel_id))) {
        $message = '<label>Vyplňte všetky údaje.</label>';
  }
  else {
      $query1 = $db->query('SELECT * FROM Zviera');
      $max_id_zviera = 0;
      while($r = $query1->fetch()) {
        if($r['ID_Zvierata'] > $max_id_zviera) {
          $max_id_zviera = $r['ID_Zvierata'];
        }
      }
      $max_id_zviera += 1;
      $sql = "INSERT INTO Zviera (ID_Zvierata, Meno, Datum_narodenia, Datum_poslednej_prehliadky, ID_Majitela) VALUES (?, ?, ?, ?, ?)";
      $query = $db->prepare($sql);
      $query->execute(array($max_id_zviera, $meno, $datum_narodenia, $datum_poslednej_prehliadky, $majitel_id));
      $meno = '';
      $datum_narodenia = '';
      $datum_poslednej_prehliadky = '';
      $majitel_id = '';
      $changed = 1;
  }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pridať zviera </title>
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
  <h3 align="">Pridať zviera</h3><br />
  <form id="form1" name="form1" method="post">
    <label>Meno*</label>
    <input type="text" name="Meno" class="form-control" value = "<?php echo $meno;?>"/>
    <br />
    <label>Datum narodenia</label>
    <input type="date" name="Datum_narodenia" class="form-control" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" value = "<?php echo $datum_narodenia;?>"/>
    <br />
    <label>Majiteľ*</label>
    <select name = "Majitel_id" class="custom-select mb-3">
      <option value="">--- Vybrať ---</option>
      <?php
        include 'database/connect.php';
        $sql = "SELECT * FROM Majitel";
        $query = $db->prepare($sql);
        $query->execute();
        while($r = $query->fetch(PDO::FETCH_OBJ)) {
      ?>
      <option value="<? echo $r->ID_Majitela; ?>">
          <?php
            echo $r->Meno;
            echo" ";
            echo $r->Priezvisko;
            echo" ";
            echo $r->Adresa;
          ?>
        </option>
      <?
        }
      ?>
    </select>
    <br />
    <label>Datum poslednej prehliadky*</label>
    <input type="date" name="Datum_poslednej_prehliadky" class="form-control" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" value = "<?php echo $datum_poslednej_prehliadky;?>"/>
    <br />
    <input type="submit" name="added" class="btn btn-primary" value="Pridať" />
  </form>
  <br />
  <h6 align="">* - povinné údaje</h6><br />
</div>

</body>
</html>
