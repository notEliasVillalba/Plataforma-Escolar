<?php
require '../../Controlador/control.php';
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user'])) {
    $id = $_SESSION['id'];
    $user = $_SESSION['user'];

    if (verificaradmin($id, $user)) {
        if (isset($_GET['ide'])) {
            $idEstudiante = $_GET['ide'];
            $estudiante = obtainEstudiantePorId($idEstudiante);

            if ($estudiante) 
            {
                $row = mysqli_fetch_assoc($estudiante);
                include 'includes/header.php';
?>
                <div class = "carousel"></div>
                <div class = " contenedor">
                    <form action="UpdateEstudiantes.php" method="POST">
                        <input class = "campo" type="hidden" name="idEstudiante" value="<?php echo $row['idEstudiante']; ?>">
                        <label>Nombre:</label>
                        <input class = "campo" type="text" name="nombre" value="<?php echo $row['nombre']; ?>">
                        <label>Apellido Paterno:</label>
                        <input class = "campo" type="text" name="apepat" value="<?php echo $row['apepat']; ?>">
                        <label>Apellido Materno:</label>
                        <input class = "campo" type="text" name="apemat" value="<?php echo $row['apemat']; ?>">
                        <label>Fecha de Nacimiento:</label>
                        <input class = "campo" type="date" name="fechanac" value="<?php echo $row['fechanac']; ?>">
                        <label>Género:</label>
                        <select class = "campo" name="genero">
                            <option value="Masculino" <?php echo $row['genero'] === 'Masculino' ? 'selected' : ''; ?>>Masculino</option>
                            <option value="Femenino" <?php echo $row['genero'] === 'Femenino' ? 'selected' : ''; ?>>Femenino</option>
                        </select>
                        <label>Contraseña:</label>
                        <input class = "campo"type="text" name="contrasena" value="<?php echo $row['contrasena']; ?>">
                        <button type="submit" class = "Boton_Registro" name="actualizar">Actualizar</button>
                    </form>
                </div>
<?php
                include 'includes/footer.php';
            } else {
                echo "No se encontró el estudiante.";
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
            $idEstudiante = $_POST['idEstudiante'];
            $nombre = $_POST['nombre'];
            $apepat = $_POST['apepat'];
            $apemat = $_POST['apemat'];
            $fechanac = $_POST['fechanac'];
            $genero = $_POST['genero'];
            $contrasena = $_POST['contrasena'];

            if (updateEstudiante($idEstudiante, $nombre, $apepat, $apemat, $fechanac, $genero, $contrasena,)) 
            {
?>
                <script>
                    alert('Estudiante actualizado exitosamente');
                    window.location.href = 'VerEstudiantes.php';
                </script>
<?php
            } 
            else 
            {
?>
                <script>
                    alert('Error al actualizar estudiante');
                </script>
<?php
            }
        }
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
