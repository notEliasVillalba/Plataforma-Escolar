<?php
require '../../Controlador/control.php';
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user'])) 
{
    $id = $_SESSION['id'];
    $user = $_SESSION['user'];

    if (verificaradmin($id, $user)) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            $nombre = $_POST['nombre'];
            $apepat = $_POST['apepat'];
            $apemat = $_POST['apemat'] ?: '';
            $genero = $_POST['genero'];
            $fechanac = $_POST['fecnac'];
            $carrera = $_POST['idCarrera'];

            $exe = regEstudiante($nombre, $apepat, $apemat, $genero, $fechanac, $carrera);
            if ($exe) 
            {
                echo "<script>alert('Usuario registrado exitosamente');</script>";
                echo "<script>window.location.href = 'index.php';</script>";
            } 
            else 
            {
                echo "<script>alert('No se pudo completar el registro');</script>";
                echo "<script>window.location.href = 'index.php';</script>";
            }
        }

        $carreras = obtenercarreras();
        include 'includes/header.php';
?>
        <div class="carousel"></div>
        <div class="contenedor">
<?php
        if (mysqli_num_rows($carreras) > 0)
        {
?>
            <form name="frm" id="frm" action="GestionEstudiantes.php" method="POST">
                <label for="nombre">Nombre:</label>
                <input class="campo" type="text" name="nombre" id="nombre">
                <p class="alert alert-danger" id="nom" style="display: none;">Ingresa un nombre válido.</p>

                <label for="apepat">Apellido Paterno:</label>
                <input class="campo" type="text" name="apepat" id="apepat">
                <p class="alert alert-danger" id="app" style="display: none;">Ingresa un apellido paterno válido.</p>

                <label for="apemat">Apellido Materno:</label>
                <input class="campo" type="text" name="apemat" id="apemat">
                <p class="alert alert-danger" id="apm" style="display: none;">Ingresa un apellido materno válido, o deja vacío si no aplica.</p>

                <label for="genero">Género:</label>
                <select class="campo" name="genero" id="genero">
                    <option value="0">Selecciona un Género...</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
                <p class="alert alert-danger" id="gen" style="display: none;">Selecciona un género.</p>

                <label for="fecnac">Fecha de Nacimiento:</label>
                <input class="campo" type="date" name="fecnac" id="fecnac">
                <p class="alert alert-danger" id="fc" style="display: none;">Ingresa una fecha válida.</p>

                <label for="idcarrera">Carrera:</label>
                <select class="campo" name="idCarrera" id="idCarrera">
                    <option value="0">Selecciona una Carrera...</option>
<?php
                    while ($rows = mysqli_fetch_array($carreras)) 
                    {
?>
                        <option value="<?php echo $rows['idCarrera']; ?>"><?php echo $rows['nombre']; ?></option>
<?php
                    }
?>
                </select>
                <p class="alert alert-danger" id="c" style="display: none;">Selecciona una carrera.</p>
                <input class="Boton_Registro" value="Registrar" type="button" onclick="validacionEstudiantes();">
            </form>
<?php
        } 
        else 
        {
?>
            <div class="contenedor">
                <h3>No hay carreras registradas.</h3>
                <p>Para registrar un estudiante, primero debe registrar una carrera.</p>
                <a href="regCarrera.php" class="boton">Registrar Carrera</a>
            </div>
<?php
        }
?>
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


