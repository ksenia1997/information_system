<? header("Content-Type: text/html; charset=UTF-8");?>
<?php
session_start();
if(!isset($_SESSION["username"])) {
    header("location:index.php");
}
$meno="";

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lieky </title>
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

    <h3>Prehľad liekov</h3>
    <h4><small>Vyhľadávanie lieku</small></h4>
    <br>
    <form method = "get"">
    <div class="input-group mb-3">
        <input type="text" class="form-control" name="meno" placeholder="Názov lieku...">
        <div class="input-group-append">
            <button class="btn btn-primary" name="hladat" type="submit">Hľadať</button>
        </div>
        <div class="input-group-append">
            <a href="lieky.php?meno=&hladat=" class="btn btn-primary" role="button" >Zobraziť všetkých</a>
        </div>
    </div>
    </form>
    <br>
    <?php
    if(isset($_GET["hladat"])) {
        include 'database/connect.php';
        $meno = strtolower($_GET["meno"]);
        $sql = "SELECT * FROM Liek ";
        $query = $db->prepare($sql);
        $query->execute();

        $count = $query->rowCount();
        if($count > 0){
            $prvy_prechod = 1;
            while($r = $query->fetch(PDO::FETCH_OBJ)) {
                $hladane = strtolower(substr($r->Nazov,0,strlen($meno)));

                if(strcmp($hladane,$meno)==0 ){

                    if($prvy_prechod){
                        $prvy_prechod = 0;
                        echo '<form method="post" action="edit_lieky.php">
                        <br><br><br> <div class="container">
                              <h3>Výsledky vyhľadávania</h3>
                              <table class="table">
                                <thead>
                                  <tr>
                                    <th>Názov</th>
                                    <th>Dávkovanie</th>
                                    <th>Špecifická doba podávania</th>
                                    <th>Typ</th>
                                    <th>Účinná látka</th>
                                    <th>Kontraindikácie</th>
                                    <th></th>
                                  </tr>
                                </thead>
                                <tbody>';

                    }
                    echo '<tr>';
                    echo '<td>' .$r->Nazov ;echo '</td>';
                    echo '<td>' .$r->Davkovanie;echo '</td>';
                    echo '<td>' .$r->Specificka_doba_podavania;echo '</td>';
                    echo '<td>' .$r->Typ;echo '</td>';
                    echo '<td>' .$r->Ucinna_latka;echo '</td>';
                    echo '<td>' .$r->Kontraindikacie;echo '</td>';
                    echo '<td><button type="submit" class="btn btn-outline-warning" Name = "edit" Value='.$r->ID_Lieku;echo ' >Upraviť</button></td>';
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
                    <strong>0 výsledkov!</strong> Zadaný názov neexistuje!
                </div>
                </div>';
            }
        }

    }
    ?>
    <br>
    <a class="btn btn-primary" href="add_lieky.php" role="button"> + Pridať nový liek </a>
    <br>
</div>

</body>
</html>