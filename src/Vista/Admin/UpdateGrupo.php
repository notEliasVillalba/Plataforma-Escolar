<?php
require '../../Controlador/control.php';
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user'])) {
    $id = $_SESSION['id'];
    $user = $_SESSION['user'];

    if (verificaradmin($id, $user)) {
        if (isset($_GET['idg'])) 
        {
            $idGrupo = $_GET['idg'];
            $grupo = obtainGrupoPorId($idGrupo);

            if($grupo) 
            {
                $row = mysqli_fetch_assoc($grupo);
                include 'includes/header.php';
?>
                <div class = "carousel"></div>
                <div class = " contenedor">
                    <form action="UpdateGrupo.php" method="POST">
                        <input class = "campo" type="hidden" name="idGrupo" value="<?php echo $row['idGrupo']; ?>">
                        <label>Nombre:</label>
                        <input class = "campo" type="text" id = "nombre" name="nombre" value="<?php echo $row['nombre']; ?>">
                        <label>Salon:</label>
                        <input class = "campo" type="text" id ="salon" name="salon" value="<?php echo $row['salon']; ?>">
                        <label>Generación:</label>
                        <input type="text" class = "campo" name = "gen" id = "gen" value="<?php echo $row['generacion']; ?>">
                        <button type="submit" class = "Boton_Registro" name="actualizar">Actualizar</button>
                    </form>
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
            $idGrupo = $_POST['idGrupo'];
            $nombre = $_POST['nombre'];
            $salon = $_POST['salon'];
            $gen = $_POST['gen'];

            if (updateGrupo($idGrupo, $nombre, $salon, $gen)) 
            {
?>
                <script>
                    alert('Grupo actualizado exitosamente');
                    window.location.href = 'VerGrupos.php';
                </script>
<?php
            } 
            else 
            {
?>
                <script>
                    alert('Error al actualizar el grupo');
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
