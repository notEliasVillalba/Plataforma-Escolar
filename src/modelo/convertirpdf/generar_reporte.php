<?php
include '../Logica.php';
$conn = obtenerbase();

$reporte = isset($_GET['reporte']) ? $_GET['reporte'] : 'calificaciones'; 
$formato = isset($_GET['formato']) ? $_GET['formato'] : 'xls';
$idEstudiante = isset($_GET['idEstudiante']) ? $_GET['idEstudiante'] : '0';

if ($reporte === 'calificaciones') 
{
    if (!$idEstudiante) 
    {
        die('ERROR: FALTA EL ID DEL ESTUDIANTE.');
    }

    $consulta = "
        SELECT
            m.nombre AS Materia,
            m.clave AS Clave,
            c.Periodo AS Periodo,
            c.Tipo AS Tipo,
            c.calificacion AS Calificacion
        FROM
            Calificacion c
        INNER JOIN
            Materia m ON c.Materia_idMateria = m.idMateria
        WHERE
            c.Estudiante_idEstudiante = $idEstudiante
        ORDER BY
            c.Periodo, m.idMateria;
    ";

    $resultado = mysqli_query($conn, $consulta);
    if (!$resultado) 
    {
        die('ERROR: No se pudo ejecutar la consulta.');
    }

    $totalCalificaciones = 0;
    $cantidadCalificaciones = 0;

    if ($formato === 'xls') 
    {
        header('Content-Type:application/xls');
        header('Content-Disposition: attachment; filename=calificaciones_periodos.xls');
        echo "<table border='1'>";
        
        $current_periodo = null;
        while ($row = mysqli_fetch_assoc($resultado)) 
        {
            $totalCalificaciones += $row['Calificacion'];
            $cantidadCalificaciones++;

            if ($current_periodo !== $row['Periodo']) 
            {
                if ($current_periodo !== null) 
                {
                    echo "</tbody></table><br>";
                }
                $current_periodo = $row['Periodo'];
                echo "<h3>Periodo: {$current_periodo}</h3>";
                echo "<table border='1'><thead><tr>
                        <th>Materia</th><th>Clave</th><th>Tipo</th><th>Calificación</th>
                      </tr></thead><tbody>";
            }
            echo "<tr> 
                    <td>" . htmlspecialchars($row['Materia']) . "</td>
                    <td>" . htmlspecialchars($row['Clave']) . "</td>
                    <td>" . htmlspecialchars($row['Tipo']) . "</td>
                    <td>" . htmlspecialchars($row['Calificacion']) . "</td>
                  </tr>";
        }
        echo "</tbody></table>";

        $promedio = $cantidadCalificaciones > 0 ? $totalCalificaciones / $cantidadCalificaciones : 0;
        echo "<p><strong>Promedio General:</strong> " . number_format($promedio, 2) . "</p>";
    } 
    elseif ($formato === 'pdf') 
    {
        require 'fpdf/fpdf.php';

        $pdf = new FPDF('P', 'mm', 'Letter');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);

        $pdf->Cell(0, 10, "Reporte de Calificaciones por Periodo", 0, 1, 'C');
        $pdf->Ln(5);

        $current_periodo = null;

        while ($row = mysqli_fetch_assoc($resultado))
        {
            $totalCalificaciones += $row['Calificacion'];
            $cantidadCalificaciones++;

            if ($current_periodo !== $row['Periodo']) 
            {
                if ($current_periodo !== null) 
                {
                    $pdf->Ln(10);
                }
                $current_periodo = $row['Periodo'];
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(0, 8, "Periodo: {$current_periodo}", 0, 1);
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(45, 8, "Materia", 1, 0, 'C');
                $pdf->Cell(45, 8, "Clave", 1, 0, 'C');
                $pdf->Cell(45, 8, "Tipo", 1, 0, 'C');
                $pdf->Cell(45, 8,utf8_decode('Calificación'), 1, 1, 'C');
            }
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(45, 8, utf8_decode($row['Materia']), 1);
            $pdf->Cell(45, 8, utf8_decode($row['Clave']), 1);
            $pdf->Cell(45, 8, utf8_decode($row['Tipo']), 1);
            $pdf->Cell(45, 8, utf8_decode($row['Calificacion']), 1);
            $pdf->Ln();
        }

        $promedio = $cantidadCalificaciones > 0 ? $totalCalificaciones / $cantidadCalificaciones : 0;
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, "Promedio General: " . number_format($promedio, 2), 0, 1, 'C');

        $pdf->Output();
    } 
    else 
    {
        die('ERROR: FORMATO INVÁLIDO (XLS O PDF).');
    }
}

