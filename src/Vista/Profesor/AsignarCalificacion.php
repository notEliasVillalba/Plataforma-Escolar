<?php
    require '../../Controlador/control.php';
    session_start();
    if(isset($_SESSION['id']) && isset($_SESSION['user']))
    {

        $id = $_SESSION['id'];
        $user = $_SESSION['user'];
        if(comprobarprofesor($user,$id))
        {

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['calificaciones']))
            {
                $idGrupo = $_POST['idGrupo'];
                $idMateria = $_POST['idMateria'];
                $calificaciones = $_POST['calificaciones']; 
                $tipo = $_POST['tipo'];
                $periodo = $_POST['periodo'];
            
                foreach ($calificaciones as $idEstudiante => $calificacion) 
                {
                    if (!regCalif($idGrupo, $idMateria, $idEstudiante, $calificacion, $tipo, $periodo)) 
                    {
                        echo "<script>alert('Error al registrar la calificación para el estudiante ID: $idEstudiante');</script>";
                    }
                }
            
                echo 
                "<script>
                    alert('Calificaciones guardadas correctamente.');
                    window.location.href = 'index.php'; // Redirige a la página principal o donde prefieras
                </script>";
            }
            
            include 'includes/header.php';
            $idMateria = $_POST['idMateria'];
            $idGrupo = $_POST['idGrupo']; 
            $alumnos = obtenerEstudiantesPorMateriaProfesor($idMateria, $idGrupo, $id);
?>
            <div class = "carousel"></div>
            <div class = "contenedor">
        <?php if ($alumnos && mysqli_num_rows($alumnos) > 0)
              { 
                ?>
                <form action="AsignarCalificacion.php" method='POST'>
                    <label for="periodo">Selecciona el periodo:</label>
                    <select name="periodo" id="periodo" class = "campo" require>
                        <option value="1">Primer Periodo</option>
                        <option value="2">Segundo Periodo</option>
                        <option value="3">Tercer Periodo</option>
                        <option value="4">Cuarto Periodo</option>
                        <option value="5">Quinto Periodo</option>
                        <option value="6">Sexto Periodo</option>
                        <option value="7">Septimo Periodo</option>
                        <option value="8">Octavo Periodo</option>
                        <option value="9">Noveno Periodo</option>
                        <option value="10">Decimo Periodo</option>
                    </select>
                    <label for="tipo">Selecciona el tipo de calificacion:</label>
                    <select name="tipo" id="tipo" class = "campo" require>
                        <option value="1">Parcial 1</option>
                        <option value="2">Parcial 2</option>
                        <option value="3">Final</option>
                    </select>
                    <hr>
                    <table class = "consultas">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Nombre</td>
                                <td>Apellido Paterno</td>
                                <td>Apellido Materno</td>
                                <td>Matricula</td>
                                <td>Calificación</td>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($alumnos)): ?>
                                <tr>
                                    <th><?php echo $row['idEstudiante']; ?></th>
                                    <th><?php echo $row['nombre']; ?></th>
                                    <th><?php echo $row['apepat']; ?></th>
                                    <th><?php echo $row['apemat']; ?></th>
                                    <th><?php echo $row['matricula']; ?></th>
                                    <th>
                                        <input type="number" name="calificaciones[<?php echo $row['idEstudiante']; ?>]" min="0" max="10" step="1" required>
                                    </t>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <input type="hidden" name="idGrupo" value="<?php echo $idGrupo; ?>">
                    <input type="hidden" name="idMateria" value="<?php echo $idMateria; ?>">
                    <br>
                    <button type="submit" class = "Boton_Registro">Guardar Calificaciones</button>
                </form>
            <?php 
            }   
            else 
            {
                ?>
                <p>No se encontraron estudiantes para este grupo y materia.</p>
              <?php 
            }   ?>
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