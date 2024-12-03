<?php
    require '../../Controlador/control.php';
    session_start();
    if(isset($_SESSION['id']) && isset($_SESSION['user']))
    {

        $id = $_SESSION['id'];
        $user = $_SESSION['user'];
        if(comprobarprofesor($user,$id))
        {
            $profesor = verprofid($id);
            $informacionEstudiante = mysqli_fetch_array($profesor);
            include 'includes/header.php';
?>
            <div class = "carousel"></div>
            <div class="contenedor-info">
                <div class="info-usuario">
                    <h3>Información del Profesor</h3>
                    <p><strong>Nombre:</strong> <?php echo $informacionEstudiante['nombre']; ?></p>
                    <p><strong>Apellido Paterno:</strong> <?php echo $informacionEstudiante['apepat']; ?></p>
                    <p><strong>Apellido Materno:</strong> <?php echo $informacionEstudiante['apemat']; ?></p>
                    <p><strong>Fecha de Nacimiento:</strong> <?php echo $informacionEstudiante['fechanac']; ?></p>
                    <p><strong>Género:</strong> <?php echo $informacionEstudiante['genero']; ?></p>
                    <p><strong>Vocación:</strong><?php echo $informacionEstudiante['vocacion'];?></p>
                </div>
                <div class="foto-usuario">
                    <img src="../Estudiante/img/usuario.png" alt="Foto del usuario" />
                </div>
            </div>
            <div class = "contenedor">
                <div>
                    <h1>Materias</h1>
                    <a href="VerMaterias.php">Ver Materias Asignadas</a>
                    <a href="RegCalificacion.php">Asignar calificacion</a>
                </div>

                <div>
                    <h1>Alumnos</h1>
                    <a href="VerGrupos.php">Ver Grupos asignados por grupos</a>
                </div>
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