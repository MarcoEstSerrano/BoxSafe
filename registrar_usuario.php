<?php
require 'config.php';
// check_auth(); // Mantén esto comentado hasta que logres crear tu primer usuario y loguearte

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nuevo_usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    $password_plana = $_POST['password'];
    
    // Validar si el usuario ya existe
    $check_user = mysqli_query($conn, "SELECT id FROM administradores WHERE usuario = '$nuevo_usuario'");
    
    if (mysqli_num_rows($check_user) > 0) {
        $mensaje = "<p style='color:red; font-weight:bold;'>Error: El nombre de usuario '$nuevo_usuario' ya está registrado.</p>";
    } else {
        $password_hash = password_hash($password_plana, PASSWORD_DEFAULT);
        $sql = "INSERT INTO administradores (usuario, password) VALUES ('$nuevo_usuario', '$password_hash')";
        
        if (mysqli_query($conn, $sql)) {
            $mensaje = "<p style='color:green; font-weight:bold;'>Usuario creado exitosamente. Ya puedes ir al Login.</p>";
        } else {
            $mensaje = "<p style='color:red;'>Error al registrar: " . mysqli_error($conn) . "</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Administrador</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header><h1>Gestión de Casilleros</h1></header>
    <nav>
        <a href="login.php">Volver al Login</a>
    </nav>
    <div class="container">
        <div class="form-container">
            <h2>Nuevo Administrador</h2>
            <?php echo $mensaje; ?>
            <form method="POST">
                <div class="form-group">
                    <label>Nombre de Usuario</label>
                    <input type="text" name="usuario" required>
                </div>
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-blue">Registrar y Encriptar</button>
            </form>
        </div>
    </div>
</body>
</html>