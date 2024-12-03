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
            <div class="carousel"></div>

            <div class="contenedor">

                <div>
                    <h1>Reporte Estudiantes por genero </h1>
                    <a href="../../modelo/convertirpdf/generar_reporte.php?reporte=estudiantesporgenero&formato=xls"> Excel
                        <img src="img/excel.png" alt="Exportar a Excel" style="width: 25px; margin-right: 10px;">
                    </a>
                    <a href="../../modelo/convertirpdf/generar_reporte.php?reporte=estudiantesporgenero&formato=pdf"> PDF
                        <img src="img/pdf.png" alt="Exportar a PDF" style="width: 25px;">
                    </a>
                </div>

                <div>
                    <h1>Reporte Profesores por Genero</h1>
                    <a href="../../modelo/convertirpdf/generar_reporte.php?reporte=profesporgenero&formato=xls"> Excel
                        <img src="img/excel.png" alt="Exportar a Excel" style="width: 25px; margin-right: 10px;">
                    </a>
                    <a href="../../modelo/convertirpdf/generar_reporte.php?reporte=profesporgenero&formato=pdf"> PDF
                        <img src="img/pdf.png" alt="Exportar a PDF" style="width: 25px;">
                    </a>
                </div>

                <div>
                    <h1>Reporte Estudiantes por carrera </h1>
                    <a href="../../modelo/convertirpdf/generar_reporte.php?reporte=VerPorCarreras&formato=xls"> Excel
                        <img src="img/excel.png" alt="Exportar a Excel" style="width: 25px; margin-right: 10px;">
                    </a>
                    <a href="../../modelo/convertirpdf/generar_reporte.php?reporte=VerPorCarreras&formato=pdf"> PDF
                        <img src="img/pdf.png" alt="Exportar a PDF" style="width: 25px;">
                    </a>
                </div>

                <div>
                    <h1>Reporte Calificacion materias</h1>
                    <a href="../../modelo/convertirpdf/generar_reporte.php?reporte=CalificacionesMaterias&formato=xls"> Excel
                        <img src="img/excel.png" alt="Exportar a Excel" style="width: 25px; margin-right: 10px;">
                    </a>
                    <a href="../../modelo/convertirpdf/generar_reporte.php?reporte=CalificacionesMaterias&formato=pdf"> PDF
                        <img src="img/pdf.png" alt="Exportar a PDF" style="width: 25px;">
                    </a>
                </div>

                <div>
                    <h1>Reporte Estudiantes por grupo </h1>
                    <a href="../../modelo/convertirpdf/generar_reporte.php?reporte=VerPorGrupos&formato=xls"> Excel
                        <img src="img/excel.png" alt="Exportar a Excel" style="width: 25px; margin-right: 10px;">
                    </a>
                    <a href="../../modelo/convertirpdf/generar_reporte.php?reporte=VerPorGrupos&formato=pdf"> PDF
                        <img src="img/pdf.png" alt="Exportar a PDF" style="width: 25px;">
                    </a>
                </div>



            </div>
        

<?php
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

<?php include 'includes/footer.php'; ?>