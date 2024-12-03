<?php
    require '../../Controlador/control.php';
    session_start();
    if(isset($_SESSION['id']) && isset($_SESSION['user']))
    {
        $id = $_SESSION['id'];
        $user = $_SESSION['user'];
        if(verificaradmin($id, $user))
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                if(isset($_POST['nombre']))
                {
                    $nombre = $_POST['nombre'];
                    $correo = $_POST['correo'];
                    $contrasena = $_POST['contrasena'];

                    $exe = regAdmin($nombre,$correo,$contrasena);
                    if($exe)
                    {
                        echo "<script>alert('Administrador registrado exitosamente');</script>";
                        echo "<script>window.location.href = 'index.php';</script>"; 
                    } 
                    else
                    {
                        echo "<script>alert('No se pudo completar el registro');</script>";
                        echo "<script>window.location.href = 'index.php';</script>"; 
                    }
                }
            }

            include 'includes/header.php';
?>
            <div class="carousel"></div>
            <div class = "contenedor">
                <form name ="frm" id="frm"  action="GestionAdministradores.php" method = 'POST' >
                    <label for="nombre">Nombre:</label>
                    <input class = "campo" type="text" name = "nombre" id = "nombre" required>
                    <p class = "alert alert-danger" id = "nom" name = "nom" style="display: none;">Ingresa un nombre valido!!!</p>

                    <label for="correo">Correo:</label>
                    <input class = "campo" type="text" name = "correo" id ="correo" required>
                    <p class = "alert alert-danger" id = "corr" name = "corr" style="display: none;">Ingresa un correo valido!!!</p>

                    <label for="contrasena">Contraseña:</label>
                    <input class = "campo" type="password" name = "contrasena" id = "contrasena" required>
                    <p class = "alert alert-danger" id = "contr" name = "contr" style="display: none;">Ingresa un contrasena valida!!!!</p>

                    <button class = "Boton_Registro">Registrar</button>
                </form>
            </div>
            
            <?php include 'includes/footer.php'; ?>
<?php            
        }
        else
        {
            header("Location: ../../Controlador/logout.php");
        }   
    }
    else
    {
        mostrarlogin();
    }
?>