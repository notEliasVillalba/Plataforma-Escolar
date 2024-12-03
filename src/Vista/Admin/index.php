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
            
?>
            <div class="carousel"></div>

            <div class="contenedor">

                <div>
                    <h1>Gestion de Estudiantes</h1>
                    <a href="GestionEstudiantes.php">Registrar Estudiante</a>
                    <a href="VerEstudiantes.php">Ver información de los Estudiantes</a>
                    <a href="VerPorGrupo.php">Ver Estudiantes por grupo</a>
                    <a href="VerAlumnosCarreras.php">Ver Estudiante por carrera</a>
                </div>

                <div>
                    <h1>Gestion de Profesores</h1>
                    <a href="GestionProfesor.php">Registrar Profesores</a>
                    <a href="VerProfesores.php">Ver información de los Profesores</a>
                    <a href="VerMatGruProf.php">Ver Materias asignadas a Profesores</a>
                </div>

                <div>
                    <h1>Gestion de Carreras</h1>
                    <a href="regCarrera.php">Registrar Carrera</a>
                    <a href="VerCarreras.php">Ver información de las carreras</a>
                </div>

                <div>
                    <h1>Gestion de Materias</h1>
                    <a href="regMaterias.php">Registrar Materia</a>
                    <a href="VerMaterias.php">Ver Materias</a>
                </div>

                <div>
                    <h1>Gestion de Calificaciones</h1>
                    <a href="RegCalificacion.php">Registrar Calificacion</a>
                    <a href="VerCalificaciones.php">Ver Calificaciones</a>
                </div>

                <div>
                    <h1>Gestion de Grupos</h1>
                    <a href="GestionGrupos.php">Registrar Grupos</a>
                    <a href="VerGrupos.php">Ver Grupos</a>
                    <a href="AsignarAlumnosGrupo.php">Asignar alumnos a grupo</a>
                    <a href="AsignarGruposProfesor.php">Asignar Grupo a profesor</a>
                </div>

                <div>
                    <h1>Generar Reportes</h1>
                    <a href="GenerarReportes.php">Ver tipos de reportes</a>
                </div>

                <div>
                    <h1>Bitacora</h1>
                    <a href="VerBitacora.php">Ver Bitacora de movimientos</a>
                </div>

                <div>
                    <h1>Base de datos</h1>
                    <a href="RespaldoBD.php">Respaldo/Restauracion base de datos</a>
                </div>

                <div>
                    <h1>Gestion de Administradores</h1>
                    <a href="GestionAdministradores.php">Registrar Administrador</a>
                    <a href="VerAdministradores.php">Ver informacion de los Administradores</a>
                </div>

            </div>
        

<?php
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

<?php include 'includes/footer.php'; ?>

