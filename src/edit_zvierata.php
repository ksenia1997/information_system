<? header("Content-Type: text/html; charset=UTF-8");?>
<?php

session_start();
if(!isset($_SESSION["username"])) {
    header("location:index.php");
}
// pripojenie k databaze
include 'database/connect.php';
$changed = 0;
if(isset($_POST["show"])){
    $_SESSION["id1"] = $_POST["show"];
    header("location:liecba.php");
}
if(isset($_POST["delete"])){
  if(isset($_SESSION["role"])) {
      if(($_SESSION["role"] == "sestra" )){
          header("location:zvierata.php");
      }
  }

        $sql = "SELECT * FROM Liecba WHERE ID_Zvierata = ?";
        $query = $db->prepare($sql);
        $query->execute(array($_POST["delete"]));
        while($r = $query->fetch(PDO::FETCH_OBJ)) {
            $sql1 = "DELETE FROM Podany_liek WHERE ID_Liecby = ?";
            $query1 = $db->prepare($sql1);
            $query1->execute(array($r->ID_Liecby));
        }
        $sql2 = "DELETE FROM Liecba WHERE ID_Zvierata = ?";
        $query2 = $db->prepare($sql2);
        $query2->execute(array($_POST["delete"]));

        $sql3 = "DELETE FROM Zviera WHERE ID_Zvierata = ?";
        $query3 = $db->prepare($sql3);
        $query3->execute(array($_POST["delete"]));
        header("location:zvierata.php");

}

if(isset($_POST["edit"])or $_POST["added"]){
  if(isset($_POST["edit"])){
      //hladanie v databazi
      include 'database/connect.php';
      $sql = "SELECT * FROM  Zviera WHERE ID_Zvierata = ? ";
      $query = $db->prepare($sql);
      $query->execute(array($_POST["edit"]));

      $count = $query->rowCount();
      $r = $query->fetch(PDO::FETCH_OBJ);

      // premenne pre prihlasenie
      $meno = $r->Meno;
      $datum_narodenia = $r->Datum_narodenia;
      $datum_poslednej_prehliadky = $r->Datum_poslednej_prehliadky;
      $id_zvierata =$_POST["edit"];

  }

  if(isset($_POST["added"])){

    $meno = $_POST["Meno"];
    $datum_narodenia = $_POST["Datum_narodenia"];
    $datum_poslednej_prehliadky = $_POST["Datum_poslednej_prehliadky"];
    $id_zvierata = $_POST["added"];
    if((empty($meno)) || (empty($datum_poslednej_prehliadky))) {
      $message = '<label>Vyplňte všetky údaje.</label>';
    }
    else if ((strcmp($datum_narodenia, "") != 0) && (strcmp($datum_narodenia, $datum_poslednej_prehliadky) > 0 )) {
      $message = '<label>Datum narodenia musí byť skôr než datum poslední prehliadky.</label>';
    }
    else {
      $sql = "UPDATE Zviera SET  Meno = ?, Datum_narodenia = ?, Datum_poslednej_prehliadky = ? WHERE ID_Zvierata = ?";
      $query = $db->prepare($sql);
      $query->execute(array( $meno, $datum_narodenia, $datum_poslednej_prehliadky, $id_zvierata));
      $changed = 1;
    }
  }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Upraviť zviera </title>
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
      echo '<strong>Úspech!</strong> Úprava bola úspešná! </div>';
    }
  ?>
  <h3 align="">Upraviť zviera</h3><br />
  <form id="form1" name="form1" method="post">
    <label>Meno*</label>
    <input type="text" name="Meno" class="form-control" value = "<?php echo $meno;?>"/>
    <br />
    <label>Datum narodenia</label>
    <input type="date" name="Datum_narodenia" class="form-control" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" value = "<?php echo $datum_narodenia;?>"/>
    <br />
    <label>Datum poslednej prehliadky*</label>
    <input type="date" name="Datum_poslednej_prehliadky" class="form-control" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" value = "<?php echo $datum_poslednej_prehliadky;?>"/>
    <br />
    <button type="submit"class="btn btn-outline-danger" Name = "added" Value="<?php echo $id_zvierata?>">Upraviť</button>
    </form>
    <br />
    <h6 align="">* - povinné údaje</h6><br />
</div>

</body>
</html>
