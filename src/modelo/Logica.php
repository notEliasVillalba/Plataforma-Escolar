<?php

   require_once __DIR__ . '/../Controlador/control.php';


   //funcion para obtener accesso a la base de datos
    function obtenerbase()
    {
        $conn = mysqli_connect('localhost', 'root', '1234', 'Plataforma_Escolar');
        return $conn;
    }

    //funcion que verifica que modo de usuario es el que intenta ingresar al sistema

    function iniciarsesion($user, $pass, $conn)
    {
        $sqlprof = $conn->prepare("SELECT idProfesor FROM Profesor WHERE correo = ? AND contrasena = ?");
        $sqlest = $conn->prepare("SELECT idEstudiante FROM Estudiante WHERE correo = ? AND contrasena = ?");
        $sqladmin = $conn->prepare("SELECT idadmin FROM admin WHERE correo = ? AND contrasena = ?");

        $sqlprof->bind_param("ss", $user, $pass);
        $sqlest->bind_param("ss", $user, $pass);
        $sqladmin->bind_param("ss", $user, $pass);

        $sqlprof->execute();
        $resultProf = $sqlprof->get_result();
        if ($resultProf->num_rows === 1) 
        {
            $row = $resultProf->fetch_assoc();
            $id = $row['idProfesor'];
            sleep(0.8);
            verProfesor($user, $id);
            return;
        }

        $sqladmin->execute();
        $resultAdmin = $sqladmin->get_result();
        if ($resultAdmin->num_rows === 1)
        {
            $row = $resultAdmin->fetch_assoc();
            $id = $row['idadmin'];
            sleep(0.8);
            verAdmin($user, $id);
            return;
        }

        $sqlest->execute();
        $resultEst = $sqlest->get_result();
        if ($resultEst->num_rows === 1)
        {
            $row = $resultEst->fetch_assoc();
            $id = $row['idEstudiante'];
            sleep(0.8);
            verEstudiante($user, $id);
            return;
        }

        return 0;

        $sqlprof->close();
        $sqlest->close();
        $sqladmin->close();
    }

    //verifica que la sesion sea de un profesor
    function sesionprofesor($user, $id, $conn)
    {
        $sql = "select * from Profesor where idProfesor = $id and correo = '$user';";
        $exe = mysqli_query($conn, $sql);
        if(mysqli_num_rows($exe) == 1)
        {
            return 1;
        }
        return 0 ;
    }

    //verifica que la sesion sea de un administrador
    function sesionadmin($user,$id,$conn)
    {
        $sql = "select * from admin where idadmin = $id and correo = '$user';";
        $exe = mysqli_query($conn, $sql);
        if(mysqli_num_rows($exe) == 1)
        {
            return 1;
        }
        return 0 ;
    }

    //verifica que la sesion sea de un estudiante
    function sesionestudiante($user, $id, $conn)
    {
        $sql = "select * from estudiante where idEstudiante = $id and correo = '$user';";
        $exe = mysqli_query($conn, $sql);
        if(mysqli_num_rows($exe) == 1)
        {
            return 1;
        }
        return 0 ;
    }

    //muestra las carreras registradas
    function carrerasbase($conn)
    {
        $sql = "select idCarrera, nombre from carrera;";
        $exe = mysqli_query($conn,$sql);
        return $exe;
    }

    //registra estudiantes en la base de datos
    function registarestudiante($nombre,$apepat,$apemat,$genero,$fechanac,$idCarrera, $conn)
    {
        $sql = "INSERT INTO Estudiante(nombre, apepat, apemat, genero, fechanac, fecingreso, Carrera_idCarrera) VALUES
        ('$nombre', '$apepat', '$apemat', '$genero', '$fechanac', CURDATE(), $idCarrera);";
        $exe = mysqli_query($conn, $sql);
        return $exe;
    }

    //registra profesores en la base de datos
    function registarprofesor($nombre,$apepat,$apemat,$genero,$fechanac,$vocacion,$conn)
    {
        $sql = "INSERT INTO Profesor(nombre,apepat,apemat,fechanac,genero,vocacion,fecingreso) VALUES 
        ('$nombre','$apepat','$apemat','$fechanac', '$genero', '$vocacion', CURDATE() );";
        $exe = mysqli_query($conn, $sql);
        return $exe;

    }

    //Muestra los estudiantes que no cuentan con un grupo asignado
    function selectEstudiantessinG($conn)
    {
        $sql = "SELECT 
            e.idEstudiante,
            e.nombre,
            e.apepat,
            e.apemat,
            e.matricula,
            e.Carrera_idCarrera
        FROM 
            Estudiante e
        LEFT JOIN 
            Estudiante_Grupo eg
        ON 
            e.idEstudiante = eg.Estudiante_idEstudiante
        WHERE 
            eg.Grupo_idGrupo IS NULL;";
        return mysqli_query($conn, $sql);
        
    }

    //Muestra las materias asignadas a un profesor
    function selectMateriaProfesor($id, $conn)
    {
        $sql = "SELECT 
                    m.nombre AS nombreM,
                    m.clave,
                    g.nombre AS nombreG,
                    g.generacion
                FROM 
                    Profesor p
                INNER JOIN 
                    Profesor_Materia pm ON p.idProfesor = pm.Profesor_idProfesor
                INNER JOIN 
                    Materia m ON pm.Materia_idMateria = m.idMateria
                INNER JOIN 
                    Grupo g ON pm.Grupo_idGrupo = g.idGrupo
                WHERE 
                    p.idProfesor = $id;";
        return mysqli_query($conn, $sql);        
    }

    //Muestra profesores que tienen gruopos asignados
    function verProfGrupo($conn)
    {
        $sql = "SELECT DISTINCT
                    p.idProfesor,
                    p.nombre,
                    p.apepat,
                    p.apemat
                FROM
                    Profesor p
                INNER JOIN 
                    Profesor_Materia pm ON p.idProfesor = pm.Profesor_idProfesor
                WHERE 
                    pm.Materia_idMateria IS NOT NULL;";
        return mysqli_query($conn, $sql); 
    }

    //Muestra el grupoo y materia que imparte un profesor
    function profemateria($id, $conn)
    {
        $sql = "SELECT 
            g.idGrupo AS id_grupo,
            g.nombre AS nombre_grupo,
            g.generacion AS generacion_grupo,
            g.salon,
            m.idMateria AS id_materia,
            m.nombre AS nombre_materia,
            m.clave AS clave_materia
        FROM 
            Profesor_Materia pm
        INNER JOIN 
            Grupo g ON pm.Grupo_idGrupo = g.idGrupo
        INNER JOIN 
            Materia m ON pm.Materia_idMateria = m.idMateria
        WHERE 
            pm.Profesor_idProfesor = $id
        ORDER BY 
            g.nombre, m.nombre; ";
        return mysqli_query($conn, $sql); 
    }

    //funcion para realizar consultas desde control
    function consulta($sql, $conn)
    {
        return mysqli_query($conn, $sql); 
    }

    //Muestra las carreras que tengan almenos un alumno
    function verCarreAlum($conn)
    {
        $sql = "SELECT 
            c.idCarrera,
            c.clave, 
            c.nombre 
        FROM 
            Carrera c
        INNER JOIN 
            Estudiante e ON c.idCarrera = e.Carrera_idCarrera
        GROUP BY 
            c.idCarrera, c.clave, c.nombre
        HAVING 
            COUNT(e.idEstudiante) > 0;";
            return mysqli_query($conn, $sql); 
    }

    //muestra los grupos que tengas mas de un estudiante
    function vergrupo_estu($conn)
    {
        $sql = "SELECT 
            g.idGrupo,
            g.nombre,
            g.generacion,
            COUNT(eg.Estudiante_idEstudiante) AS total_estudiantes
        FROM 
            Grupo g
        INNER JOIN 
            Estudiante_Grupo eg ON g.idGrupo = eg.Grupo_idGrupo
        GROUP BY 
            g.idGrupo, g.nombre, g.generacion
        HAVING 
            COUNT(eg.Estudiante_idEstudiante) > 0;";
        return mysqli_query($conn, $sql);    
    }
    
    //muestra estudiantes en un grupo
    function selectporgrupo($idGrupo, $conn)
    {
        $sql = "SELECT 
            E.idEstudiante,
            E.nombre,
            E.apepat,
            E.apemat,
            E.matricula
        FROM 
            Estudiante_Grupo EG
        INNER JOIN 
            Estudiante E ON EG.Estudiante_idEstudiante = E.idEstudiante
        INNER JOIN 
            Grupo G ON EG.Grupo_idGrupo = G.idGrupo
        WHERE 
            Grupo_idGrupo = $idGrupo;";
        return mysqli_query($conn, $sql);
    }

    //muestra estudiantes por carrera
    function selectporCarrera($idCarrera, $conn)
    {
        $sql = "SELECT 
            idEstudiante, nombre, apepat, apemat, matricula 
        FROM 
            Estudiante 
        WHERE 
            Carrera_idCarrera = $idCarrera;";
        
        return mysqli_query($conn, $sql);
    }

    //muestra un grupo por su id
    function obtenerGrupoporId($idGrupo, $conn)
    {
        $sql = "SELECT * FROM Grupo WHERE idGrupo = $idGrupo;";
        return mysqli_query($conn, $sql);
    }

    //Registra carrera en la base de datos
    function registarcarrera($nombre,$clave,$conn)
    {
        $sql = "INSERT INTO Carrera(Clave, nombre) VALUES
        ('$clave', '$nombre');";
        $exe = mysqli_query($conn, $sql);
        return $exe;
    }

    //Muestra todos los datos los estudiantes
    function selectEstudiantes($conn)
    {
        $sql = "SELECT 
                e.idEstudiante,
                e.nombre,
                e.apepat,
                e.apemat,
                e.fechanac,
                e.genero,
                e.matricula,
                c.nombre AS n_Carrera,
                e.fecingreso,
                e.correo,
                e.contrasena
            FROM 
                Estudiante e
            INNER JOIN 
                Carrera c ON e.Carrera_idCarrera = c.idCarrera;";
        $resul = mysqli_query($conn,$sql);
        return $resul;
    }

    //Actualiza los datos de un estudiante
    function actualizarEstudiante($idEstudiante, $nombre, $apepat, $apemat, $fechanac, $genero,  $contrasena, $conn)
    {
        $sql = "UPDATE Estudiante 
        SET nombre = ?, apepat = ?, apemat = ?, fechanac = ?, genero = ?, contrasena = ? 
        WHERE idEstudiante = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssssi', $nombre, $apepat, $apemat, $fechanac, $genero,  $contrasena, $idEstudiante);
        return $stmt -> execute();
    }

    //Actualiza los datos de un grupo
    function actualizarGrupo($idGrupo, $nombre, $salon, $gen, $conn)
    {
        $sql = "UPDATE Grupo SET nombre = ?, salon = ?, generacion = ? WHERE idGrupo = ?;";
        $stmt = $conn->prepare($sql);
        $stmt -> bind_param('sssi', $nombre, $salon, $gen, $idGrupo);
        return $stmt->execute();
    }

    //Actualiza los datos de un Profesor
    function actualizarProfesor($idProfesor, $nombre, $apepat, $apemat, $fechanac, $genero, $vocacion, $contrasena, $conn)
    {
        $sql = "UPDATE Profesor 
        SET nombre = ?, apepat = ?, apemat = ?, fechanac = ?, genero = ?, vocacion = ?, contrasena = ? 
        WHERE idProfesor = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssssi', $nombre, $apepat, $apemat, $fechanac, $genero, $vocacion, $contrasena, $idProfesor);
        return $stmt -> execute();
    }

    //Actualiza los datos de una materia
    function actualizarMaterias($idMateria, $nombre,$clave,$horas,$conn)
    {
        $sql = "UPDATE Materia
        SET nombre = ?, clave = ?, horas = ? 
        WHERE idMateria = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $nombre, $clave, $horas, $idMateria);
        return $stmt -> execute();
    }

    //Asigna una materia y grupo a un profesor
    function regProfGrup($idProfesor,$idMateria,$idGrupo, $conn)
    {
        $sql = "INSERT INTO profesor_materia(Profesor_idProfesor, Materia_idMateria,Grupo_idGrupo) values ($idProfesor,$idMateria,$idGrupo);";
        return mysqli_query($conn, $sql);
    }

    //Obtiene los datos de un estudiante con su id    
    function obtenerEstudiantePorId($idEstudiante, $conn) 
    {
        $sql = "SELECT * FROM Estudiante WHERE idEstudiante = $idEstudiante";
        return mysqli_query($conn, $sql);
    }

    //Obtiene los datos de una materia por su id
    function obtenerMateriaPorId($idMateria, $conn) 
    {
        $sql = "SELECT * FROM Materia WHERE idMateria = $idMateria";
        return mysqli_query($conn, $sql);
    }

    //Obtiene los datos de todos los profesores
    function selectProfesores($conn)
    {
        $sql = "SELECT * FROM Profesor;";
        return mysqli_query($conn,$sql);
    }

    //Obtiene los datos de todas las carreras
    function selectCarreras($conn)
    {
        $sql = "SELECT * FROM Carrera;";
        return mysqli_query($conn,$sql);
    }

    //Elimina una carrera por medio de su id
    function deletecarrera($id, $conn)
    {
        $sql = "DELETE FROM Carrera WHERE idCarrera = $id;";
        $exe = mysqli_query($conn, $sql);
        if($exe)
        {
            return mysqli_affected_rows($conn);
        }
        else
        {
            return 0;
        }
    }

    //Elimina un estudiante por medio de su id
    function eliminarEstudiante($id,$conn)
    {
        $sql = "DELETE FROM Estudiante WHERE idEstudiante = $id;";
        $exe = mysqli_query($conn, $sql);
        if ($exe) 
        {
            return mysqli_affected_rows($conn);
        } 
        else 
        {
            return 0; 
        }
    }

    //Elimina un profesor por medio de su id
    function eliminarProfesor($id,$conn)
    {
        $sql = "DELETE FROM Profesor WHERE idProfesor = $id;";
        $exe = mysqli_query($conn, $sql);
    
        if ($exe) 
        {
            return mysqli_affected_rows($conn);
        } 
        else 
        {
            return 0; 
        }
    }

    //Muestra todos los datos de la bitacora
    function selectBitacora($conn)
    {
        $sql = "SELECT * FROM bitacora;";
        return mysqli_query($conn,$sql);
    }
    
    //Muestra todos los estudiantes de una carrera
    function estudiante_carrera($idc, $conn)
    {
        $sql = "SELECT * FROM Estudiante where Carrera_idCarrera = $idc;";
        $exe = mysqli_query($conn, $sql);
        return mysqli_num_rows($exe);
    }

    //Muestra a un profesor por su id
    function SelectProfID($idProf, $conn)
    {
        $sql = "SELECT * FROM Profesor WHERE idProfesor = $idProf;";
        return mysqli_query($conn,$sql);
    }

    //Registra materias en la base de datos
    function regMat($nombre, $clave, $horas, $conn)
    {
        $sql = "INSERT INTO Materia(nombre, clave, horas) VALUES ('$nombre', '$clave', $horas);";
        return mysqli_query($conn, $sql);
    }

    //Muestra todas las materias
    function selectMaterias($conn)
    {
        $sql = "SELECT * FROM Materia;";
        return mysqli_query($conn, $sql);
    }

    //Elimina una materia con su id
    function eliminatMateria($idm, $conn)
    {
        $sql = "DELETE FROM Materia WHERE IdMateria = $idm;";
        $exe = mysqli_query($conn, $sql);
    
        if ($exe) 
        {
            return mysqli_affected_rows($conn);
        } 
        else 
        {
            return 0; 
        }
    }

    //Registra un grupo en la base de datos
    function regGrup($nombre,$salon,$generacion,$conn)
    {
        $sql = "INSERT INTO grupo(nombre, salon, generacion) VALUES ('$nombre','$salon','$generacion');";
        return mysqli_query($conn, $sql);
    }

    //Muestra todos los grupos
    function selectGrup($conn)
    {
        $sql = "SELECT * FROM grupo";
        return mysqli_query($conn, $sql);
    }

    //Elimina un grupo con su id
    function eliminarGrup($idg, $conn)
    {
        $sql = "DELETE FROM grupo WHERE idGrupo = $idg";
        $exe = mysqli_query($conn, $sql);
    
        if ($exe) 
        {
            return mysqli_affected_rows($conn);
        } 
        else 
        {
            return 0; 
        }
    }

    //Asigna un estudiante a un grupo
    function asignarEstudianteGrupo($idEstudiante, $idGrupo, $conn) 
    {
        $sql = "INSERT INTO estudiante_grupo (Estudiante_idEstudiante, Grupo_idGrupo) VALUES ($idEstudiante, $idGrupo)";
        $exe = mysqli_query($conn, $sql);
        
        return $exe ? 1 : 0;
    }


    //Esta funcion permite realizar un archivo sql con un respaldo de los datos en la base de datos
    function respaldoSql() 
    {
        $archivoRespaldo = "respaldo_" . date("Y-m-d_H-i-s") . ".sql";
        $comando = "C:/xampp/mysql/bin/mysqldump -u root -padmin -h localhost Plataforma_Escolar";
        exec($comando, $output, $resultado);
    
        if ($resultado === 0) 
        {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($archivoRespaldo) . '"');
            header('Content-Transfer-Encoding: binary');
    
            foreach ($output as $line) 
            {
                echo $line . PHP_EOL;
            }
    
            exit;
        } 
        else 
        {
            return "Error al realizar el respaldo de la base de datos. Detalles: " . implode("\n", $output);
        }
    }

    //Esta funcion permite la restauracion de la base de datos desde un archivo sql

    function restaurarSql($archivoTemporal)
    {
        $host = 'localhost';
        $usuario = 'root';
        $password = '1234';
        $baseDatos = 'Plataforma_Escolar';
        
        $comando = "C:/xampp/mysql/bin/mysql -h $host -u $usuario -p$password $baseDatos < $archivoTemporal";
        
        exec($comando, $output, $return_var);
        
        if ($return_var === 0)
        {
            return true;
        } 
        else 
        {
            return "Error al restaurar la base de datos. Código de error: $return_var";
        }
    }

    //Comprueba la contraseña actual de un estudiante
    function comprobaspass($actual, $id, $conn)
    {
        $sql = $conn->prepare("SELECT idEstudiante FROM Estudiante WHERE idEstudiante = ? AND contrasena = ?;");
        $sql->bind_param("is", $id, $actual);

        $sql->execute();

        $result = $sql->get_result();

        if ($result && $result->num_rows === 1) 
        {
            return true; 
        } 
        else 
        {
            return false;
        }
    }

    //Actualiza la contreaseña de un estudiante
    function updatepass($nueva, $id, $conn)
    {
        $sql = $conn->prepare("UPDATE Estudiante SET contrasena = ? WHERE idEstudiante = ?;");
        $sql->bind_param("si", $nueva, $id);
        return $sql->execute();
        
    }

    //muestra los datos de un estudiante con su id
    function informacionEstudiante($id, $conn) 
    {
        $sql = "SELECT 
                e.idEstudiante,
                e.nombre,
                e.apepat,
                e.apemat,
                e.fechanac,
                e.genero,
                e.matricula,
                c.nombre AS n_Carrera,
                e.fecingreso,
                e.correo,
                e.contrasena
            FROM 
                Estudiante e
            
            INNER JOIN 
                Carrera c ON e.Carrera_idCarrera = c.idCarrera
            WHERE
            e.idEstudiante = $id;";
        $resul = mysqli_query($conn,$sql);
        return $resul;
    } 
?>