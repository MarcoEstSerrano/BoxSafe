<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "Admin$1234";
$db   = "gestion_casilleros";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

function check_auth() {
    if (!isset($_SESSION['admin_id'])) {
        header("Location: login.php");
        exit();
    }
}
?>