if ($reporte === 'estudiantesporgenero') 
{
    // Consulta para obtener los datos de estudiantes masculinos
    $consulta_masculinos = "
        SELECT 
            e.nombre AS Nombre, 
            e.apepat AS ApellidoPaterno, 
            e.apemat AS ApellidoMaterno 
        FROM Estudiante e 
        WHERE e.genero = 'Masculino';
    ";

    // Consulta para obtener los datos de estudiantes femeninos
    $consulta_femeninos = "
        SELECT 
            e.nombre AS Nombre, 
            e.apepat AS ApellidoPaterno, 
            e.apemat AS ApellidoMaterno 
        FROM Estudiante e 
        WHERE e.genero = 'Femenino';
    ";

    $resultado_masculinos = mysqli_query($conn, $consulta_masculinos);
    $resultado_femeninos = mysqli_query($conn, $consulta_femeninos);

    if (!$resultado_masculinos || !$resultado_femeninos) {
        die('ERROR: No se pudo ejecutar alguna de las consultas de estudiantes.');
    }

    // Contar los estudiantes masculinos y femeninos
    $count_masculinos = mysqli_num_rows($resultado_masculinos);
    $count_femeninos = mysqli_num_rows($resultado_femeninos);

    if ($formato === 'xls') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=estudiantes.xls');

        // Tabla de Estudiantes Masculinos
        echo "<h3>Estudiantes Masculinos (Total: $count_masculinos)</h3>";
        echo "<table border='1'>";
        echo "<tr>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
              </tr>";

        while ($row = mysqli_fetch_assoc($resultado_masculinos)) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['Nombre']) . "</td>
                    <td>" . htmlspecialchars($row['ApellidoPaterno']) . "</td>
                    <td>" . htmlspecialchars($row['ApellidoMaterno']) . "</td>
                  </tr>";
        }
        echo "</table>";

        // Tabla de Estudiantes Femeninos
        echo "<h3>Estudiantes Femeninos (Total: $count_femeninos)</h3>";
        echo "<table border='1'>";
        echo "<tr>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
              </tr>";

        while ($row = mysqli_fetch_assoc($resultado_femeninos)) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['Nombre']) . "</td>
                    <td>" . htmlspecialchars($row['ApellidoPaterno']) . "</td>
                    <td>" . htmlspecialchars($row['ApellidoMaterno']) . "</td>
                  </tr>";
        }
        echo "</table>";

    } elseif ($formato === 'pdf') {
        require 'fpdf/fpdf.php';

        $pdf = new FPDF('P', 'mm', 'Letter');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);

        // Título del reporte
        $pdf->Cell(0, 10, "Reporte de Estudiantes", 0, 1, 'C');
        $pdf->Ln(5);

        // Estudiantes Masculinos
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(0, 10, "Estudiantes Masculinos (Total: $count_masculinos)", 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 8, "Nombre", 1, 0, 'C');
        $pdf->Cell(45, 8, "Apellido Paterno", 1, 0, 'C');
        $pdf->Cell(45, 8, "Apellido Materno", 1, 0, 'C');
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 10);
        while ($row = mysqli_fetch_assoc($resultado_masculinos)) {
            $pdf->Cell(45, 8, utf8_decode($row['Nombre']), 1);
            $pdf->Cell(45, 8, utf8_decode($row['ApellidoPaterno']), 1);
            $pdf->Cell(45, 8, utf8_decode($row['ApellidoMaterno']), 1);
            $pdf->Ln();
        }

        // Estudiantes Femeninos
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(0, 10, "Estudiantes Femeninos (Total: $count_femeninos)", 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 8, "Nombre", 1, 0, 'C');
        $pdf->Cell(45, 8, "Apellido Paterno", 1, 0, 'C');
        $pdf->Cell(45, 8, "Apellido Materno", 1, 0, 'C');
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 10);
        while ($row = mysqli_fetch_assoc($resultado_femeninos)) {
            $pdf->Cell(45, 8, utf8_decode($row['Nombre']), 1);
            $pdf->Cell(45, 8, utf8_decode($row['ApellidoPaterno']), 1);
            $pdf->Cell(45, 8, utf8_decode($row['ApellidoMaterno']), 1);
            $pdf->Ln();
        }

        $pdf->Output();
    } else {
        die('ERROR: FORMATO INVÁLIDO (XLS O PDF).');
    }
}

