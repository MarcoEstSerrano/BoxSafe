<?php
require 'config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    $password = $_POST['password'];

    $sql = "SELECT id, password FROM administradores WHERE usuario = '$usuario'";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['usuario'] = $usuario;
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "Usuario no encontrado";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Gestión de Casilleros</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">
    <div class="form-container">
        <h2 style="text-align:center; margin-bottom:1.5rem;">Iniciar Sesión</h2>
        
        <?php if($error): ?>
            <p style="color:red; text-align:center;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Usuario</label>
                <input type="text" name="usuario" required>
            </div>
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-blue">Entrar</button>
        </form>

        <hr style="margin: 1.5rem 0; border: 0; border-top: 1px solid #eee;">

        <div style="text-align: center;">
            <p style="font-size: 0.9rem; color: #666; margin-bottom: 0.5rem;">¿No tienes cuenta?</p>
            <a href="registrar_usuario.php" class="btn btn-green" style="text-decoration: none; display: block;">Registrar Nuevo Usuario</a>
        </div>
    </div>
</body>
</html>