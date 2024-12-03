<?php
    require_once __DIR__ . '/../Controlador/control.php';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $user = $_POST['email'];
        $pass = $_POST['contra'];
        
        $verificacion = iniciosesion($user,$pass);
        if($verificacion == 0 )
        {
?>
            <script>
                alert('Usuario y/o contraseña incorrectos');
                window.location.href = 'login.php';
            </script>
<?php
        }
    }

?>
    <?php include 'includes/header.php'; ?>
    <div class="carousel"></div>

    <div class="login-container">
        <div class="login-box">
            <h2>Iniciar Sesión</h2>
            <form action="login.php" method="POST">
                
                <label for="email">Usuario:</label>
                <input type="email" id="email" name="email" placeholder="Ingrese su correo" required>
                
                <label for="contra">Contraseña:</label>
                <input type="password" id="contra" name="contra"  placeholder="Ingrese su contraseña" required>
                
                <button type="submit">Iniciar Sesión</button>
            </form>
        </div>
    </div>

<?php include 'includes/footer.php'; ?>

