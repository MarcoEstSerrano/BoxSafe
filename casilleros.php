<?php
require('conexion/conexion.php');
check_auth();

$res = mysqli_query($conn, "SELECT * FROM casilleros ORDER BY numero_casillero ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lockers Status</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header><h1>Locker Management</h1></header>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="registrar_ingreso.php">Access</a>
        <a href="registrar_salida.php">Exit</a>
        <a href="casilleros.php">Locker</a>
        <a href="historial.php">Historial</a>
        <a href="logout.php">Logout</a>
    </nav>
    <div class="container">
        <h2>Lockers Status</h2>
        <table>
            <thead>
                <tr>
                    <th># Locker</th>
                    <th>State</th>
                    <th>Registration Date</th>
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