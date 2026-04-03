<?php
$mysqli = new mysqli('localhost', 'root', '', 'proyecto_ventas');
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$res = $mysqli->query('DESCRIBE cliente');
if($res){
    while($row = $res->fetch_assoc()){
        print_r($row);
    }
} else {
    echo "NO CLIENTE TABLE FOUND";
}
$mysqli->close();
?>
