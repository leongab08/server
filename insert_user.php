<?php
include("conexion.php");
$con = conexion();

// Recibiendo datos del formulario
$name = $_POST['name'];
$sex = $_POST['sex'];
$age = $_POST['age'];
$height = $_POST['height'];
$weight = $_POST['weight'];

// Protegiendo datos contra inyección SQL
$name = mysqli_real_escape_string($con, $name);
$sex = mysqli_real_escape_string($con, $sex);
$age = (int)$age;
$height = (int)$height;
$weight = (int)$weight;

// Consulta INSERT correcta
$sql = "INSERT INTO biostats (Name, Sex, Age, `Height (in)`, `Weight (lbs)`) 
        VALUES ('$name', '$sex', $age, $height, $weight)";

$query = mysqli_query($con, $sql);

// Redirección o error
if ($query) {
    Header("Location: index.php");
} else {
    echo "Error al insertar: " . mysqli_error($con);
}
?>

