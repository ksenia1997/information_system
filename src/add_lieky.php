<? header("Content-Type: text/html; charset=UTF-8");?>
<?php
session_start();

if(isset($_SESSION["username"])) {
    if(isset($_SESSION["role"])) {
        if($_SESSION["role"] == "sestra"){
            header("location:home.php");
        }
    }
}

// premenne pre prihlasenie
$nazov = '';
$davkovanie = '';
$spec_doba_podania = '';
$typ = '';
$ucinna_latka = '';
$kontraindikacie = null;
$changed = 0;

// pripojenie k databaze
//include 'menu.php';
include 'database/connect.php';
if(isset($_POST["added"])){
  $nazov = $_POST["Nazov"];
  $davkovanie = $_POST["Davkovanie"];
  $spec_doba_podania = $_POST["SpecDobaPodania"];
  $typ = $_POST["Typ"];
  $ucinna_latka = $_POST["Ucinna_latka"];
  $kontraindikacie = $_POST["Kontraindikacie"];
  if(empty($nazov) || (empty($davkovanie)) || (empty($spec_doba_podania))
      || (empty($typ)) || (empty($ucinna_latka))) {
        $message = '<label>Vyplňte všetky údaje.</label>';
  }
  else {
    $query1 = $db->query('SELECT * FROM Liek');
    $max_id_lieku = 0;
    while($r = $query1->fetch()) {
      if($r['ID_Lieku'] > $max_id_lieku) {
        $max_id_lieku = $r['ID_Lieku'];
      }
    }
    $max_id_lieku += 1;
    $sql = "INSERT INTO Liek (ID_Lieku, Nazov, Davkovanie, Specificka_doba_podavania, Typ, Ucinna_latka, Kontraindikacie) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $query = $db->prepare($sql);
    $query->execute(array($max_id_lieku, $nazov, $davkovanie, $spec_doba_podania, $typ, $ucinna_latka, $kontraindikacie));
    $changed = 1;
    $nazov = '';
    $davkovanie = '';
    $spec_doba_podania = '';
    $typ = '';
    $ucinna_latka = '';
    $kontraindikacie = '';
  }

}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pridať liek</title>
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
    <h3 align="">Pridať nový liek</h3><br />
    <form method="post">
        <label>Nazov*</label>
        <input type="text" name="Nazov" class="form-control" value = "<?php echo $nazov;?>" />
        <br />
        <label>Davkovanie*</label>
        <input type="text" name="Davkovanie" class="form-control" value = "<?php echo $davkovanie;?>"/>
        <br />
        <label>Specificka doba podavania*</label>
        <input type="text" name="SpecDobaPodania" class="form-control" value = "<?php echo $spec_doba_podania;?>"/>
        <br />
        <label>Typ*</label>
        <input type="text" name="Typ" class="form-control" value = "<?php echo $typ;?>"/>
        <br />
        <label>Učinná latka*</label>
        <input type="text" name="Ucinna_latka" class="form-control" value = "<?php echo $ucinna_latka;?>"/>
        <br />
        <label>Kontraindikacie</label>
        <input type="text" name="Kontraindikacie" class="form-control" value = "<?php echo $kontraindikacie;?>"/>
        <br />
        <input type="submit" name="added" class="btn btn-primary" value="Pridať" />
    </form>
    <br />
    <h6 align="">* - povinné údaje</h6><br />
</div>

</body>
</html>
