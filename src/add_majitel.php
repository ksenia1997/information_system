<? header("Content-Type: text/html; charset=UTF-8");?>
<?php
session_start();
// premenne pre prihlasenie
$message = "";
$meno = "";
$priezvisko = "";
$titul = "";
$adresa = "";
$changed = 0;
// pripojenie
//include 'menu.php';
include 'database/connect.php';
function check_if_letter($s) {
  for ($i = 0; $i < strlen($s); $i++){
    $char = $s[$i];
    if (is_numeric($char)) {
        return false;
    }
  }
  return true;
}
if(isset($_POST["added"])) {
  $meno = $_POST["Meno"];
  $priezvisko = $_POST["Priezvisko"];
  $titul = $_POST["Titul"];
  $adresa = $_POST["Adresa"];
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
    $query = $db->query('SELECT * FROM Majitel');
    $max_id_m = 0;
    while($r = $query->fetch()) {
      if($r['ID_Majitela'] > $max_id_m) {
        $max_id_m = $r['ID_Majitela'];
      }
    }
    $max_id_m += 1;
    $sql = "INSERT INTO Majitel(ID_Majitela, Meno, Priezvisko, Titul, Adresa) VALUES (?, ?, ?, ?, ?)";
    $query = $db->prepare($sql);
    $query->execute(array($max_id_m, $meno, $priezvisko, $titul, $adresa));
    $message = "";
    $meno = "";
    $priezvisko = "";
    $titul = "";
    $adresa = "";
    $changed = 1;
  }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pridať majiteľa</title>
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
    <h3 align="">Pridať majiteľa</h3><br />
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
        <input type="submit" name="added" class="btn btn-primary" value="Pridať" />
    </form>
    <br />
    <h6 align="">* - povinné údaje</h6><br />
</div>

<br />
</body>
</html>