if ($reporte === 'profesporgenero') 
{

    // Consulta para obtener los datos de los profesores masculinos
    $consulta_masculinos = "
        SELECT
            p.nombre AS Nombre,
            p.apepat AS ApellidoPaterno,
            p.apemat AS ApellidoMaterno
        FROM Profesor p
        WHERE p.genero = 'Masculino'
    ";

    // Consulta para obtener los datos de los profesores femeninos
    $consulta_femeninos = "
        SELECT
            p.nombre AS Nombre,
            p.apepat AS ApellidoPaterno,
            p.apemat AS ApellidoMaterno
        FROM Profesor p
        WHERE p.genero = 'Femenino'
    ";

    $resultado_masculinos = mysqli_query($conn, $consulta_masculinos);
    $resultado_femeninos = mysqli_query($conn, $consulta_femeninos);

    if (!$resultado_masculinos || !$resultado_femeninos) {
        die('ERROR: No se pudo ejecutar alguna de las consultas de profesores.');
    }

    // Contar los profesores masculinos y femeninos
    $count_masculinos = mysqli_num_rows($resultado_masculinos);
    $count_femeninos = mysqli_num_rows($resultado_femeninos);

    if ($formato === 'xls') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=profesores.xls');
        
        // Tabla de Profesores Masculinos
        echo "<h3>Profesores Masculinos (Total: $count_masculinos)</h3>";
        echo "<table border='1'>";
        echo "<tr>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
              </tr>";

        while ($row = mysqli_fetch_assoc($resultado_masculinos)) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['Nombre']) . "</td>
                    <td>" . htmlspecialchars($row['ApellidoPaterno']) . "</td>
                    <td>" . htmlspecialchars($row['ApellidoMaterno']) . "</td>
                  </tr>";
        }
        echo "</table>";

        // Tabla de Profesores Femeninos
        echo "<h3>Profesores Femeninos (Total: $count_femeninos)</h3>";
        echo "<table border='1'>";
        echo "<tr>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
              </tr>";

        while ($row = mysqli_fetch_assoc($resultado_femeninos)) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['Nombre']) . "</td>
                    <td>" . htmlspecialchars($row['ApellidoPaterno']) . "</td>
                    <td>" . htmlspecialchars($row['ApellidoMaterno']) . "</td>
                  </tr>";
        }
        echo "</table>";

    } 
    elseif ($formato === 'pdf') 
    {
        require 'fpdf/fpdf.php';

        $pdf = new FPDF('P', 'mm', 'Letter');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);

        // Título del reporte
        $pdf->Cell(0, 10, "Reporte de Profesores", 0, 1, 'C');
        $pdf->Ln(5);

        // Profesores Masculinos
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(0, 10, "Profesores Masculinos (Total: $count_masculinos)", 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 8, "Nombre", 1, 0, 'C');
        $pdf->Cell(45, 8, "Apellido Paterno", 1, 0, 'C');
        $pdf->Cell(45, 8, "Apellido Materno", 1, 0, 'C');
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 10);
        while ($row = mysqli_fetch_assoc($resultado_masculinos)) {
            $pdf->Cell(45, 8, utf8_decode($row['Nombre']), 1);
            $pdf->Cell(45, 8, utf8_decode($row['ApellidoPaterno']), 1);
            $pdf->Cell(45, 8, utf8_decode($row['ApellidoMaterno']), 1);
            $pdf->Ln();
        }

        // Profesores Femeninos
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(0, 10, "Profesores Femeninos (Total: $count_femeninos)", 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 8, "Nombre", 1, 0, 'C');
        $pdf->Cell(45, 8, "Apellido Paterno", 1, 0, 'C');
        $pdf->Cell(45, 8, "Apellido Materno", 1, 0, 'C');
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 10);
        while ($row = mysqli_fetch_assoc($resultado_femeninos)) {
            $pdf->Cell(45, 8, utf8_decode($row['Nombre']), 1);
            $pdf->Cell(45, 8, utf8_decode($row['ApellidoPaterno']), 1);
            $pdf->Cell(45, 8, utf8_decode($row['ApellidoMaterno']), 1);
            $pdf->Ln();
        }

        $pdf->Output();
    } 
    else 
    {
        die('ERROR: FORMATO INVÁLIDO (XLS O PDF).');
    }
}

