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

// pripojenie k databaze
include 'database/connect.php';
$login = '';
$password = '';
$newpsswd = '';
$role = '';
$changed = 0;
if (isset($_POST["added"])) {
  $login = $_POST["Login"];
  $role = $_POST["Role"];
  if(empty($login) || empty($_POST["Password"]) ||empty($_POST["NewPsswd"]) ){
      $message = '<label>Vyplň všetky údaje!</label>';
  }
  else {
    $hash1=hash('sha256', $_POST["Password"]);
    $hash2=hash('sha256', $_POST["NewPsswd"]);
    $sql = "SELECT * FROM users WHERE username = ?";
    $query = $db->prepare($sql);
    $query->execute(array($login));
    $count = $query->rowCount();
    $r = $query->fetch(PDO::FETCH_OBJ);
    if($count > 0){
        $message = '<label>Použivateľ s daným loginom už existuje!</label>';
    }
    else{
        if($hash1 != $hash2){
            $message = '<label>Heslá sa nezhodujú!</label>';
        }
        else{
          $query1 = $db->query('SELECT * FROM users');
          $max_id_users = 0;
          while($r = $query1->fetch()) {
            if($r['id'] > $max_id_users) {
              $max_id_users = $r['id'];
            }
          }
          $max_id_users += 1;
          $sql = "INSERT INTO users (id, username, password, role) VALUES (?, ?, ?, ?)";
          $query = $db->prepare($sql);
          $query->execute(array($max_id_users, $login, $hash1, $role));
          $login = '';
          $role = '';
          $changed = 1;
        }
    }
  }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pridať nového používateľa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
</head>
<body>
<?include 'menu.php';?>
<br />
<div class="container" style="width:500px;">
    <?php
    if(isset($message))
    {
        echo '<label class="text-danger">'.$message.'</label>';
    }
    if ($changed == 1) {
      echo '<div class="alert alert-success">';
      echo '<strong>Úspech!</strong> Pridanie bolo úspešné! </div>';
    }
    ?>
    <h3 align="">Pridať nového používateľa</h3><br />
    <form method="post">
        <label>Login*</label>
        <input type="text" name="Login" class="form-control" value = "<?php echo $login;?>" />
        <br />
        <label>Nové heslo*</label>
        <input type="password" name="Password" class="form-control" value = "<?php echo $password;?>"/>
        <br />
        <label>Znovu nové heslo*</label>
        <input type="password" name="NewPsswd" class="form-control" value = "<?php echo $newpsswd;?>"/>
        <br />
        <label>Role*</label>
        <select name = "Role" class="custom-select mb-3">
          <option value="admin">admin</option>
          <option value="sestra">sestra</option>
          <option value="veterinar">veterinar</option>
          <option value="<? echo $r->ID_Majitela; ?>">
        </select>
        <br />
        <input type="submit" name="added" class="btn btn-primary" value="Pridať" />
    </form>
    <br />
    <h6 align="">* - povinné údaje</h6><br />
</div>

</body>
</html>
