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
else {
    header("location:index.php");
}
// pripojenie k databaze
include 'database/connect.php';
if(isset($_POST["show"])){
    $_SESSION["id3"] = $_POST["show"];
    header("location:doctor.php");
}

$zmenene =0;



if(isset($_POST["edit"])or $_POST["added"]){

    if(isset($_SESSION["role"])) {
        if($_SESSION["role"] != "admin"){
            header("location:home.php");
        }
    }
    if(isset($_POST["edit"])){
        //hladanie v databazi
        include 'database/connect.php';
        $sql = "SELECT * FROM Personal WHERE ID_Veterinara = ? ";
        $query = $db->prepare($sql);
        $query->execute(array($_POST["edit"]));

        $count = $query->rowCount();
        $r = $query->fetch(PDO::FETCH_OBJ);

// premenne pre prihlasenie
        $message = "";
        $rodne_cislo = $r->Rodne_cislo;
        $meno = $r->Meno;
        $priezvisko = $r->Priezvisko;
        $titul = $r->Titul;
        $adresa = $r->Adresa;
        $cislo_uctu = $r->Cislo_uctu;
        $hodiova_mzda = $r->Hodinova_mzda;
        $rola = $r->Typ;
        $id_veterinara = $r->ID_Veterinara;
    }



    function check_if_number($s) {
        for ($i = 0; $i < strlen($s); $i++){
            $char = $s[$i];
            if (!is_numeric($char)) {
                return false;
            }
        }
        return true;
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

    if(isset($_SESSION["username"])) {
        if(isset($_SESSION["role"])) {
            if($_SESSION["role"] != "admin"){
                header("location:home.php");
            }
            else{



                if(isset($_POST["added"])){
                    $rodne_cislo = $_POST["Rodne_cislo"];
                    $meno = $_POST["Meno"];
                    $priezvisko = $_POST["Priezvisko"];
                    $titul = $_POST["Titul"];
                    $adresa = $_POST["Adresa"];
                    $cislo_uctu = $_POST["Cislo_uctu"];
                    $hodiova_mzda =  $_POST["Hodinova_mzda"];
                    if(empty($rodne_cislo) || (empty($meno)) || (empty($priezvisko))
                        || (empty($adresa)) || (empty($cislo_uctu))
                        || (empty($hodiova_mzda))) {
                        $message = '<label>Vyplňte všetky údaje.</label>';
                    }
                    else if (!check_if_number($rodne_cislo)) {
                        $rodne_cislo = '';
                        $message = '<label>Chyba v rodnom čísle.</label>';
                    }
                    else if (!check_if_letter($meno)) {
                        $meno = '';
                        $message = '<label>Meno nesmie obsahovať čísla.</label>';
                    }
                    else if (!check_if_letter($priezvisko)) {
                        $priezvisko = '';
                        $message = '<label>Priezvisko nesmie obsahovať čísla.</label>';
                    }
                    else if (!(check_if_float($hodiova_mzda))) {
                        $hodiova_mzda = '';
                        $message = '<label>Hodinová mzda musí být číslo.</label>';
                    }
                    else if ((strlen($rodne_cislo) != 9)) {
                        $rodne_cislo = '';
                        $message = '<label>Prekročená maximálna veľkosť údaju. Rodné číslo musí mať 9 znakov.</label>';
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
                    else if ((strlen($cislo_uctu) > 50)) {
                        $cislo_uctu = '';
                        $message = '<label>Prekročená maximálna veľkosť údaju.</label>';
                    }
                    else {


                            $sql = "UPDATE Personal SET Rodne_cislo = ?, Meno = ?, Priezvisko = ?, Titul = ?, Adresa = ?, Cislo_uctu = ?, Hodinova_mzda = ? WHERE ID_Veterinara = ? ";
                            $query = $db->prepare($sql);
                            $query->execute(array($_POST["Rodne_cislo"], $_POST["Meno"], $_POST["Priezvisko"], $_POST["Titul"], $_POST["Adresa"], $_POST["Cislo_uctu"], $_POST["Hodinova_mzda"], $_POST["added"]));
                            $zmenene = 1;

                    }
                }
            }
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
    <h3 align="">Upraviť doktora</h3><br />
    <form method="post">
        <label>Rodné číslo*</label>
        <input type="text" name="Rodne_cislo" class="form-control" value = "<?php echo $rodne_cislo;?>" />
        <br />
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
        <label>Číslo účtu*</label>
        <input type="text" name="Cislo_uctu" class="form-control" value = "<?php echo $cislo_uctu;?>"/>
        <br />
        <label>Hodinová mzda*</label>
        <input type="text" name="Hodinova_mzda" class="form-control" value = "<?php echo $hodiova_mzda;?>"/>
        <br />
        <button type="submit"class="btn btn-outline-danger" Name = "added" Value="<?php echo $id_veterinara?>">Upraviť</button>
    </form>
    <h6 align="">* - povinné údaje</h6><br />
</div>

<br />
</body>
</html>
