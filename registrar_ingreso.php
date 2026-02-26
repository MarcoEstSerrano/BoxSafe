<?php
require 'config.php';
check_auth();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre_cliente']);
    $objeto = mysqli_real_escape_string($conn, $_POST['objeto']);
    $casillero_id = (int)$_POST['casillero_id'];
    $admin_id = $_SESSION['admin_id'];

    mysqli_begin_transaction($conn);
    
    $sql_p = "INSERT INTO paquetes (nombre_cliente, objeto, casillero_id, fecha_ingreso, admin_ingreso_id) 
              VALUES ('$nombre', '$objeto', $casillero_id, NOW(), $admin_id)";
    
    $sql_c = "UPDATE casilleros SET estado = 'ocupado' WHERE id = $casillero_id";

    if (mysqli_query($conn, $sql_p) && mysqli_query($conn, $sql_c)) {
        mysqli_commit($conn);
        header("Location: dashboard.php");
    } else {
        mysqli_rollback($conn);
    }
}

$libres = mysqli_query($conn, "SELECT id, numero_casillero FROM casilleros WHERE estado = 'libre'");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Ingreso</title>
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
        <div class="form-container">
            <h2>Ingreso de Paquete</h2>
            <form method="POST">
                <div class="form-group">
                    <label>Nombre del Cliente</label>
                    <input type="text" name="nombre_cliente" required>
                </div>
                <div class="form-group">
                    <label>Objeto</label>
                    <input type="text" name="objeto" required>
                </div>
                <div class="form-group">
                    <label>Casillero Disponible</label>
                    <select name="casillero_id" required>
                        <option value="">Seleccione...</option>
                        <?php while($c = mysqli_fetch_assoc($libres)): ?>
                            <option value="<?php echo $c['id']; ?>">Casillero #<?php echo $c['numero_casillero']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-green" style="width:100%">Guardar Ingreso</button>
            </form>
        </div>
    </div>
</body>
</html>