<?php
    require '../../Controlador/control.php';
    session_start();
    if(isset($_SESSION['id']) && isset($_SESSION['user']))
    {
        $id = $_SESSION['id'];
        $user = $_SESSION['user'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $actual = $_POST['actual'];
            $nueva = $_POST['nueva'];

            if(verificarcontra($actual, $id))
            {
                if(cambiarcontra($nueva, $id))
                {
?>
                    <script>
                        alert('Contraseña modificada exitosamente');
                        window.location.href = 'index.php';
                    </script>
<?php
                }
                else
                {
?>
                    <script>
                        alert('Error al cambiar la contraseña');
                        window.location.href = 'cambiarContraseña.php';
                    </script>
<?php
                }
                
            }
            else
            {
?>
                <script>
                    alert('Contraseña Incorrecta ');
                    window.location.href = 'cambiarContraseña.php';
                </script>
<?php
            }
        }



        if(verificarestudiante($id, $user))
        {
            include 'includes/header.php';
?>
            <div class="carousel"></div>
                <div class="contenedor">
                    <form name = "frm" id = "frm" action="cambiarcontraseña.php" method = 'POST'>
                        <label for="actual" >Ingresa tu contraseña:</label>
                        <input class = "campo" type="password" name = "actual" id = "actual">
                        <p class = "alert alert-danger" id = "o" name = "o" style="display: none;">Ingresa tu contraseña!!!!!</p>

                        <label for="nueva">Ingresa tu nueva contraseña:</label>
                        <input class = "campo" name = "nueva" id = "nueva" type="password">
                        <p class = "alert alert-danger" id = "n" name = "n" style="display: none;">Ingresa una contraseña!!!!</p>

                        <label for="confirmacion">Confirma tu nueva contraseña:</label>
                        <input class = "campo" name = "confirmacion" id = "confirmacion" type="password">
                        <p class = "alert alert-danger" id = "con" name = "con" style="display: none;">Las contraseñas son diferentes!!!</p>

                        <input class = "Boton_Registro" value = "Registrar" type="button" onclick="validacionContra();"></input>
                    </form>
                </div>    
<?php
            


            include 'includes/footer.php';
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