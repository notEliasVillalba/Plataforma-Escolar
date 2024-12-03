<?php
require '../../Controlador/control.php';
session_start();
if(isset($_SESSION['id']) && isset($_SESSION['user'])) 
{
    $id = $_SESSION['id'];
    $user = $_SESSION['user'];
    if(verificaradmin($id, $user))
     {
        include 'includes/header.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            $idEstudiante = $_POST['idEstudiante'];
            $idGrupo = $_POST['idGrupo'];

            if(asignarEstudianteAGrupo($idEstudiante, $idGrupo))
            {
                echo 
                "<script>
                    alert('Estudiante asignado exitosamente al grupo');
                </script>";
            } 
            else 
            {
                echo "<script>alert('Error al asignar el estudiante al grupo');</script>";
            }
        }

        $grupos = verGrupos();
        $estudiantes = verEstudiantessinG();
?>
        <div class="carousel"></div>
        <div class="contenedor">
            <form method="POST" action="AsignarAlumnosGrupo.php">
                <label for="idEstudiante">Selecciona Estudiante:</label>
                <select name="idEstudiante" id="idEstudiante">
                    <?php while($row = mysqli_fetch_array($estudiantes)) { ?>
                        <option value="<?php echo $row['idEstudiante']; ?>">
                            <?php echo $row['matricula'].' : ' . $row['nombre']. ' '. $row['apepat']. ' ' . $row['apemat']; ?>
                        </option>
                    <?php } ?>
                </select>

                <label for="idGrupo">Selecciona Grupo:</label>
                <select name="idGrupo" id="idGrupo">
                    <?php while($row = mysqli_fetch_array($grupos)) { ?>
                        <option value="<?php echo $row['idGrupo']; ?>">
                            <?php echo $row['nombre']; ?>
                        </option>
                    <?php } ?>
                </select>

                <button  class = "Boton_Registro" type="submit">Asignar Estudiante a Grupo</button>
            </form>
        </div>
<?php
        include 'includes/footer.php';
    } else {
        header("Location: ../../Controlador/logout.php");
    }
} else {
    mostrarlogin();
}
?>
