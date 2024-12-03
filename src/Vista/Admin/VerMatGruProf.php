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
            <div class = "carousel"></div>
            <div class = "contenedor">
<?php
            
            $Profesores = verProfesoresconGrupo();
            if($Profesores)
            {
                while($row = mysqli_fetch_array($Profesores))
                {
?>
                    <h2><?php echo $row['nombre'] . ' ' . $row['apepat'] . ' '. $row['apemat'] ?></h2>
<?php               $materias = verMateriasProfesor($row['idProfesor']);
?>                  
                    <table class = "consultas">
                        <thead>
                            <td>Materia</td>
                            <td>Clave</td>
                            <td>Grupo</td>
                        </thead>
<?php   
                        while($rows = mysqli_fetch_array($materias))
                        {
?>
                            <tr>
                                <th><?php echo $rows['nombreM'] ?></th>
                                <th><?php echo $rows['clave'] ?></th>
                                <th><?php echo $rows['nombreG'] ?></th>
                            </tr>
<?php                   } ?>
                    </table>

                
<?php
                }
            }
            else
            {
?>              <h1>No existen registros</h1>
                <div>
                    <a href="GestionProfesor.php">Registar Profesor</a>
                </div>

                
<?php       }
?>          </div>
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

