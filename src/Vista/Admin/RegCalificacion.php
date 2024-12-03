<?php
require '../../Controlador/control.php';
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user'])) {
    $id = $_SESSION['id'];
    $user = $_SESSION['user'];
    if (verificaradmin($id, $user)) {
        include 'includes/header.php';
        $materia = verMaterias();

        if (mysqli_num_rows($materia) > 0)
        { 
?>
            <div class="carousel"></div>
            <div class="contenedor">
                <form action="RegCalificacion_2.php" method="POST">
                    <label for="idMateria">Seleccione una materia:</label>
                    <select class="campo" name="idMateria" id="idMateria">
    <?php
                    while ($row = mysqli_fetch_array($materia)) 
                    {
    ?>
                        <option value="<?php echo $row['idMateria'] ?>">
                            <?php echo $row['clave'] . ' : ' . $row['nombre'] ?>
                        </option>
    <?php
                    }
    ?>
                    </select>
                    <button class="Boton_Registro">Siguiente</button>
                </form>
            </div>
<?php
        } 
        else 
        { 
?>
            <div class="carousel"></div>
            <div class="contenedor">
                <div class="contenedor">
                    <h3>No hay materias registradas.</h3>
                    <p>Para registrar una calificación, primero debe registrar materias.</p>
                    <a href="regMaterias.php" class="boton">Registrar Materia</a>
                </div>
            </div>
<?php
        }

        include 'includes/footer.php';
    } else {
        header("Location: ../../Controlador/logout.php");
    }
} else {
    header("Location: ../../Controlador/logout.php");
}
?>