if ($reporte === 'VerPorGrupos') 
{
    $consulta = "
        SELECT 
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
            COUNT(eg.Estudiante_idEstudiante) > 0;
    ";

    $resultado = mysqli_query($conn, $consulta);
    if (!$resultado) {
        die('ERROR: No se pudo ejecutar la consulta.');
    }

    if ($formato === 'xls') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=grupos.xls');

        echo "<table border='1'>";
        echo "<thead>
                <tr>
                    <th>ID Grupo</th>
                    <th>Nombre</th>
                    <th>Generación</th>
                    <th>Total Estudiantes</th>
                </tr>
              </thead><tbody>";

        while ($row = mysqli_fetch_assoc($resultado)) {
            echo "<tr>
                    <td>{$row['idGrupo']}</td>
                    <td>" . htmlspecialchars($row['nombre']) . "</td>
                    <td>" . htmlspecialchars($row['generacion']) . "</td>
                    <td>{$row['total_estudiantes']}</td>
                  </tr>";
        }
        echo "</tbody></table>";
    } 
    elseif ($formato === 'pdf') 
    {
        require 'fpdf/fpdf.php';

        $pdf = new FPDF('P', 'mm', 'Letter');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);

        $pdf->Cell(0, 10, "Reporte de total Estudiantes por Grupo", 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 8, "ID", 1);
        $pdf->Cell(80, 8, "Nombre", 1);
        $pdf->Cell(40, 8, "Generación", 1);
        $pdf->Cell(50, 8, "Total Estudiantes", 1);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 10);
        while ($row = mysqli_fetch_assoc($resultado))
        {
            $pdf->Cell(20, 8, $row['idGrupo'], 1);
            $pdf->Cell(80, 8, utf8_decode($row['nombre']), 1);
            $pdf->Cell(40, 8, utf8_decode($row['generacion']), 1);
            $pdf->Cell(50, 8, $row['total_estudiantes'], 1);
            $pdf->Ln();
        }

        $pdf->Output();
    } 
    else {
        die('ERROR: FORMATO INVÁLIDO (XLS O PDF).');
    }
}

if ($reporte === 'VerPorCarreras') 
{
    $consulta = "
        SELECT 
            c.idCarrera,
            c.clave, 
            c.nombre, 
            COUNT(e.idEstudiante) AS total_estudiantes
        FROM 
            Carrera c
        INNER JOIN 
            Estudiante e ON c.idCarrera = e.Carrera_idCarrera
        GROUP BY 
            c.idCarrera, c.clave, c.nombre
        HAVING 
            COUNT(e.idEstudiante) > 0;
    ";

    $resultado = mysqli_query($conn, $consulta);
    if (!$resultado) {
        die('ERROR: No se pudo ejecutar la consulta.');
    }

    if ($formato === 'xls') 
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=carreras.xls');

        echo "<table border='1'>";
        echo "<thead>
                <tr>
                    <th>ID Carrera</th>
                    <th>Clave</th>
                    <th>Nombre</th>
                    <th>Total Estudiantes</th>
                </tr>
              </thead><tbody>";

        while ($row = mysqli_fetch_assoc($resultado)) 
        {
            echo "<tr>
                    <td>{$row['idCarrera']}</td>
                    <td>{$row['clave']}</td>
                    <td>{$row['nombre']}</td>
                    <td>{$row['total_estudiantes']}</td>
                  </tr>";
        }
        echo "</tbody></table>";
    } 
    elseif ($formato === 'pdf') 
    {
        require 'fpdf/fpdf.php';

        $pdf = new FPDF('P', 'mm', 'Letter');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);

        $pdf->Cell(0, 10, "Reporte de Carreras con Total de Estudiantes", 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 10, "ID Carrera", 1, 0, 'C');
        $pdf->Cell(50, 10, "Clave", 1, 0, 'C');
        $pdf->Cell(70, 10, "Nombre", 1, 0, 'C');
        $pdf->Cell(30, 10, "Total Estudiantes", 1, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        while ($row = mysqli_fetch_assoc($resultado)) {
            $pdf->Cell(40, 10, $row['idCarrera'], 1);
            $pdf->Cell(50, 10, utf8_decode($row['clave']), 1);
            $pdf->Cell(70, 10, utf8_decode($row['nombre']), 1);
            $pdf->Cell(30, 10, $row['total_estudiantes'], 1, 1);
        }

        $pdf->Output();
    } 
    else 
    {
        die('ERROR: FORMATO INVÁLIDO (XLS O PDF).');
    }
}

