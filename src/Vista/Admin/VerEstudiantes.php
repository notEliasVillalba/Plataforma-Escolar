<?php
    require '../../Controlador/control.php';
    session_start();
    if(isset($_SESSION['id']) && isset($_SESSION['user']))
    {
        
        $id = $_SESSION['id'];
        $user = $_SESSION['user'];
        if(verificaradmin($id, $user))
        {
            if(isset($_GET['ide']) && isset($_GET['op']))
            {
                $idp = $_GET['ide'];
                $op = $_GET['op'];
                switch($op)
                {
                    case 2 :
                        if(deleteEstudiante($idp))
                        {
?>
                            <script>
                                alert('Estudiante eliminado exitosamente');
                                window.location.href = 'VerEstudiantes.php';
                            </script>
<?php
                        }
                        else
                        {
?>
                            <script>
                                alert('No fue posible eliminar al Estudiante');
                                window.location.href = 'VerEstudiantes.php';
                            </script>
<?php  
                        }
                    break;
                }
            }
            
            include 'includes/header.php';

            $estudiantes = verEstudiantes();
            if(mysqli_num_rows($estudiantes) > 0)
            {
?>
            <div class="carousel"></div>
            <div class = "contenedor">
                <table class = "consultas">
                    <thead>
                        <td>Id</td>
                        <td>Nombre</td>
                        <td>Apellido Paterno</td>
                        <td>Apellido Materno</td>
                        <td>Fecha de Nacimiento</td>
                        <td>Genero</td>
                        <td>Matricula</td>
                        <td>Carrera</td>
                        <td>Fecha de Ingreso</td>
                        <td>Correo</td>
                        <td>Contraseña</td>
                        <td>Editar</td>
                        <td>Eliminar</td>
                    </thead>
<?php
                
                        while($row = mysqli_fetch_array($estudiantes))
                        {
?>
                        <thead>
                                <th><?php echo $row['idEstudiante']?></th>
                                <th><?php echo $row['nombre']?></th>
                                <th><?php echo $row['apepat']?></th>
                                <th><?php echo $row['apemat']?></th>
                                <th><?php echo $row['fechanac']?></th>
                                <th><?php echo $row['genero']?></th>
                                <th><?php echo $row['matricula']?></th>
                                <th><?php echo $row['n_Carrera']?></th>
                                <th><?php echo $row['fecingreso']?></th>
                                <th><?php echo $row['correo']?></th>
                                <th><?php echo $row['contrasena']?></th>

                                <td>
                                    <a class="imagen" href="UpdateEstudiantes.php?ide=<?php echo $row['idEstudiante'];?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" x-bind:width="size" x-bind:height="size" viewBox="0 0 24 24" fill="none" width="24" height="24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" x-bind:stroke-width="stroke" stroke="currentColor">
                                            <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4"></path>
                                            <path d="M13.5 6.5l4 4"></path>
                                            <path d="M16 19h6"></path>
                                         </svg>
                                    </a>
                                </td>

                                <td>
                                    <a class = "imagen" href="VerEstudiantes.php?ide=<?php echo $row['idEstudiante']?> &op=2">
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
                    <h1>Reporte Estudiantes por genero </h1>
                    <a href="../../modelo/convertirpdf/generar_reporte.php?reporte=estudiantesporgenero&formato=xls"> Excel
                        <img src="img/excel.png" alt="Exportar a Excel" style="width: 25px; margin-right: 10px;">
                    </a>
                    <a href="../../modelo/convertirpdf/generar_reporte.php?reporte=estudiantesporgenero&formato=pdf"> PDF
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

                <div class="contenedor">
                    <div class="contenedor">
                        <h3>Aun no existe ningun registro de estudiante</h3>
                        <p>Comienza por registrar a un estudiante</p>
                        <a href="GestionEstudiantes.php" class="boton">Registrar Estudiante</a>
                    </div>
                </div>
<?php   
            }
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

