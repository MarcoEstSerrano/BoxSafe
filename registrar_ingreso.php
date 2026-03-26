<?php
require('conexion/conexion.php');
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
        exit();
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
    <title>Register Login - BoxSafe</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Ajuste extra para centrar el formulario específicamente en esta página */
        .main-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 70vh; /* Ajusta la altura para que no pegue al nav */
        }
    </style>
</head>
<body class="dashboard-page">
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
        <div class="main-wrapper">
            <div class="form-container" style="width: 100%; max-width: 450px;">
                <h2 style="text-align: center; color: var(--cafe-oscuro); margin-bottom: 20px;"> New Entry</h2>
                <form method="POST">
                    <div class="form-group">
                        <label>Client Name</label>
                        <input type="text" name="nombre_cliente" placeholder="Ex. Juan Pérez" required>
                    </div>
                    <div class="form-group">
                        <label>Object/Product</label>
                        <input type="text" name="objeto" placeholder="Ex. shopping bag" required>
                    </div>
                    <div class="form-group">
                        <label>Assign Locker</label>
                        <select name="casillero_id" required>
                            <option value="">Select an available space...</option>
                            <?php while($c = mysqli_fetch_assoc($libres)): ?>
                                <option value="<?php echo $c['id']; ?>">Locker #<?php echo $c['numero_casillero']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-green" style="width:100%; margin-top: 10px;">Confirm and Save</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>