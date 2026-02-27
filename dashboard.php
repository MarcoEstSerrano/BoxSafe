<?php
require('conexion/conexion.php');
check_auth();

$res_total = mysqli_query($conn, "SELECT COUNT(*) as total FROM casilleros");
$total = mysqli_fetch_assoc($res_total)['total'];

$res_libres = mysqli_query($conn, "SELECT COUNT(*) as total FROM casilleros WHERE estado = 'libre'");
$libres = mysqli_fetch_assoc($res_libres)['total'];

$res_ocupados = mysqli_query($conn, "SELECT COUNT(*) as total FROM casilleros WHERE estado = 'ocupado'");
$ocupados = mysqli_fetch_assoc($res_ocupados)['total'];

$res_paquetes = mysqli_query($conn, "SELECT COUNT(*) as total FROM paquetes WHERE fecha_salida IS NULL");
$paquetes_activos = mysqli_fetch_assoc($res_paquetes)['total'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Sistema Casilleros</title>
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
        <h2>Panel Principal</h2>
        <div class="card-grid">
            <div class="card"><h3>Total Casilleros</h3><p><?php echo $total; ?></p></div>
            <div class="card"><h3>Libres</h3><p><?php echo $libres; ?></p></div>
            <div class="card"><h3>Ocupados</h3><p><?php echo $ocupados; ?></p></div>
            <div class="card"><h3>Paquetes Activos</h3><p><?php echo $paquetes_activos; ?></p></div>
        </div>
        
        <h3>Paquetes en curso</h3>
        <table>
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Objeto</th>
                    <th>Casillero</th>
                    <th>Ingreso</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT p.*, c.numero_casillero FROM paquetes p 
                        JOIN casilleros c ON p.casillero_id = c.id 
                        WHERE p.fecha_salida IS NULL ORDER BY p.fecha_ingreso DESC";
                $res = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($res)):
                ?>
                <tr>
                    <td><?php echo $row['nombre_cliente']; ?></td>
                    <td><?php echo $row['objeto']; ?></td>
                    <td>#<?php echo $row['numero_casillero']; ?></td>
                    <td><?php echo $row['fecha_ingreso']; ?></td>
                    <td><a href="registrar_salida.php?id=<?php echo $row['id']; ?>" class="btn btn-red">Dar Salida</a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>