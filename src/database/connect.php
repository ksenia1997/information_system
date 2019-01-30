<?php

try {
$db = new PDO("mysql:host=localhost;dbname=xbarte14;port=/var/run/mysql/mysql.sock", 'xbarte14', 'm2emfibu');
} catch (PDOException $e) {
echo "Connection error: ".$e->getMessage();
die();
}

?>