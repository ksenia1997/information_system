<? header("Content-Type: text/html; charset=UTF-8");?>
<?php
session_start();
if(!isset($_SESSION["username"])) {
    header("location:home.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Zvieratá </title>
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

    <h3>Zvieratá</h3>
    <h4><small>Vyhľadávanie zvierat. Pre liečbu vyhľadajte či vyberte zviera.</small></h4>
    <br>
    <form method = "get">
    <div class="input-group mb-3">
        <input type="text" class="form-control" name="meno" placeholder="Meno zvieraťa...">
        <div class="input-group-append">
            <button class="btn btn-primary" name="hladat" type="submit">Hľadať</button>
        </div>
        <div class="input-group-append">
            <a href="zvierata.php?meno=&hladat=" class="btn btn-primary" role="button" >Zobraziť všetky</a>
        </div>
    </div>
    </form>
    <br>
    <?php
    if(isset($_GET["hladat"])) {
        include 'database/connect.php';
        $meno = strtolower($_GET["meno"]);
        $sql = "SELECT * FROM Zviera";
        $query = $db->prepare($sql);
        $query->execute();

        $count = $query->rowCount();
        if($count > 0){
            $prvy_prechod = 1;
            while($r = $query->fetch(PDO::FETCH_OBJ)) {
                $hladane = strtolower(substr($r->Meno,0,strlen($meno)));

                if(strcmp($hladane,$meno)==0 ){

                    if($prvy_prechod){
                        $prvy_prechod = 0;
                        echo '<form method="post" action="edit_zvierata.php">
                        <br><br><br> <div class="container">
                              <h3>Výsledky vyhľadávania</h3>
                              <table class="table">
                                <thead>
                                  <tr>
                                    <th>Meno</th>
                                    <th>Dátum narodenia</th>
                                    <th>Dátum poslednej prehliadky</th>
                                    <th>Majiteľ</th>
                                    <th></th>
                                    <th></th>';
                                    if(!($_SESSION["role"] == "sestra" )) {
                                        echo '<th ></th >';
                                        }
                                  echo '</tr>
                                </thead>
                                <tbody>';

                    }
                    echo '<tr>';
                    echo '<td>' .$r->Meno ;echo '</td>';
                    echo '<td>' .$r->Datum_narodenia;echo '</td>';
                    echo '<td>' .$r->Datum_poslednej_prehliadky;echo '</td>';
                    echo '<td>';
                    $sql2 = "SELECT * FROM Majitel WHERE ID_Majitela = ? ";
                    $query2 = $db->prepare($sql2);
                    $query2->execute(array($r->ID_Majitela));

                    $count2 = $query2->rowCount();
                    if($count2>0){
                        $r2 = $query2->fetch(PDO::FETCH_OBJ);
                        echo $r2->Meno;
                        echo ' ';
                        echo $r2->Priezvisko;
                    }

                    echo '</td>';
                    echo '<td><button type="submit" class="btn btn-outline-primary " Name = "show" Value='.$r->ID_Zvierata;echo ' >Zobraziť liečby</button></td>';
                    echo '<td><button type="submit" class="btn btn-outline-warning" Name = "edit" Value='.$r->ID_Zvierata;echo ' >Upraviť</button></td>';
                    if(!($_SESSION["role"] == "sestra" )){
                        echo '<td><button type="submit" class="btn btn-outline-danger" Name = "delete" Value='.$r->ID_Zvierata;echo ' >Odstrániť</button>';echo '</td>';
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

    if(isset($_SESSION["role"])) {
        if($_SESSION["role"] != "sestra"){
            echo '<br>
            <a class="btn btn-primary" href="add_zvierata.php" role="button"> + Pridať nové zviera </a>
            <br>';
        }
    }
    ?>


</div>

</body>
</html>