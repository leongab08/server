<?php
include("conexion.php");
$con = conexion();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$empleado = null;        // datos del empleado
$ventas   = [];          // ventas asociadas
$mensaje  = "";          // mensaje de error

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id     = trim($_POST["id"]     ?? "");
    $nombre = trim($_POST["nombre"] ?? "");

    /* ───────── 1. BUSCAR EMPLEADO ───────── */
    if ($id !== "") {
        $sql   = "SELECT * FROM empleados WHERE Id_Empleado = ?";
        $param = $id;
    } elseif ($nombre !== "") {
        $sql   = "SELECT * FROM empleados WHERE `Nombre y Apellido` LIKE ?";
        $param = "%{$nombre}%";
    }

    if (isset($sql)) {
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param);
        mysqli_stmt_execute($stmt);
        $res  = mysqli_stmt_get_result($stmt);

        if ($res && $empleado = mysqli_fetch_assoc($res)) {

            /* ───────── 2. BUSCAR VENTAS POR ID DEL EMPLEADO ───────── */
            $idEmpleado = $empleado['Id_Empleado'];   // clave primaria en empleados

            /*  Ajusta la columna 'Empleado' si en tu tabla ventas tiene otro nombre */
            $sqlV  = "SELECT * FROM ventas WHERE Empleado = ?";
            $stmtV = mysqli_prepare($con, $sqlV);
            mysqli_stmt_bind_param($stmtV, "s", $idEmpleado);
            mysqli_stmt_execute($stmtV);
            $ventas = mysqli_fetch_all(mysqli_stmt_get_result($stmtV), MYSQLI_ASSOC);

        } else {
            $mensaje = "No se encontró ningún empleado.";
        }
    } else {
        $mensaje = "Ingresa ID o nombre para buscar.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Búsqueda de empleados y ventas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function limpiarFormulario() {
            document.getElementById('frmBusqueda').reset();
            document.getElementById('resultados').innerHTML = "";
        }
    </script>
</head>
<body class="bg-gray-100 p-6 min-h-screen flex items-start justify-center">
<div class="w-full max-w-5xl bg-white p-6 rounded shadow">

    <!-- Formulario -->
    <h1 class="text-2xl font-bold text-center mb-6">Buscar empleado</h1>
    <form method="POST" id="frmBusqueda" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1">ID de empleado</label>
            <input type="text" name="id" class="w-full border rounded p-2" placeholder="Ej.: 24">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Nombre</label>
            <input type="text" name="nombre" class="w-full border rounded p-2" placeholder="Ej.: pinto john">
        </div>
        <div class="col-span-full flex gap-2 justify-center mt-2">
            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                Buscar
            </button>
            <button type="button" onclick="limpiarFormulario()"
                    class="bg-gray-300 px-5 py-2 rounded hover:bg-gray-400">
                Limpiar
            </button>
        </div>
    </form>

    <!-- Resultados -->
    <div id="resultados" class="mt-8 space-y-8">
        <?php if ($empleado): ?>

        
            <!-- Datos del empleado -->
            <h2 class="text-xl font-semibold">Datos del empleado</h2>
            <table class="w-full table-auto border">
                <thead class="bg-gray-200">
                    <tr>
                        <?php foreach ($empleado as $col => $valor): ?>
                            <th class="px-2 py-1 border text-left"><?= htmlspecialchars($col) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php foreach ($empleado as $valor): ?>
                            <td class="px-2 py-1 border"><?= htmlspecialchars($valor) ?></td>
                        <?php endforeach; ?>
                    </tr>
                </tbody>
            </table>

            <!-- Ventas asociadas -->
            <h2 class="text-xl font-semibold mt-6">Ventas asociadas</h2>
            <?php if ($ventas): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-max table-auto border">
                        <thead class="bg-gray-200">
                            <tr>
                                <?php foreach (array_keys($ventas[0]) as $col): ?>
                                    <th class="px-2 py-1 border text-left"><?= htmlspecialchars($col) ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ventas as $fila): ?>
                                <tr class="hover:bg-gray-50">
                                    <?php foreach ($fila as $dato): ?>
                                        <td class="px-2 py-1 border"><?= htmlspecialchars($dato) ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-gray-600">Este empleado no tiene ventas registradas.</p>
            <?php endif; ?>

        <?php elseif ($mensaje): ?>
            <p class="text-red-600"><?= $mensaje ?></p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
