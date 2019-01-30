<? header("Content-Type: text/html; charset=UTF-8");?>
<?php
session_start();
if(!isset($_SESSION["username"])) {
    header("location:home.php");
}

if(isset($_SESSION["id3"])){
    if(isset($_SESSION["id3"])){
        $id_veterinara = $_SESSION["id3"];
    }

}
else{
    header("location:zvierata.php");
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Liečba </title>
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

    <h3>Liečba</h3>
    <h4><small> Pre podanie lieku vyberte liečbu.</small></h4>
    <?php

    include 'database/connect.php';
    $sql = "SELECT * FROM Liecba WHERE ID_Veterinara = ?";
    $query = $db->prepare($sql);
    $query->execute(array($id_veterinara));

    $count = $query->rowCount();
    if($count > 0){
        $prvy_prechod = 1;
        while($r = $query->fetch(PDO::FETCH_OBJ)) {



            if($prvy_prechod){
                $prvy_prechod = 0;
                echo '<form method="post" action="edit_liecba.php">
                <br><br><br> <div class="container">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Diagnóza</th>
                            <th>Cena</th>
                            <th>Dátum zahájenia</th>
                            <th>Dátum ukončenia</th>
                            <th>Zviera</th>
                            <th>Majitel</th>
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
            echo '<td>' .$r->Diagnoza ;echo '</td>';
            echo '<td>' .$r->Cena;echo '</td>';
            echo '<td>' .$r->Datum_zahajenia;echo '</td>';
            echo '<td>' .$r->Datum_ukoncenia;echo '</td>';
            echo '<td>';
            $sql2 = "SELECT * FROM Zviera WHERE ID_Zvierata = ? ";
            $query2 = $db->prepare($sql2);
            $query2->execute(array($r->ID_Zvierata));

            $count2 = $query2->rowCount();
            if($count2>0){
                $r2 = $query2->fetch(PDO::FETCH_OBJ);
                echo $r2->Meno;
            }

            echo '</td>';
            echo '<td>';
            $sql3 = "SELECT * FROM Majitel WHERE ID_Majitela = ? ";
            $query3 = $db->prepare($sql3);
            $query3->execute(array($r2->ID_Majitela));

            $count3 = $query3->rowCount();
            if($count3>0){
                $r3 = $query3->fetch(PDO::FETCH_OBJ);
                echo $r3->Meno;
                echo ' ';
                echo $r3->Priezvisko;
            }

            echo '</td>';
            echo '<td><button type="submit" class="btn btn-outline-primary " Name = "show" Value='.$r->ID_Liecby;echo ' >Zobraziť podané lieky</button></td>';
            echo '<td><button type="submit" class="btn btn-outline-warning" Name = "edit" Value='.$r->ID_Liecby;echo ' >Upraviť</button></td>';
            echo '<td><button type="submit" class="btn btn-outline-danger" Name = "delete" Value='.$r->ID_Liecby;echo ' >Odstrániť</button>';echo '</td>';


        }
        if ($prvy_prechod ==0){
            echo '</tbody>
                  </table>
                </div>
                </form>';
        }

    } else{
        echo'<br><br><br>
            <div class="container">
            <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>0 výsledkov!</strong> Neexistujú liečby pre tohto veterinára!
            </div>
            </div>';
    }
    ?>


    <br>
    <a class="btn btn-primary" href="add_vet_liecba.php" role="button"> + Pridať novú liečbu </a>
    <br>



</div>

</body>
</html>
