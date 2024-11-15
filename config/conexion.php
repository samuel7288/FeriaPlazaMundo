
<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "tiquetera2";

$conexion = mysqli_connect($host, $user, $password, $database);

if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>