if ($reporte === 'CalificacionesMaterias')
{
    $consulta = "
        SELECT 
            c.tipo AS Parcial,
            c.periodo AS Periodo,
            m.nombre AS Materia,
            AVG(c.calificacion) AS Promedio,
            MAX(c.calificacion) AS Maxima,
            MIN(c.calificacion) AS Minima
        FROM 
            Calificacion c
        INNER JOIN 
            Materia m ON c.Materia_idMateria = m.idMateria
        GROUP BY 
            c.tipo, c.periodo, m.nombre
        ORDER BY 
            c.periodo, c.tipo, m.nombre;
    ";

    $resultado = mysqli_query($conn, $consulta);
    if (!$resultado) {
        die('ERROR: No se pudo ejecutar la consulta.');
    }

    if ($formato === 'xls') 
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=calificaciones_materias.xls');
        echo "<table border='1'>";
        echo "<thead>
                <tr>
                    <th>Periodo</th>
                    <th>Parcial</th>
                    <th>Materia</th>
                    <th>Promedio</th>
                    <th>Calificación Máxima</th>
                    <th>Calificación Mínima</th>
                </tr>
              </thead>
              <tbody>";

        while ($row = mysqli_fetch_assoc($resultado)) 
        {
            echo "<tr>
                    <td>" . htmlspecialchars($row['Periodo']) . "</td>
                    <td>" . htmlspecialchars($row['Parcial']) . "</td>
                    <td>" . htmlspecialchars($row['Materia']) . "</td>
                    <td>" . number_format($row['Promedio'], 2) . "</td>
                    <td>" . htmlspecialchars($row['Maxima']) . "</td>
                    <td>" . htmlspecialchars($row['Minima']) . "</td>
                  </tr>";
        }
        echo "</tbody></table>";
    } 
    elseif ($formato === 'pdf') 
    {
        require 'fpdf/fpdf.php';

        $pdf = new FPDF('P', 'mm', 'Letter');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);

        $pdf->Cell(0, 10, utf8_decode('Reporte de Calificaciones por Materia, Parcial y Periodo'), 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30, 8, 'Periodo', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Parcial', 1, 0, 'C');
        $pdf->Cell(60, 8, 'Materia', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Promedio', 1, 0, 'C');
        $pdf->Cell(30, 8, utf8_decode('Calif. Máxima'), 1, 0, 'C');
        $pdf->Cell(30, 8, utf8_decode('Calif. Mínima'), 1, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        while ($row = mysqli_fetch_assoc($resultado)) 
        {
            $pdf->Cell(30, 8, utf8_decode($row['Periodo']), 1);
            $pdf->Cell(30, 8, utf8_decode($row['Parcial']), 1);
            $pdf->Cell(60, 8, utf8_decode($row['Materia']), 1);
            $pdf->Cell(30, 8, number_format($row['Promedio'], 2), 1, 0, 'C');
            $pdf->Cell(30, 8, $row['Maxima'], 1, 0, 'C');
            $pdf->Cell(30, 8, $row['Minima'], 1, 1, 'C');
        }

        $pdf->Output();
    } 
    else 
    {
        die('ERROR: FORMATO INVÁLIDO (XLS O PDF).');
    }
}


?>

