<?php
require 'config.php';
check_auth();

$res = mysqli_query($conn, "SELECT * FROM casilleros ORDER BY numero_casillero ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estado de Casilleros</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header><h1>Gestión de Casilleros</h1></header>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="registrar_ingreso.php">Ingreso</a>
        <a href="registrar_salida.php">Salida</a>
        <a href="casilleros.php">Casilleros</a>
        <a href="historial.php">Historial</a>
        <a href="logout.php">Cerrar Sesión</a>
    </nav>
    <div class="container">
        <h2>Estado de Casilleros</h2>
        <table>
            <thead>
                <tr>
                    <th># Casillero</th>
                    <th>Estado</th>
                    <th>Fecha Registro</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($res)): ?>
                <tr>
                    <td><strong><?php echo $row['numero_casillero']; ?></strong></td>
                    <td>
                        <span class="badge badge-<?php echo $row['estado']; ?>">
                            <?php echo strtoupper($row['estado']); ?>
                        </span>
                    </td>
                    <td><?php echo $row['creado_en']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>