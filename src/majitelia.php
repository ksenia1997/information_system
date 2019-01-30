<? header("Content-Type: text/html; charset=UTF-8");?>
<?php
session_start();
if(!isset($_SESSION["username"])) {
    header("location:home.php");
}
$meno="";
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Majitelia </title>
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

    <h3>Majitelia</h3>
    <h4><small>Vyhľadávanie majiteľov. Vyhľadajte majiteľa pre zobrazenie jeho zvierat</small></h4>
    <br>
    <form method = "get"">
    <div class="input-group mb-3">
        <input type="text" class="form-control" name="meno" placeholder="Priezvisko majiteľa...">
        <div class="input-group-append">
            <button class="btn btn-primary" name="hladat" type="submit">Hľadať</button>
        </div>
        <div class="input-group-append">
            <a href="majitelia.php?meno=&hladat=" class="btn btn-primary" role="button" >Zobraziť všetkých</a>
        </div>
    </div>
    </form>
    <br>
    <?php
    if(isset($_GET["hladat"])) {
        include 'database/connect.php';
        $meno = strtolower($_GET["meno"]);
        $sql = "SELECT * FROM Majitel  ";
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
                        echo '<form method="post" action="edit_majitelia.php">
                        <br><br><br> <div class="container">
                              <h3>Výsledky vyhľadávania</h3>
                              <table class="table">
                                <thead>
                                  <tr>
                                    <th>Meno</th>
                                    <th>Priezvisko</th>
                                    <th>Titul</th>
                                    <th>Adresa</th>
                                    <th></th>';
                                     if(!($_SESSION["role"] == "sestra" )){
                                            echo '<th></th>
                                                <th></th>';
                                        }
                                    echo '
                                  </tr>
                                </thead>
                                <tbody>';

                    }
                    echo '<tr>';
                    echo '<td>' .$r->Meno ;echo '</td>';
                    echo '<td>' .$r->Priezvisko;echo '</td>';
                    echo '<td>' .$r->Titul;echo '</td>';
                    echo '<td>' .$r->Adresa;echo '</td>';
                    echo '<td><button type="submit" class="btn btn-outline-primary " Name = "show" Value='.$r->ID_Majitela;echo ' >Zobraziť zvieratá</button></td>';
                    if(!($_SESSION["role"] == "sestra" )){
                        echo '<td><button type="submit" class="btn btn-outline-warning" Name = "edit" Value='.$r->ID_Majitela;echo ' >Upraviť</button></td>';
                        echo '<td><button type="submit"class="btn btn-outline-danger" Name = "delete" Value='.$r->ID_Majitela;echo ' >Odstrániť</button>';echo '</td>';
                    }
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

    <?php

    if(isset($_SESSION["role"])) {
        if($_SESSION["role"] != "sestra"){
           echo '<br>
            <a class="btn btn-primary" href="add_majitel.php" role="button"> + Pridať nového majiteľa </a>
            <br>';
        }
    }


    ?>


</div>

</body>
</html>