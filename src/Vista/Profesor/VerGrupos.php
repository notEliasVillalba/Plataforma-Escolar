<?php
    require '../../Controlador/control.php';
    session_start();
    if(isset($_SESSION['id']) && isset($_SESSION['user']))
    {

        $id = $_SESSION['id'];
        $user = $_SESSION['user'];
        if(comprobarprofesor($user,$id))
        {
            $grupos = obtenergruposprof($id);
            include 'includes/header.php';
?>
            <div class = "carousel" ></div>
            <div class = "contenedor">
<?php
            if($grupos)
            {
                while($row = mysqli_fetch_array($grupos))
                {
                    $alumnos = alumnosgruposmateria($row['idGrupo']);
    ?>                  <h2><?php echo $row['nombre']. ' Generación ' . $row['generacion'];?></h2>      

                        <table class = "consultas">
                            <thead>
                                <td>Matricula</td>
                                <td>Nombre</td>
                                <td>Apellido Paterno</td>
                                <td>Apellido Materno</td>
                                <td>Carrera</td>
                            </thead>
                        
            <?php
                        while($rows = mysqli_fetch_array($alumnos))
                        {
    ?>
                            <tr>
                                <th><?php echo $rows['matricula']?></th>
                                <th><?php echo $rows['nombre']?></th>
                                <th><?php echo $rows['apepat']?></th>
                                <th><?php echo $rows['apemat']?></th>
                                <th><?php echo $rows['carrera']?></th>
                            </tr>
    <?php           
                        }
                ?> </table> <?php
                }
            }
            else
            {
            ?>  <h2>No hay grupos asignados</h2> <?php
            }

?>
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