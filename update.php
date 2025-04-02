<?php 
    include("conexion.php");
    $con = conexion();

    $name = $_GET['name']; // Recibe el Name desde la URL

    $sql = "SELECT * FROM biostats WHERE Name = '$name'";
    $query = mysqli_query($con, $sql);

    $row = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
        <title>Editar Registro</title>
    </head>
    <body>
        <div class="users-form">
            <form action="edit_user.php" method="POST">
                <!-- Campo oculto para saber cuál Name se va a actualizar -->
                <input type="hidden" name="original_name" value="<?= $row['Name'] ?>">

                <input type="text" name="name" placeholder="Nombre" value="<?= $row['Name'] ?>" required>
                <input type="text" name="sex" placeholder="Sexo" value="<?= $row['Sex'] ?>" required>
                <input type="number" name="age" placeholder="Edad" value="<?= $row['Age'] ?>" required>
                <input type="number" name="height" placeholder="Altura (in)" value="<?= $row['Height (in)'] ?>" required>
                <input type="number" name="weight" placeholder="Peso (lbs)" value="<?= $row['Weight (lbs)'] ?>" required>

                <input type="submit" value="Actualizar">
            </form>
        </div>
    </body>
</html>
