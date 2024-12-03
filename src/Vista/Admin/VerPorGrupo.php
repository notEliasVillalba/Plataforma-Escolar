<?php
    require '../../Controlador/control.php';
    session_start();
    if(isset($_SESSION['id']) && isset($_SESSION['user']))
    {
        $id = $_SESSION['id'];
        $user = $_SESSION['user'];
        if(verificaradmin($id, $user))
        {
            include 'includes/header.php'; ?>
            <div class="carousel"></div>
            <div class="contenedor">
<?php   
                $grupos = verGrupoEstudiantes();

                if (mysqli_num_rows($grupos) > 0) {
                    while($row = mysqli_fetch_array($grupos))
                    {
                        echo '<h2>' . $row['nombre'] . ' Generación: ' . $row['generacion'] . '</h2>';

                        $alumnos = verporGrupo($row['idGrupo']);
                        
                        if (mysqli_num_rows($alumnos) > 0) {
?>
                            <table class="consultas">
                                <thead>
                                    <td>Id</td>
                                    <td>Matricula</td>
                                    <td>Nombre</td>
                                    <td>Apellido Paterno</td>
                                    <td>Apellido Materno</td>
                                </thead>
<?php
                                while($rows = mysqli_fetch_array($alumnos))
                                {
?>
                                    <tr>
                                        <th><?php echo $rows['idEstudiante'] ?></th>
                                        <th><?php echo $rows['matricula'] ?></th>
                                        <th><?php echo $rows['nombre'] ?></th>
                                        <th><?php echo $rows['apepat'] ?></th>
                                        <th><?php echo $rows['apemat'] ?></th>
                                    </tr>
<?php                           }
?>
                            </table>

<?php
                        } 
                        else 
                        {
?>
                            <div class="contenedor">
                                <h3>No hay estudiantes registrados en algun grupo</h3>
                                <p>Comienza por crear un grupo y asignar estudiantes.</p>
                                <a href="GestionGrupos.php" class="boton">Crear Grupo</a>
                            </div>
<?php
                        }
                    }

?>
                    <div>
                        <h1>Reporte Estudiantes por grupo </h1>
                        <a href="../../modelo/convertirpdf/generar_reporte.php?reporte=VerPorGrupos&formato=xls"> Excel
                            <img src="img/excel.png" alt="Exportar a Excel" style="width: 25px; margin-right: 10px;">
                        </a>
                        <a href="../../modelo/convertirpdf/generar_reporte.php?reporte=VerPorGrupos&formato=pdf"> PDF
                            <img src="img/pdf.png" alt="Exportar a PDF" style="width: 25px;">
                        </a>
                    </div>
<?php
                } 
                else 
                {
?>
                    <div class="contenedor">
                        <h3>No hay estudiantes registrados en algun grupo</h3>
                        <p>Comienza por crear un grupo y asignar estudiantes.</p>
                        <a href="GestionGrupos.php" class="boton">Crear Grupo</a>
                    </div>
<?php
                }
?>
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
