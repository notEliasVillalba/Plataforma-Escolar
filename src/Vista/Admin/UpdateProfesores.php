<?php
require '../../Controlador/control.php';
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user'])) {
    $id = $_SESSION['id'];
    $user = $_SESSION['user'];

    if (verificaradmin($id, $user)) 
    {
        if (isset($_GET['idp'])) {
            $idProf = $_GET['idp'];
            $profesor = ProfesorporId($idProf);

            if ($profesor) 
            {
                $row = mysqli_fetch_assoc($profesor);
                include 'includes/header.php';
?>
                <div class = "carousel"></div>
                <div class = " contenedor">
                    <form action="UpdateProfesores.php" method="POST">
                        <input class = "campo" type="hidden" name="idProfesor" value="<?php echo $row['idProfesor']; ?>">
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
                        <label for="vocacion">Vocacion:</label>
                        <input type="text" class = "campo" id = "vocacion" name = "vocacion" value="<?php echo $row['vocacion']; ?>">
                        <label>Contraseña:</label>
                        <input class = "campo"type="text" name="contrasena" value="<?php echo $row['contrasena']; ?>">
                        <button type="submit" class = "Boton_Registro" name="actualizar">Actualizar</button>
                    </form>
                </div>
<?php
                include 'includes/footer.php';
            } else {
                echo "No se encontró el Profesor.";
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
            $idProfesor = $_POST['idProfesor'];
            $nombre = $_POST['nombre'];
            $apepat = $_POST['apepat'];
            $apemat = $_POST['apemat'];
            $fechanac = $_POST['fechanac'];
            $vocacion = $_POST['vocacion'];
            $genero = $_POST['genero'];
            $contrasena = $_POST['contrasena'];

            if (updateProfesor($idProfesor, $nombre, $apepat, $apemat, $fechanac, $genero, $vocacion, $contrasena)) 
            {
?>
                <script>
                    alert('Profesor actualizado exitosamente');
                    window.location.href = 'VerProfesores.php';
                </script>
<?php
            } 
            else 
            {
?>
                <script>
                    alert('Error al actualizar al Profesor');
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
