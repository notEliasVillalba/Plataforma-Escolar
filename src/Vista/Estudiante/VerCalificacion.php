<?php
require '../../Controlador/control.php';
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user'])) {
    $id = $_SESSION['id'];
    $user = $_SESSION['user'];

    if (verificarestudiante($id, $user)) {
        include 'includes/header.php';

        $idEstudiante = $id; 
        $calificaciones = obtenerCalificacionesPorEstudiante($idEstudiante);
?>
        <div class="carousel"></div>

        <div class="contenedor">
            <?php
            if ($calificaciones && mysqli_num_rows($calificaciones) > 0) {
                $current_periodo = ''; // Para rastrear el período actual
                $first_table = true;

                while ($row = mysqli_fetch_assoc($calificaciones)) {
                    // Cuando cambia el período, cerrar la tabla anterior (si existe) y abrir una nueva
                    if ($current_periodo !== $row['Periodo']) {
                        if (!$first_table) {
                            echo "</table><br>"; // Cerrar la tabla anterior
                        }
                        $current_periodo = $row['Periodo'];
                        $first_table = false;

                        // Encabezado de la nueva tabla
                        echo "<hr>";
                        echo "<h3>Calificaciones del periodo: {$current_periodo}</h3>";

                        echo "<table class='consultas'>";
                        echo "<thead>
                                    <td>Materia</td>
                                    <td>Clave</td>
                                    <td>Parcial</td>
                                    <td>Calificación</td>
                                  </thead>";
                    }

                    // Filas de la tabla
                    echo "<tr>
                            <th>{$row['nombre']}</th>
                            <th>{$row['clave']}</th>
                            <th>{$row['Tipo']}</th>
                            <th>{$row['calificacion']}</th>
                          </tr>";
                }

                // Cerrar la última tabla
                echo "</table>";
            } else {
                echo "<p>No hay calificaciones registradas.</p>";
            }
            ?>

            <div>
                <h1>Exportar calificaciones por periodo</h1>
                <a href="../../modelo/convertirpdf/generar_reporte.php?reporte=calificaciones&formato=xls&idEstudiante=<?php echo $id ?>"> Excel
                    <img src="img/excel.png" alt="Exportar a Excel" style="width: 25px; margin-right: 10px;">
                </a>
                <a href="../../modelo/convertirpdf/generar_reporte.php?reporte=calificaciones&formato=pdf&idEstudiante=<?php echo $id ?>"> PDF
                    <img src="img/pdf.png" alt="Exportar a PDF" style="width: 25px;">
                </a>
            </div>

        </div>
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

