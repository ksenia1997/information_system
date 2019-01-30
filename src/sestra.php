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
else {
    header("location:index.php");   
}
$meno="";

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sestry </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
<?php
include "menu.php";
?>

<div class="container">

    <h3>Sestry</h3>
    <h4><small>Vyhľadávanie sestry</small></h4>
    <br>
    <form method = "get"">
    <div class="input-group mb-3">
        <input type="text" class="form-control" name="meno" placeholder="Priezvisko sestry...">
        <div class="input-group-append">
            <button class="btn btn-primary" name="hladat" type="submit">Hľadať</button>
        </div>
        <div class="input-group-append">
            <a href="sestra.php?meno=&hladat=" class="btn btn-primary" role="button" >Zobraziť všetky</a>
        </div>
    </div>
    </form>
    <br>
    <?php
    if(isset($_GET["hladat"])) {
        include 'database/connect.php';
        $meno = strtolower($_GET["meno"]);
        $sql = "SELECT * FROM Personal WHERE Typ = 'sestra' ";
        $query = $db->prepare($sql);
        $query->execute();

        $count = $query->rowCount();
        if($count > 0){
            $prvy_prechod = 1;
            while($r = $query->fetch(PDO::FETCH_OBJ)) {
                $hladane = strtolower(substr($r->Priezvisko,0,strlen($meno)));

                if(strcmp($hladane,$meno)==0 ){

                    if($prvy_prechod){
                        $prvy_prechod = 0;
                        echo '<form method="post" action="edit_sestra.php">
                        <br><br><br> <div class="container">
                              <h3>Výsledky vyhľadávania</h3>
                              <table class="table">
                                <thead>
                                  <tr>
                                    <th>Meno</th>
                                    <th>Priezvisko</th>
                                    <th>Titul</th>
                                    <th>Adresa</th>
                                    <th>Číslo účtu</th>
                                    <th>Hodinová mzda</th>
                                    <th>Rodné číslo</th>
                                    <th></th>
                                    <th></th>
                                  </tr>
                                </thead>
                                <tbody>';

                    }
                    echo '<tr>';
                    echo '<td>' .$r->Meno ;echo '</td>';
                    echo '<td>' .$r->Priezvisko;echo '</td>';
                    echo '<td>' .$r->Titul;echo '</td>';
                    echo '<td>' .$r->Adresa;echo '</td>';
                    echo '<td>' .$r->Cislo_uctu;echo '</td>';
                    echo '<td>' .$r->Hodinova_mzda;echo '</td>';
                    echo '<td>' .$r->Rodne_cislo;echo '</td>';
                    echo '<td><button type="submit" class="btn btn-outline-warning" Name = "edit" Value='.$r->ID_Sestry;echo ' >Upraviť</button></td>';
                    echo '<td><button type="submit"class="btn btn-outline-danger" Name = "delete" Value='.$r->ID_Sestry;echo ' >Odstrániť</button>';echo '</td>';
                    echo '</tr>';

                }
            }
            if ($prvy_prechod ==0){
                echo '</tbody>
                      </table>
                    </div>
                    </form>';
            }
            else{
                echo'<br><br><br>
                <div class="container">
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>0 výsledkov!</strong> Zadané priezvisko neexistuje!
                </div>
                </div>';
            }
        }

    }
    ?>
    <br>
    <a class="btn btn-primary" href="add_sestra.php" role="button"> + Pridať novú sestru </a>
    <br>
</div>

</body>
</html>