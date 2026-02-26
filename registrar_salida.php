<?php
require 'config.php';
check_auth();

if (isset($_GET['id'])) {
    $id_paquete = (int)$_GET['id'];
    $admin_id = $_SESSION['admin_id'];

    $sql_get = "SELECT casillero_id FROM paquetes WHERE id = $id_paquete";
    $res = mysqli_query($conn, $sql_get);
    $paquete = mysqli_fetch_assoc($res);

    if ($paquete) {
        $casillero_id = $paquete['casillero_id'];
        mysqli_begin_transaction($conn);

        $sql_p = "UPDATE paquetes SET fecha_salida = NOW(), admin_salida_id = $admin_id WHERE id = $id_paquete";
        $sql_c = "UPDATE casilleros SET estado = 'libre' WHERE id = $casillero_id";

        if (mysqli_query($conn, $sql_p) && mysqli_query($conn, $sql_c)) {
            mysqli_commit($conn);
        } else {
            mysqli_rollback($conn);
        }
    }
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Salida</title>
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
        <h2>Pendientes de Salida</h2>
        <table>
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Objeto</th>
                    <th>Casillero</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT p.*, c.numero_casillero FROM paquetes p 
                        JOIN casilleros c ON p.casillero_id = c.id 
                        WHERE p.fecha_salida IS NULL";
                $res = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($res)):
                ?>
                <tr>
                    <td><?php echo $row['nombre_cliente']; ?></td>
                    <td><?php echo $row['objeto']; ?></td>
                    <td>#<?php echo $row['numero_casillero']; ?></td>
                    <td>
                        <a href="registrar_salida.php?id=<?php echo $row['id']; ?>" class="btn btn-red" onclick="return confirm('¿Confirmar salida?')">Registrar Salida</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>