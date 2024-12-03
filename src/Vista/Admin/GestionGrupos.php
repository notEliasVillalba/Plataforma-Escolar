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
                $salon = $_POST['salon'];
                $generacion = $_POST['generacion'];

                $exe = regGrupo($nombre,$salon,$generacion);
                if($exe)
                {
                    echo "<script>alert('Grupo registrado exitosamente');</script>";
                    echo "<script>window.location.href = 'VerGrupos.php';</script>"; 
                } 
                else
                {
                    echo "<script>alert('No se pudo completar el registro');</script>";
                    echo "<script>window.location.href = 'GestionGrupos.php';</script>"; 
                }
            }

            include 'includes/header.php';
?>
            <div class="carousel"></div>
            <div class = "contenedor">
                <form name ="frm" id="frm"  action="GestionGrupos.php" method = 'POST' >
                    <label for="nombre">Nombre del grupo:</label>
                    <input class = "campo" type="text" name = "nombre" id = "nombre">
                    <p class = "alert alert-danger" id = "nom" name = "nom" style="display: none;"> !Ingresa un nombre valido!</p>

                    <label for="salon">Salon:</label>
                    <input class = "campo" type="text" name = "salon" id ="salon">
                    <p class = "alert alert-danger" id = "sal" name = "sal" style="display: none;">!Ingresa un salon valido!</p>

                    <label for="generacion">Generacion:</label>
                    <input class = "campo" type="text" name = "generacion" id = "generacion">
                    <p class = "alert alert-danger" id = "gen" name = "gen" style="display: none;">!Ingresa una generacion valida!</p>

                    <input class = "Boton_Registro" value = "Registrar" type="button" onclick="validacionGrupo();"></input>
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
