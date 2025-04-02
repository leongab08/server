<?php
include("conexion.php");
$con = conexion();

// Recibiendo datos del formulario
$name = $_POST['name'];
$sex = $_POST['sex'];
$age = $_POST['age'];
$height = $_POST['height'];
$weight = $_POST['weight'];

// Protección contra inyección SQL
$name = mysqli_real_escape_string($con, $name);
$sex = mysqli_real_escape_string($con, $sex);
$age = (int)$age;
$height = (int)$height;
$weight = (int)$weight;

// Consulta UPDATE usando Name como referencia
$sql = "UPDATE biostats 
        SET Sex = '$sex', Age = $age, `Height (in)` = $height, `Weight (lbs)` = $weight 
        WHERE Name = '$name'";

$query = mysqli_query($con, $sql);

// Verificar si la consulta fue exitosa
if ($query) {
    Header("Location: index.php");
} else {
    echo "Error al actualizar: " . mysqli_error($con);
}
?>
