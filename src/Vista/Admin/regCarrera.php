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
                $nombre = $_POST['nombre'];
                $clave = $_POST['clave'];
                $exe = regcarrera($nombre,$clave);
                if($exe)
                {
                    echo "<script>alert('Carrera registrada exitosamente');</script>";
                    echo "<script>window.location.href = 'index.php';</script>"; 
                } 
                else
                {
                    echo "<script>alert('No se pudo completar el registro');</script>";
                    echo "<script>window.location.href = 'index.php';</script>"; 
                }

            }

            include 'includes/header.php';
?>
            <div class="carousel"></div>
            <div class = "contenedor">
                <form name = "frm" id = "frm" action = "regCarrera.php" method = 'POST' >
                    <label for="nombre">Nombre:</label>
                    <input class = "campo" type="text" name = "nombre" id = "nombre">
                    <p class = "alert alert-danger" id = "nom" name = "nom" style="display: none;">Ingresa un nombre valido!!!</p>

                    <label for="clave">Clave:</label>
                    <input class = "campo" type="text" name = "clave" id = "clave">
                    <p class = "alert alert-danger" id = "cla" name = "cla" style="display: none;">Ingresa una clave valida!!!</p>

                    <input class = "Boton_Registro" value = "Registrar" type="button" onclick="validacionCarrera();"></input>
                    
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