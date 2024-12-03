<?php
require '../../Controlador/control.php';
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user'])) {
    $id = $_SESSION['id'];
    $user = $_SESSION['user'];
    
    if (verificaradmin($id, $user)) {
        include 'includes/header.php';
        
        $carreras = verCarrerasEstudiantes();

?>
        <div class="carousel"></div>
        <div class="contenedor">
<?php
        if (mysqli_num_rows($carreras) > 0) {
            while ($row = mysqli_fetch_array($carreras)) 
            {
                echo '<h2>' . $row['clave'] . ': ' . $row['nombre'] . '</h2>';
                
                $estudiantes = verporCarrera($row['idCarrera']);
                
                if (mysqli_num_rows($estudiantes) > 0) 
                {
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
                        while ($rows = mysqli_fetch_array($estudiantes)) {
?>
                            <tr>
                                <th><?php echo $rows['idEstudiante']; ?></th>
                                <th><?php echo $rows['matricula']; ?></th>
                                <th><?php echo $rows['nombre']; ?></th>
                                <th><?php echo $rows['apepat']; ?></th>
                                <th><?php echo $rows['apemat']; ?></th>
                            </tr>
<?php
                        }
?>
                    </table>
<?php
                } 
                else 
                {
?>
                    <div class="contenedor">
                        <h3>No hay estudiantes registrados en alguna carrera</h3>
                        <p>Comienza por registrar una carrera o registrar estudiantes.</p>
                        <a href="GestionCarreras.php" class="boton">Registrar Carrera</a>
                        <a href="AsignarAlumnosCarrera.php" class="boton">Registrar Estudiantes</a>
                    </div>
<?php
                }
            }
?>
            <div>
                        <h1>Reporte Estudiantes por carrera </h1>
                        <a href="../../modelo/convertirpdf/generar_reporte.php?reporte=VerPorCarreras&formato=xls"> Excel
                            <img src="img/excel.png" alt="Exportar a Excel" style="width: 25px; margin-right: 10px;">
                        </a>
                        <a href="../../modelo/convertirpdf/generar_reporte.php?reporte=VerPorCarreras&formato=pdf"> PDF
                            <img src="img/pdf.png" alt="Exportar a PDF" style="width: 25px;">
                        </a>
                    </div>
<?php
        }
        else 
        {
?>
            <div class="contenedor">
                <h3>No hay estudiantes registrados en alguna carrera</h3>
                <p>Comienza por registrar una carrera o registrar estudiantes.</p>
                <a href="GestionCarreras.php" class="boton">Registrar Carrera</a>
                <a href="AsignarAlumnosCarrera.php" class="boton">Registrar Estudiantes</a>
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
