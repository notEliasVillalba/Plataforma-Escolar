
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
                $apepat = $_POST['apepat'];
                $apemat = $_POST['apemat'];
                if($apemat == NULL)
                {
                    $apemat = '';
                }
                $genero = $_POST['genero'];
                $fechanac = $_POST['fecnac'];
                $idCarrera = $_POST['vocacion'];
                $exe = regprofesor($nombre,$apepat,$apemat,$genero,$fechanac,$idCarrera);
                if($exe)
                {
                    echo "<script>alert('Profesor registrado exitosamente');</script>";
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
                <form name ="frm" id="frm"  action="GestionProfesor.php"  method = 'POST'>

                    <label for="nombre">Nombre:</label>
                    <input class = "campo" type="text" name = "nombre" id = "nombre">
                    <p class = "alert alert-danger" id = "nom" name = "nom" style="display: none;">Ingresa un nombre valido!!!</p>

                    <label for="apepat">Apellido Paterno:</label>
                    <input class = "campo" type="text" name = "apepat" id ="apepat">
                    <p class = "alert alert-danger" id = "app" name = "app" style="display: none;">Ingresa un apellido paterno valido!!!</p>


                    <label for="apemat">Apellido Materno:</label>
                    <input class = "campo" type="text" name = "apemat" id = "apemat">
                    <p class = "alert alert-danger" id = "apm" name = "apm" style="display: none;">Ingresa un apellido materno valido, en caso de no tener uno dejar la casilla vacia!!!!</p>

                    <label for="fecnac">Fecha de Nacimiento:</label>
                    <input class ="campo" type="date" name = "fecnac" id = "fecnac" >
                    <p class = "alert alert-danger" id ="fc" name = "fc" style = "display:none;">El profesor debe ser mayor de edad</p>

                    <label for="genero">Genero:</label>
                    <select class = "campo" name="genero" id="genero" >
                        <option value="0">Selecciona un Genero...</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                    </select>
                    <p class = "alert alert-danger" id = "gen" name = "gen" style="display: none;">Ingresa un genero!!!</p>

                    <label for="vocacion">Vocacion:</label>
                    <input class = "campo" type="text" name="vocacion" id="vocacion">
                    <p class = "alert alert-danger" id = "v" name = "v" style="display: none;">Ingresa una vocacion valida!!!</p>

                    <input class = "Boton_Registro" value = "Registrar" type="button" onclick="validacionProfesor();"></input>
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
