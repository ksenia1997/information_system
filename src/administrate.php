<? header("Content-Type: text/html; charset=UTF-8");?>
<?php
session_start();
if(isset($_SESSION["username"])) {
    if(isset($_SESSION["role"])) {
        if(!$_SESSION["role"] == "admin"){
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
    <title>Doktori </title>
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

    <h3>Administrácia systému</h3>
    <h4><small>Vyhľadávanie používateľa</small></h4>
    <br>
    <form method = "get"">
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="meno" placeholder="Používateľské meno">
            <div class="input-group-append">
                <button class="btn btn-primary" name="hladat" type="submit">Hľadať</button>
            </div>
            <div class="input-group-append">
                <a href="administrate.php?meno=&hladat=" class="btn btn-primary" role="button" >Zobraziť všetkých</a>
            </div>
        </div>
    </form>
    <br>
    <?php
    if(isset($_GET["hladat"])) {
        include 'database/connect.php';
        $meno = strtolower($_GET["meno"]);
        $sql = "SELECT * FROM users ";
        $query = $db->prepare($sql);
        $query->execute();

        $count = $query->rowCount();
        if($count > 0){
            $prvy_prechod = 1;
            while($r = $query->fetch(PDO::FETCH_OBJ)) {
                $hladane = strtolower(substr($r->username,0,strlen($meno)));

                if(strcmp($hladane,$meno)==0 ){

                    if($prvy_prechod){
                        $prvy_prechod = 0;
                        echo '<form method="post" action="edit_administrate.php">
                        <br><br><br> <div class="container">
                              <h3>Výsledky vyhľadávania</h3>
                              <table class="table">
                                <thead>
                                  <tr>
                                    <th>Login</th>
                                    <th>Rola</th>
                                    <th></th>
                                  </tr>
                                </thead>
                                <tbody>';

                    }
                    echo '<tr>';
                    echo '<td>' .$r->username ;echo '</td>';
                    echo '<td>' .$r->role;echo '</td>';
                    echo '<td><button type="submit"class="btn btn-outline-danger" Name = "delete" Value='.$r->id;echo ' >Odstrániť</button>';echo '</td>';
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
                    <strong>0 výsledkov!</strong> Zadané používateľské meno neexistuje!
                </div>
                </div>';
            }
        }

    }
    ?>
    <br>
    <a class="btn btn-primary" href="add_administrate.php" role="button"> + Pridať nového používateľa </a>
    <br>
</div>

</body>
</html>