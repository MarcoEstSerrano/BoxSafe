<?php
require('conexion/conexion.php');
check_auth();

$sql = "SELECT p.*, c.numero_casillero, a1.usuario as admin_in, a2.usuario as admin_out 
        FROM paquetes p 
        JOIN casilleros c ON p.casillero_id = c.id 
        JOIN administradores a1 ON p.admin_ingreso_id = a1.id 
        LEFT JOIN administradores a2 ON p.admin_salida_id = a2.id 
        ORDER BY p.fecha_ingreso DESC";
$res = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial Completo</title>
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
        <h2>Historial de Paquetes</h2>
        <table style="font-size: 0.85rem;">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Objeto</th>
                    <th>Casillero</th>
                    <th>Ingreso</th>
                    <th>Salida</th>
                    <th>Admin In</th>
                    <th>Admin Out</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($res)): ?>
                <tr>
                    <td><?php echo $row['nombre_cliente']; ?></td>
                    <td><?php echo $row['objeto']; ?></td>
                    <td>#<?php echo $row['numero_casillero']; ?></td>
                    <td><?php echo $row['fecha_ingreso']; ?></td>
                    <td><?php echo $row['fecha_salida'] ?? '---'; ?></td>
                    <td><?php echo $row['admin_in']; ?></td>
                    <td><?php echo $row['admin_out'] ?? '---'; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>