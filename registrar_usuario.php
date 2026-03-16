<?php
require('conexion/conexion.php');
// check_auth(); // Mantén esto comentado hasta que logres crear tu primer usuario y loguearte

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nuevo_usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    $password_plana = $_POST['password'];
    
    // Validar si el usuario ya existe
    $check_user = mysqli_query($conn, "SELECT id FROM administradores WHERE usuario = '$nuevo_usuario'");
    
    if (mysqli_num_rows($check_user) > 0) {
        $mensaje = "<p style='color:red; font-weight:bold; text-align:center;'>Error: El usuario '$nuevo_usuario' ya existe.</p>";
    } else {
        $password_hash = password_hash($password_plana, PASSWORD_DEFAULT);
        $sql = "INSERT INTO administradores (usuario, password) VALUES ('$nuevo_usuario', '$password_hash')";
        
        if (mysqli_query($conn, $sql)) {
            $mensaje = "<p style='color:green; font-weight:bold; text-align:center;'>Usuario creado exitosamente. Ya puedes ir al Login.</p>";
        } else {
            $mensaje = "<p style='color:red; text-align:center;'>Error al registrar: " . mysqli_error($conn) . "</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Administrador - BoxSafe</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page"> <header><h1>Registro</h1></header>
    <nav>
        <a href="login.php">Volver al Login</a>
    </nav>

    <div style="display: flex; justify-content: center; align-items: center; min-height: calc(100vh - 160px); padding: 20px;">
        
        <div class="form-container" style="width: 100%; max-width: 400px; margin: 0;">
            <h2 style="text-align:center; color: var(--cafe-oscuro); margin-bottom: 1.5rem;">Nuevo Administrador</h2>
            
            <?php echo $mensaje; ?>

            <form method="POST">
                <div class="form-group">
                    <label>Nombre de Usuario</label>
                    <input type="text" name="usuario" placeholder="Ej: admin_central" required>
                </div>
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" placeholder="Mínimo 8 caracteres" required>
                </div>
                <button type="submit" class="btn btn-blue" style="width: 100%; margin-top: 10px;">Registrar y Encriptar</button>
            </form>
           
        </div>
    </div>
</body>
</html>