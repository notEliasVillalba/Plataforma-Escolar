<?php
    require '../../Controlador/control.php';
    session_start();
    if(isset($_SESSION['id']) && isset($_SESSION['user']))
    {

        $id = $_SESSION['id'];
        $user = $_SESSION['user'];
        if(comprobarprofesor($user,$id))
        {
            include 'includes/header.php';
        ?>  <div class = "carousel" ></div>
            <div class = "contenedor">
        <?php
            $materias = materiadeprofe($id);
            
            if($materias)
            {
?>              <table class = "consultas">
                    <thead>
                        <td>Materia</td>
                        <td>Clave</td>
                        <td>Grupo</td>
                        <td>Generación</td>
                        <td>Salon</td>
                    </thead>
<?php   
                    while($rows = mysqli_fetch_array($materias))
                    {
    ?>
                        <tr>
                            <th><?php echo $rows['nombre_materia']?></th>
                            <th><?php echo $rows['clave_materia']?></th>
                            <th><?php echo $rows['nombre_grupo']?></th>
                            <th><?php echo $rows['generacion_grupo']?></th>
                            <th><?php echo $rows['salon']?></th>
                        </tr>
    <?php
                    }
            ?>  </table> <?php
            }
            else
            {
                ?>
                <h2>No hay grupos asignados</h2><?php
            }
            ?>  </div> <?php
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