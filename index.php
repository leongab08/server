<?php
include("conexion.php");
$con = conexion();

$resultado = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = trim($_POST["id"]);
    $nombre = trim($_POST["nombre"]);

    if (!empty($id)) {
        $sql = "SELECT * FROM empleados WHERE Id_Empleado = '$id'";
    } elseif (!empty($nombre)) {
        $sql = "SELECT * FROM empleados WHERE `Nombre y Apellido` LIKE '%$nombre%'";
    }

    if (isset($sql)) {
        $query = mysqli_query($con, $sql);
        $resultado = mysqli_fetch_all($query, MYSQLI_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Empleados</title>
    <script>
        function limpiarFormulario() {
            document.getElementById('busqueda').reset();
            document.getElementById('resultados').innerHTML = "";
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4 text-center">Buscar Empleado</h1>

        <form method="POST" id="busqueda" class="space-y-4">
            <div>
                <label class="block text-sm font-medium">ID:</label>
                <input type="text" name="id" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block text-sm font-medium">Nombre:</label>
                <input type="text" name="nombre" class="w-full border rounded p-2">
            </div>

            <div class="flex justify-between">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Buscar</button>
                <button type="button" onclick="limpiarFormulario()" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Limpiar</button>
            </div>
        </form>

        <div id="resultados" class="mt-6">
            <?php if ($resultado): ?>
                <table class="w-full table-auto border mt-4">
                    <thead class="bg-gray-200">
                        <tr>
                            <?php foreach (array_keys($resultado[0]) as $col): ?>
                                <th class="px-2 py-1 border"><?php echo htmlspecialchars($col); ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultado as $fila): ?>
                            <tr>
                                <?php foreach ($fila as $dato): ?>
                                    <td class="px-2 py-1 border"><?php echo htmlspecialchars($dato); ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php elseif ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
                <p class="text-red-600 mt-4">No se encontraron resultados.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
