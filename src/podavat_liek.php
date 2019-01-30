<? header("Content-Type: text/html; charset=UTF-8");?>
<?php
session_start();
if(!isset($_SESSION["username"])) {
    header("location:home.php");
}

if(isset($_SESSION["id2"])){
    if(isset($_SESSION["id2"])){
        $id_liecby = $_SESSION["id2"];
    }

}
else{
    header("location:liecba.php");
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

    <h3>Podané lieky</h3>
    <h4><small> Podané lieky v rámci liečby</small></h4>
    <?php

    include 'database/connect.php';
    $sql = "SELECT * FROM Podany_liek WHERE ID_Liecby = ?";
    $query = $db->prepare($sql);
    $query->execute(array($id_liecby));

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
                            <th>Liek</th>
                            <th>Dátum podania</th>
                            <th>Miesto podania</th>
                            <th>Čas podania</th>

                </tr>
                        </thead>
                        <tbody>';

            }
            echo '<tr>';
            echo '<td>';
            $sql2 = "SELECT * FROM Liek WHERE ID_Lieku = ? ";
            $query2 = $db->prepare($sql2);
            $query2->execute(array($r->ID_Lieku));

            $count2 = $query2->rowCount();
            if($count2>0){
                $r2 = $query2->fetch(PDO::FETCH_OBJ);
                echo $r2->Nazov;
            }

            echo '</td>';
            echo '<td>' .$r->Datum_podania;echo '</td>';
            echo '<td>' .$r->Miesto_podania;echo '</td>';
            echo '<td>' .$r->Cas_podania;echo '</td>';



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
                <strong>0 výsledkov!</strong> Neexistujú podané lieky pre túto liečbu!
            </div>
            </div>';
    }
    ?>


    <br>
    <a class="btn btn-primary" href="add_podavat_liek.php" role="button"> + Podať liek </a>
    <br>



</div>

</body>
</html>
