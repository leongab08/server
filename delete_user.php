<?php
include("conexion.php");
$con = conexion();

$name = $_GET["name"];

// Escapar caracteres especiales para evitar inyección
$name = mysqli_real_escape_string($con, $name);

// Eliminamos por nombre
$sql = "DELETE FROM biostats WHERE Name = '$name'";
$query = mysqli_query($con, $sql);

if ($query) {
    Header("Location: index.php");
} else {
    echo "Error al eliminar: " . mysqli_error($con);
}
?>
