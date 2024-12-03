<?php
    require_once __DIR__ . '/../modelo/Logica.php';


    /*Todas las funciones mandan a llamar a una funcion en la logica la cual es explicada , por lo que solo se describiran
    aquellas que no dependen como tal de la logica ya que seria redundante explicarlas dos veces*/
    //Funciones de Sesion
    function mostrarlogin()
    {
        header("Location: /Plataforma_Escolar/src/Vista/login.php");
    }

    //Si las credenciales son de un profesor se inicia sesion como tal
    function verProfesor($user, $id)
    {
        session_start();
        $_SESSION['id'] = $id;
        $_SESSION['user'] = $user;
        header("Location: ../Vista/Profesor/index.php");
        exit();
    }

    //Al igual que en modo administrador
    function verAdmin($user, $id)
    {
        session_start();
        $_SESSION['id'] = $id;
        $_SESSION['user'] = $user;
        header("Location: ../Vista/Admin/index.php");
        exit();
    }

    //Y modo Estudiante
    function verEstudiante($user, $id)
    {
        session_start();
        $_SESSION['id'] = $id;
        $_SESSION['user'] = $user;
        header("Location: ../Vista/Estudiante/index.php");
        exit();
    }

    
    function comprobarprofesor($user,$id)
    {
        $conn = obtenerbase();
        $resul = sesionprofesor($user, $id, $conn);
        return $resul;
    }
    
    function verificaradmin($id, $user)
    {
        return sesionadmin($user, $id, obtenerbase());
    }

    function verificarestudiante($id, $user)
    {
        $conn = obtenerbase();
        $resul = sesionestudiante($user, $id, $conn);
        return $resul;
    }

    //Administrador
    function  obtenercarreras()
    {
        $conn =  obtenerbase();
        $resul = carrerasbase($conn);
        return $resul;
    }

    function verEstudiantes()
    {
        $resul = selectEstudiantes(obtenerbase());
        return $resul;
    }

    function obtainEstudiantePorId($idEstudiante)
    {
        return obtenerEstudiantePorId($idEstudiante, obtenerbase());
    }

    function obtainGrupoPorId($idGrupo)
    {
        return obtenerGrupoporId($idGrupo, obtenerbase());
    }
    function obtainMateriaPorId($idMateria)
    {
        return obtenerMateriaPorId($idMateria, obtenerbase());
    }
    
    function updateEstudiante($idEstudiante, $nombre, $apepat, $apemat, $fechanac, $genero,  $contrasena)
    {
        return actualizarEstudiante($idEstudiante, $nombre, $apepat, $apemat, $fechanac, $genero, $contrasena, obtenerbase());
    }
    
    function updateProfesor($idProfesor, $nombre, $apepat, $apemat, $fechanac, $genero, $vocacion, $contrasena) 
    {
        return actualizarProfesor($idProfesor, $nombre, $apepat, $apemat, $fechanac, $genero, $vocacion, $contrasena, obtenerbase());
    }

    function updateMaterias($idMateria, $nombre, $clave, $horas) 
    {
        return actualizarMaterias($idMateria, $nombre, $clave, $horas, obtenerbase());
    }

    function updateGrupo($idGrupo, $nombre, $salon, $gen)
    {
        return actualizarGrupo($idGrupo, $nombre, $salon, $gen, obtenerbase());
    }

    function ProfesorporId($idProf)
    {
        return SelectProfID($idProf, obtenerbase());
    }

    function verProfesores()
    {  
        return selectProfesores(obtenerbase());
    }
    function verMateriasProfesor($id)
    {
        return selectMateriaProfesor($id, obtenerbase());
    }

    function verCarreras()
    {
        return selectCarreras(obtenerbase());
    }

    function verporGrupo($idGrupo)
    {
        return selectporgrupo($idGrupo, obtenerbase());
    }

    //Funcion que registra calificaciones y envia la sentencia a la funcion consulta
    function regCalif($idGrupo,$idMateria,$idEstudiante,$calificacion, $tipo, $periodo)
    {
        $sql = "INSERT INTO Calificacion 
        (Materia_idMateria, Estudiante_idEstudiante, calificacion, tipo, periodo) 
        VALUES ($idMateria, $idEstudiante,$calificacion, $tipo, $periodo)
        ON DUPLICATE KEY UPDATE 
        calificacion = VALUES(calificacion), 
        tipo = VALUES(tipo), 
        periodo = VALUES(periodo)";
        return consulta($sql, obtenerbase());
    }
    //Funcion que muestra calificaciones y envia la sentencia a la funcion consulta
    function verCalif()
    {
        $sql = "SELECT 
            c.idCalificacion AS id_calificacion,
            e.matricula AS matricula_estudiante,
            e.nombre AS nombre_alumno,
            e.apepat AS apellido_paterno,
            e.apemat AS apellido_materno,
            c.calificacion,
            c.tipo AS tipo_calificacion,
            c.periodo AS periodo_calificacion,
            g.nombre AS nombre_grupo,
            g.generacion AS generacion_grupo,
            m.nombre AS materia_calificacion
        FROM 
            Calificacion c
        INNER JOIN 
            Estudiante e ON c.Estudiante_idEstudiante = e.idEstudiante
        INNER JOIN 
            Estudiante_Grupo eg ON e.idEstudiante = eg.Estudiante_idEstudiante
        INNER JOIN 
            Grupo g ON eg.Grupo_idGrupo = g.idGrupo
        INNER JOIN 
            Materia m ON c.Materia_idMateria = m.idMateria
        ORDER BY 
            g.nombre, e.apepat, e.apemat, c.periodo, c.tipo;";
        
return consulta($sql, obtenerbase());

    }

    //Funcion que crea la sentencia para mostrar a estudiantes en una materia 
    function obtenerEstudiantesPorMateria($idmateria, $idgrupo)
    {
        $sql = "SELECT 
            e.idEstudiante,
            e.nombre AS nombre_estudiante,
            e.apepat AS apellido_paterno,
            e.apemat AS apellido_materno,
            m.nombre AS nombre_materia,
            g.nombre AS nombre_grupo,
            g.generacion AS generacion_grupo
        FROM 
            Estudiante e
        INNER JOIN 
            Estudiante_Grupo eg ON e.idEstudiante = eg.Estudiante_idEstudiante
        INNER JOIN 
            Grupo g ON eg.Grupo_idGrupo = g.idGrupo
        INNER JOIN 
            Profesor_Materia pm ON g.idGrupo = pm.Grupo_idGrupo
        INNER JOIN 
            Materia m ON pm.Materia_idMateria = m.idMateria
        WHERE 
            m.idMateria = $idmateria 
            AND g.idGrupo = $idgrupo; ";
        return consulta($sql, obtenerbase());
    }

    //Funcion que crea la sentencia para obtener las calificaciones de un estudiante
    function obtenerCalificacionesPorEstudiante($id)
    {
        $sql = "SELECT 
                m.nombre, 
                m.clave, 
                c.Periodo, 
                c.Tipo, 
                c.calificacion 
            FROM 
                Calificacion c
            INNER JOIN 
                Materia m ON c.Materia_idMateria = m.idMateria
            WHERE 
                c.Estudiante_idEstudiante = $id
            ORDER BY 
                c.Periodo, m.nombre;";
        return consulta($sql, obtenerbase());         
    }

    //Crea la sentencia que obtiene las materias en un grupo
    function obtenerMateriasPorGrupo($grupoId)
    {
        $sql = "SELECT 
                m.idMateria, 
                m.nombre AS nombre_materia
            FROM 
                Materia m
            INNER JOIN 
                Profesor_Materia pm ON m.idMateria = pm.Materia_idMateria
            INNER JOIN 
                Grupo g ON pm.Grupo_idGrupo = g.idGrupo
            WHERE 
                g.idGrupo = $grupoId ;" ;
        return consulta($sql, obtenerbase());        
    }

    //Crea la sentencia que obtiene los grupos por materias
    function obtenergruposmateria($idMateria)
    {
        $sql = "SELECT 
            g.idGrupo,
            g.nombre,
            g.generacion 
        FROM 
            Grupo g
        INNER JOIN 
            Profesor_Materia pm ON g.idGrupo = pm.Grupo_idGrupo
        WHERE 
            pm.Materia_idMateria = $idMateria;";


        return consulta($sql, obtenerbase());
    }

    //Crea la sentencia que obtiene los datos de una materia por su id
    function verMateriaporID($idMateria)
    {
        $sql = "SELECT * FROM Materia WHERE idMateria = $idMateria;";
        return consulta($sql, obtenerbase());
    }

    function obteneracciones()
    {
        return selectBitacora(obtenerbase());
    }
    
    //Crea la sentencia que obtiene los datos de un estudiante dependiendo de la materia
    function obtenerEstudiantesPorMateriaProfesor($idMateria, $idGrupo, $id)
    {
        $sql = "SELECT 
            e.idEstudiante,
            e.nombre , 
            e.apepat , 
            e.apemat , 
            e.matricula  
        FROM 
            Profesor p
        INNER JOIN 
            Profesor_Materia pm ON p.idProfesor = pm.Profesor_idProfesor
        INNER JOIN 
            Grupo g ON pm.Grupo_idGrupo = g.idGrupo
        INNER JOIN 
            Estudiante_Grupo eg ON g.idGrupo = eg.Grupo_idGrupo
        INNER JOIN 
            Estudiante e ON eg.Estudiante_idEstudiante = e.idEstudiante
        WHERE 
            p.idProfesor = $id    
            AND pm.Materia_idMateria = $idMateria
            AND g.idGrupo = $idGrupo;";
        return consulta($sql, obtenerbase());

    }

    //Crea la sentencia que obtiene los grupos de un profesor en donde imparte una materia
    function verMateriasprofgrup($id, $materia)
    {
        $sql = "SELECT 
            g.idGrupo,
            g.nombre,
            g.generacion
        FROM 
            Profesor_Materia pm
        INNER JOIN 
            Grupo g ON pm.Grupo_idGrupo = g.idGrupo
        WHERE 
            pm.Profesor_idProfesor = $id 
            AND pm.Materia_idMateria = $materia;";
        return consulta($sql, obtenerbase());
    }

    function eliminarcarrera($id)
    {
        return deletecarrera($id, obtenerbase());
    }

    function verEstudiantessinG()
    {
        return selectEstudiantessinG(obtenerbase());
    }
    function verprofid($id)
    {
        return selectprofid($id,obtenerbase());
    }

    function iniciosesion($user, $pass)
    {
        iniciarsesion($user,$pass, obtenerbase());
    }

    function verporCarrera($idCarrera)
    {
        return selectporCarrera($idCarrera, obtenerbase());
    }

    function regprofesor($nombre,$apepat,$apemat,$genero,$fechanac,$idCarrera)
    {
        return  registarprofesor($nombre,$apepat,$apemat,$genero,$fechanac,$idCarrera,obtenerbase());
    }

    function regEstudiante($nombre,$apepat,$apemat,$genero,$fechanac,$carrera)
    {
         return registarestudiante($nombre,$apepat,$apemat,$genero,$fechanac,$carrera,obtenerbase());
    }

    function regcarrera($nombre,$clave)
    {
        return registarcarrera($nombre,$clave,obtenerbase());
    }

    function deleteprofesor($id)
    {
        return eliminarProfesor($id, obtenerbase());
    }

    function deleteEstudiante($ide)
    {
        return eliminarEstudiante($ide, obtenerbase());
    }

    function verProfesoresconGrupo()
    {
        return verProfGrupo(obtenerbase());
    }

    function verCarrerasEstudiantes()
    {
        return verCarreAlum(obtenerbase());
    }

    function materiadeprofe($id)
    {
        return profemateria($id, obtenerbase());
    }


    // Crea la sentencia que obtiene los grupos que tienen asignado a un profesor
    function obtenergruposprof($id)
    {
        $sql = "SELECT 
                g.idGrupo,
                g.nombre,
                g.generacion
            FROM 
                Profesor_Materia pm
            INNER JOIN 
                Grupo g ON pm.Grupo_idGrupo = g.idGrupo
            INNER JOIN 
                Estudiante_Grupo eg ON g.idGrupo = eg.Grupo_idGrupo
            WHERE 
                pm.Profesor_idProfesor = $id
            GROUP BY
                g.idGrupo, g.nombre, g.generacion
            HAVING 
                COUNT(eg.Estudiante_idEstudiante) > 0;";
    
        return consulta($sql,obtenerbase());
    }

    //Crea la sentencia que muestra a los estudiantes de un grupo
    function alumnosgruposmateria($idGrupo)
    {
        $sql = "SELECT 
                e.matricula, 
                e.nombre, 
                e.apepat, 
                e.apemat, 
                c.nombre AS carrera 
            FROM 
                Estudiante_Grupo eg
            INNER JOIN 
                Estudiante e ON eg.Estudiante_idEstudiante = e.idEstudiante
            INNER JOIN 
                Grupo g ON eg.Grupo_idGrupo = g.idGrupo
            INNER JOIN 
                Carrera c ON e.Carrera_idCarrera = c.idCarrera
            WHERE 
                g.idGrupo = $idGrupo;";
        return consulta($sql,obtenerbase());        
            
    }

    function carreras_estudiantes($idc)
    {
        return estudiante_carrera($idc, obtenerbase());
    }

    function verGrupoEstudiantes()
    {
        return vergrupo_estu(obtenerbase());
    }

    function regMateria($nombre, $clave, $horas)
    {
        return regMat($nombre, $clave, $horas, obtenerbase());
    }

    function verMaterias()
    {
        return selectMaterias(obtenerbase());
    }

    function deleteMateria($idm)
    {
        return eliminatMateria($idm, obtenerbase());
    }

    function regGrupo($nombre, $salon, $generacion)
    {
        return regGrup($nombre, $salon, $generacion, obtenerbase());
    }

    function verGrupos()
    {
        return selectGrup(obtenerbase());
    }

    function deleteGrupo($idg)
    {
        return eliminarGrup($idg, obtenerbase());
    }

    function asignarEstudianteAGrupo($idEstudiante, $idGrupo) 
    {
        return asignarEstudianteGrupo($idEstudiante, $idGrupo, obtenerbase());
    }
    
    function respaldoBase() 
    {
        $resultado = respaldoSql();

        if ($resultado) 
        {
            return true;
        } 
        else 
        {
            return false;
        }
    }

    function restaurarBase($archivoTemporal) 
    {
        return restaurarSql($archivoTemporal);
    }

    function registrarProfesorGrupo($idProfesor,$idMateria,$idGrupo)
    {
        return regProfGrup($idProfesor,$idMateria,$idGrupo, obtenerbase());
    }

    //Crea la sentencia que permite el registro de un administrador
    function regAdmin($nombre,$correo,$contrasena)
    {
        $sql = "INSERT INTO ADMIN(nombre,correo,contrasena) VALUES('$nombre','$correo','$contrasena');";
        return consulta($sql,obtenerbase());    
    }

    /*Estudiante*/
    function verificarcontra($actual, $id)
    {
        return comprobaspass($actual, $id, obtenerbase());
    }

    function cambiarcontra($nueva, $id)
    {
        return updatepass($nueva, $id, obtenerbase());
    }

    function infoEstudiante($id) 
    {
        return informacionEstudiante($id, obtenerbase());
    }


    //Crea la sentencia que permite ver los datos de todos los administradores
    function verAdmins()
    {
        $sql = "SELECT * FROM Admin;";
        return consulta($sql,obtenerbase());  
    }
    
?>