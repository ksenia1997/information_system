<? header("Content-Type: text/html; charset=UTF-8");?>
<?php

session_start();
if(!isset($_SESSION["username"])) {
    header("location:index.php");
}
// pripojenie k databaze
include 'database/connect.php';

$zmenene =0;


if(isset($_POST["edit"])or $_POST["added"]){
    if(isset($_POST["edit"])){
        //hladanie v databazi
        include 'database/connect.php';
        $sql = "SELECT * FROM Liek WHERE ID_Lieku = ?";
        $query = $db->prepare($sql);
        $query->execute(array($_POST["edit"]));

        $count = $query->rowCount();
        $r = $query->fetch(PDO::FETCH_OBJ);

// premenne pre prihlasenie
        $message = "";
        $nazov = $r->Nazov;
        $davkovanie = $r->Davkovanie;
        $spec_doba_podania = $r->Specificka_doba_podavania;
        $typ = $r->Typ;
        $ucinna_latka = $r->Ucinna_latka;
        $kontraindikacie = $r->Kontraindikacie;
        $id_lieku = $r->ID_Lieku;
    }


        if(isset($_POST["added"])){
            $nazov = $_POST["Nazov"];
            $davkovanie = $_POST["Davkovanie"];
            $spec_doba_podania = $_POST["SpecDobaPodania"];
            $typ = $_POST["Typ"];
            $ucinna_latka = $_POST["Ucinna_latka"];
            $kontraindikacie = $_POST["Kontraindikacie"];
            $id_lieku = $_POST["added"];
            if(empty($nazov) || (empty($davkovanie)) || (empty($spec_doba_podania))
                || (empty($typ)) || (empty($ucinna_latka))) {
                $message = '<label>Vyplňte všetky údaje.</label>';
            }
            else {

                $sql = "UPDATE Liek SET Nazov = ?, Davkovanie = ?, Specificka_doba_podavania = ?, Typ = ?, Ucinna_latka = ?, Kontraindikacie = ?  WHERE ID_Lieku = ? ";
                $query = $db->prepare($sql);
                $query->execute(array( $nazov, $davkovanie, $spec_doba_podania, $typ, $ucinna_latka, $kontraindikacie, $id_lieku));
                $zmenene = 1;

            }
        }

}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Upraviť doktora </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
</head>
<body>
<?php
include 'menu.php';
?>
<br />
<div class="container" style="width:500px;">
    <?php
    if(isset($message))
    {
        echo '<label class="text-danger">'.$message.'</label>';
    }
    if($zmenene == 1){
        echo '<br><div class="alert alert-success">';
        echo '<strong>Úspech!</strong> Úprava bola úspešná! </div>';
    }
    ?>
    <h3 align="">Upraviť liek</h3><br />
    <form method="post">
        <label>Názov*</label>
        <input type="text" name="Nazov" class="form-control" value = "<?php echo $nazov;?>" />
        <br />
        <label>Dávkovanie*</label>
        <input type="text" name="Davkovanie" class="form-control" value = "<?php echo $davkovanie;?>"/>
        <br />
        <label>Špecifická doba podávania*</label>
        <input type="text" name="SpecDobaPodania" class="form-control" value = "<?php echo $spec_doba_podania;?>"/>
        <br />
        <label>Typ*</label>
        <input type="text" name="Typ" class="form-control" value = "<?php echo $typ;?>"/>
        <br />
        <label>Účinná látka*</label>
        <input type="text" name="Ucinna_latka" class="form-control" value = "<?php echo $ucinna_latka;?>"/>
        <br />
        <label>Kontraindikácie</label>
        <input type="text" name="Kontraindikacie" class="form-control" value = "<?php echo $kontraindikacie;?>"/>
        <br />
        <button type="submit"class="btn btn-outline-danger" Name = "added" Value="<?php echo $id_lieku?>">Upraviť</button>
    </form>
    <br />
    <h6 align="">* - povinné údaje</h6><br />
</div>

<br />
</body>
</html>
