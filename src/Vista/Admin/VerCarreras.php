<?php
    require '../../Controlador/control.php';
    session_start();
    if(isset($_SESSION['id']) && isset($_SESSION['user']))
    {
        $id = $_SESSION['id'];
        $user = $_SESSION['user'];

        
        if(verificaradmin($id, $user))
        {
            if(isset($_GET['idc']) && isset($_GET['op']))
            {
                $idc = $_GET['idc'];
                $op = $_GET['op'];
                switch($op)
                {
                    case 2 :
                        if(carreras_estudiantes($idc) == 0)
                        {
                            eliminarcarrera($idc)
?>  
                            <script>
                                alert('Carrera eliminada exitosamente');
                                window.location.href = 'VerCarreras.php';
                            </script>
                <?php
                        }
                        else
                        {
                ?>
                            <script>
                                alert('No fue posible eliminar la carrera');
                                window.location.href = 'VerCarreras.php';
                            </script>
                <?php            
                        }
                    break;
                }
            }

            include 'includes/header.php';

            $exe = verCarreras();
            if(mysqli_num_rows($exe) > 0)
            {
?>
            <div class="carousel"></div>
            <div class = "contenedor">
                <table class = "consultas">
                    <thead>
                        <td>Id</td>
                        <td>Nombre</td>
                        <td>Clave</td>
                        <td>Editar</td>
                        <td>Eliminar</td>
                    </thead>
<?php
                
                        while($row = mysqli_fetch_array($exe))
                        {
                        
?>
                            <thead>
                                    <th><?php echo $row['idCarrera']?></th>
                                    <th><?php echo $row['nombre']?></th>
                                    <th><?php echo $row['clave']?></th>
                                    <td>
                                        <a class="imagen" href="UpdateCarrera.php?ide=<?php echo $row['idCarrera'];?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" x-bind:width="size" x-bind:height="size" viewBox="0 0 24 24" fill="none" width="24" height="24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" x-bind:stroke-width="stroke" stroke="currentColor">
                                                <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4"></path>
                                                <path d="M13.5 6.5l4 4"></path>
                                                <path d="M16 19h6"></path>
                                            </svg>
                                        </a>
                                    </td>
                                    <td>
                                        <a class = "imagen" href="VerCarreras.php?idc=<?php echo $row['idCarrera']; ?>&op=2">
                                            <svg xmlns="http://www.w3.org/2000/svg" x-bind:width="size" x-bind:height="size" viewBox="0 0 24 24" fill="none" stroke="currentColor" x-bind:stroke-width="stroke" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="2">
                                                <path d="M4 7l16 0"></path>
                                                <path d="M10 11l0 6"></path>
                                                <path d="M14 11l0 6"></path>
                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                            </svg>
                                        </a>
                                    </td>
                            </thead>
<?php
                        }

                        
?>                  
                </table>

                <div>
                    <h1>Reporte Estudiantes por carrera </h1>
                    <a href="../../modelo/convertirpdf/generar_reporte.php?reporte=VerPorCarreras&formato=xls"> Excel
                        <img src="img/excel.png" alt="Exportar a Excel" style="width: 25px; margin-right: 10px;">
                    </a>
                    <a href="../../modelo/convertirpdf/generar_reporte.php?reporte=VerPorCarreras&formato=pdf"> PDF
                        <img src="img/pdf.png" alt="Exportar a PDF" style="width: 25px;">
                    </a>
                </div>
                
            </div>    

<?php       
                       
            }
            else
            {
?>
                <div class="carousel"></div>
                <div class = "contenedor">
                    <h1>Aun no existe ningun registro de carreras</h1>
                    <div>
                        <a href="regCarrera.php">Registrar Carrera</a>
                    </div>
                </div> 
<?php   
            }

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
    
    include 'includes/footer.php';  
?>