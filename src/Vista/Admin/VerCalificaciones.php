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
            $calificaciones = verCalif();
?>
            <div class = "carousel"></div>
            <div class = "contenedor">
                <table class = "consultas">
                    <thead>
                        <td>Id</td>
                        <td>Nombre</td>
                        <td>Apellido paterno</td>
                        <td>Apellido Materno</td>
                        <td>Matricula</td>
                        <td>Materia</td>
                        <td>Calificacion</td>
                        <td>Periodo</td>
                        <td>Parcial</td>
                        <td>Grupo</td>
                        <td>Generacion</td>
                    </thead>
                    <tbody>
                    <?php
                if ($calificaciones && mysqli_num_rows($calificaciones) > 0) 
                {
                    while ($row = mysqli_fetch_assoc($calificaciones)) 
                    {
                ?>
                        <tr>
                            <th><?php echo $row['id_calificacion']; ?></th>
                            <th><?php echo $row['nombre_alumno']; ?></th>
                            <th><?php echo $row['apellido_paterno']; ?></th>
                            <th><?php echo $row['apellido_materno']; ?></th>
                            <th><?php echo $row['matricula_estudiante']; ?></th>
                            <th><?php echo $row['materia_calificacion']; ?></th>
                            <th><?php echo $row['calificacion']; ?></th>
                            <th><?php echo $row['periodo_calificacion']; ?></th>
                            <th><?php echo $row['tipo_calificacion']; ?></th>
                            <th><?php echo $row['nombre_grupo']; ?></th>
                            <th><?php echo $row['generacion_grupo']; ?></th>
                        </tr>
                <?php
                    }
                } 
                else 
                {
                    echo '<tr><td colspan="10">No se encontraron calificaciones.</td></tr>';
                }
                ?>
                    </tbody>
                </table>

                <div>
                    <h1>Reporte Calificacion materias</h1>
                    <a href="../../modelo/convertirpdf/generar_reporte.php?reporte=CalificacionesMaterias&formato=xls"> Excel
                        <img src="img/excel.png" alt="Exportar a Excel" style="width: 25px; margin-right: 10px;">
                    </a>
                    <a href="../../modelo/convertirpdf/generar_reporte.php?reporte=CalificacionesMaterias&formato=pdf"> PDF
                        <img src="img/pdf.png" alt="Exportar a PDF" style="width: 25px;">
                    </a>
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
   