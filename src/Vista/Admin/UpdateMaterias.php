<?php
require '../../Controlador/control.php';
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user'])) {
    $id = $_SESSION['id'];
    $user = $_SESSION['user'];

    if (verificaradmin($id, $user)) {
        if (isset($_GET['ide'])) {
            $idMateria = $_GET['ide'];
            $materia = obtainMateriaPorId($idMateria);

            if ($materia) 
            {
                $row = mysqli_fetch_assoc($materia);
                include 'includes/header.php';
?>
                <div class = "carousel"></div>
                <div class = " contenedor">
                    <form action="UpdateMaterias.php" method="POST">
                        <input class = "campo" type="hidden" name="idMateria" value="<?php echo $row['idMateria']; ?>">
                        <label>Nombre:</label>
                        <input class = "campo" type="text" name="nombre" value="<?php echo $row['nombre']; ?>">
                        <label>Clave:</label>
                        <input class = "campo" type="text" name="clave" value="<?php echo $row['clave']; ?>">
                        <label>Horas:</label>
                        <select class = "campo" name="horas" id="horas" value="<?php echo $row['horas']; ?>">
                            <option value="0">Ingresa un numero...</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                        </select>
                        <button type="submit" class = "Boton_Registro" name="actualizar">Actualizar</button>
                    </form>
                </div>
<?php
                include 'includes/footer.php';
            } else {
                echo "No se encontró la materia.";
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar']))
        {
            $idMateria = $_POST['idMateria'];
            $nombre = $_POST['nombre'];
            $clave = $_POST['clave'];
            $horas = $_POST['horas'];

            if (updateMaterias($idMateria, $nombre, $clave, $horas)) 
            {
?>
                <script>
                    alert('Materia actualizada exitosamente');
                    window.location.href = 'VerMaterias.php';
                </script>
<?php
            } 
            else 
            {
?>
                <script>
                    alert('Error al actualizar la materia');
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
