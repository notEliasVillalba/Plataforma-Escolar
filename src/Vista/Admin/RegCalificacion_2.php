<?php
require '../../Controlador/control.php';
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user'])) {
    $id = $_SESSION['id'];
    $user = $_SESSION['user'];
    if (verificaradmin($id, $user)) {
        include 'includes/header.php';

        $idMateria = $_POST['idMateria'];
        $grupos = obtenergruposmateria($idMateria);

        $materia = verMateriaporID($idMateria);
        $row = mysqli_fetch_array($materia);

?>
        <div class="carousel"></div>
        <div class="contenedor">
<?php
        if (mysqli_num_rows($grupos) > 0) 
        {
?>
            <form action="AsignarCalificacion.php" method="POST">
                <label for="idMateria">Materia:</label>
                <select class="campo" name="idMateria" id="idMateria">
                    <option value="<?php echo $row['idMateria']?>"><?php echo $row['clave'] . ' : ' . $row['nombre']?></option>
                </select>
                <label for="idGrupo">Seleccione un grupo:</label>
                <select class="campo" name="idGrupo" id="idGrupo">
    <?php
                while ($rows = mysqli_fetch_array($grupos)) 
                {
    ?>
                    <option value="<?php echo $rows['idGrupo']?>"><?php echo $rows['nombre'] . " Generación " . $rows['generacion']?></option>
    <?php
                }
    ?>
                </select>
                <button class="Boton_Registro">Siguiente</button>
            </form>
            <button class="Boton_Registro" onclick="window.location.href='RegCalificacion.php';">Volver</button>
            </div>
<?php
        } 
        else 
        {
?>
            <div class="contenedor">
                <h3>No hay grupos registrados para esta materia.</h3>
                <p>Para asignar calificaciones, debe registrar un grupo para esta materia o asignar grupo a profesor.</p>
                <a href="GestionGrupos.php" class="boton">Registrar Grupo</a>
                <a href="AsignarGruposProfesor.php" class="boton">Asignar grupo a profesor</a>
            </div>
        </div>
<?php
        }

        include 'includes/footer.php';
    } 
    else 
    {
        header("Location: ../../Controlador/logout.php");
    }
} 
else 
{
    header("Location: ../../Controlador/logout.php");
}
?>

