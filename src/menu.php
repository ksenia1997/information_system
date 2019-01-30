<? header("Content-Type: text/html; charset=UTF-8");?>
<?php

if(!isset($_SESSION["username"])) {
    header("location:index.php");
}

?>

<nav class="navbar navbar-expand-sm bg-primary navbar-dark fixed-top">
    <a class="navbar-brand" href="home.php">Veterinárna klinika</a>
    <ul class="navbar-nav">
        <?php
            if(isset($_SESSION["role"])) {
               if($_SESSION["role"] == "admin"){
                   echo '<li class="nav-item ">';
                   echo ' <a class="nav-link" href="administrate.php">Administrácia</a>';
                   echo '</li>';
               }

                if(($_SESSION["role"] == "admin" )||($_SESSION["role"] == "doktor" )){
                    echo '<li class="nav-item ">';
                    echo ' <a class="nav-link" href="doctor.php">Doktori</a>';
                    echo '</li>';

                    echo '<li class="nav-item ">';
                    echo '  <a class="nav-link" href="sestra.php">Sestry</a>';
                    echo '</li>';
                }
            }
        ?>
        <li class="nav-item">
            <a class="nav-link" href="zvierata.php">Zvieratá</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="majitelia.php">Majitelia</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="lieky.php">Databáza liekov</a>
        </li>

        <li class="nav-item">
            <a href="logout.php" class="btn btn btn-outline-light">
                <span class="glyphicon glyphicon-log-out"></span> Odhlásiť
            </a>        </li>

        </li>

    </ul>


</nav>
<br>
<br>
<br>

