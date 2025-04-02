<?php
include("conexion.php");
$con = conexion();

// Consultar todos los registros de la tabla biostats
$sql = "SELECT * FROM biostats";
$query = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/server/styles.css" rel="stylesheet">
    <title>CRUD Biostats</title>
</head>

<body>
    <div class="users-form">
        <h1>Agregar registro</h1>
        <form action="insert_user.php" method="POST">
            <input type="text" name="name" placeholder="Nombre" required>
            <input type="text" name="sex" placeholder="Sexo" required>
            <input type="number" name="age" placeholder="Edad" required>
            <input type="number" name="height" placeholder="Altura (in)" required>
            <input type="number" name="weight" placeholder="Peso (lbs)" required>

            <input type="submit" value="Agregar">
        </form>
    </div>

    <div class="users-table">
        <h2>Registros Biostats</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Sexo</th>
                    <th>Edad</th>
                    <th>Altura (in)</th>
                    <th>Peso (lbs)</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_array($query)): ?>
                    <tr>
                        <td><?= $row['Name'] ?></td>
                        <td><?= $row['Sex'] ?></td>
                        <td><?= $row['Age'] ?></td>
                        <td><?= $row['Height (in)'] ?></td>
                        <td><?= $row['Weight (lbs)'] ?></td>
                        <td><a href="update.php?name=<?= urlencode($row['Name']) ?>" class="users-table--edit">Editar</a></td>
                        <td><a href="delete_user.php?name=<?= urlencode($row['Name']) ?>" class="users-table--delete">Eliminar</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="script.js"></script>
</body>

</html>
