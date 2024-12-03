<?php
require '../../Controlador/control.php';
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user'])) 
{
    $id = $_SESSION['id'];
    $user = $_SESSION['user'];

    if (verificaradmin($id, $user)) 
    {
        if (isset($_GET['ide'])) {
            $idCarrera = $_GET['ide'];
            $carrera = obtainCarreraPorId($idCarrera);

            if ($carrera) 
            {
                $row = mysqli_fetch_assoc($carrera);
                include 'includes/header.php';
?>
                <div class = "carousel"></div>
                <div class = " contenedor">
                    <form action="UpdateCarrera.php" method="POST">
                        <input class = "campo" type="hidden" name="idCarrera" value="<?php echo $row['idCarrera']; ?>">
                        <label>Nombre:</label>
                        <input class = "campo" type="text" name="nombre" value="<?php echo $row['nombre']; ?>">
                        <label>Clave:</label>
                        <input class = "campo" type="text" name="clave" value="<?php echo $row['clave']; ?>">
                        <button type="submit" class = "Boton_Registro" name="actualizar">Actualizar</button>
                    </form>
                </div>
<?php
                include 'includes/footer.php';
            } else {
                echo "No se encontró el estudiante.";
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) 
        {
            $idCarrera = $_POST['idCarrera'];
            $nombre = $_POST['nombre'];
            $clave = $_POST['clave'];


            if (updateCarrera($idCarrera, $nombre, $clave)) 
            {
?>
                <script>
                    alert('Carrera actualizado exitosamente');
                    window.location.href = 'VerCarreras.php';
                </script>
<?php
            } 
            else 
            {
?>
                <script>
                    alert('Error al actualizar la carrera');
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
