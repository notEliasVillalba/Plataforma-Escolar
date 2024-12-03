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
                $idg = $_GET['ide'];
                $op = $_GET['op'];
                switch($op)
                {
                    case 2 :
                        if(deleteGrupo($idg))
                        {
?>
                            <script>
                                alert('Grupo eliminado exitosamente');
                                window.location.href = 'VerGrupos.php';
                            </script>
<?php
                        }
                        else
                        {
?>
                            <script>
                                alert('No fue posible eliminar al Grupo');
                                window.location.href = 'VerGrupos.php';
                            </script>
<?php  
                        }
                    break;
                }
            }
            
            include 'includes/header.php';

            $grupos = verGrupos(); 
            if(mysqli_num_rows($grupos) > 0)
            {
?>
            <div class="carousel"></div>
            <div class = "contenedor">
                <table class = "consultas">
                    <thead>
                        <td>Id</td>
                        <td>Nombre</td>
                        <td>Salón</td>
                        <td>Generación</td>
                        <td>Editar</td>
                        <td>Eliminar</td>
                    </thead>

                    <tbody>
<?php
                        while($row = mysqli_fetch_array($grupos))
                        {
?>
                        <tr>
                            <th><?php echo $row['idGrupo']?></th>
                            <th><?php echo $row['nombre']?></th>
                            <th><?php echo $row['salon']?></th>
                            <th><?php echo $row['generacion']?></th>
                            <td>
                                <a class = "imagen" href="UpdateGrupo.php?idg=<?php echo $row['idGrupo']; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" x-bind:width="size" x-bind:height="size" viewBox="0 0 24 24" fill="none" width="24" height="24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" x-bind:stroke-width="stroke" stroke="currentColor">
                                        <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4"></path>
                                        <path d="M13.5 6.5l4 4"></path>
                                        <path d="M16 19h6"></path>
                                    </svg>
                                </a>
                            </td>
                            <td>
                                <a class = "imagen" href="VerGrupos.php?ide=<?php echo $row['idGrupo']; ?>&op=2" onclick="return confirm('¿Estás seguro de eliminar este grupo?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" x-bind:width="size" x-bind:height="size" viewBox="0 0 24 24" fill="none" stroke="currentColor" x-bind:stroke-width="stroke" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="2">
                                        <path d="M4 7l16 0"></path>
                                        <path d="M10 11l0 6"></path>
                                        <path d="M14 11l0 6"></path>
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                    </svg>
                                </a> 
                            </td>
                        </tr>
<?php
                        }
?>
                    </tbody>
                </table>

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
?>
                <div class="carousel"></div>
                
                <div class="contenedor">
                    <div class="contenedor">
                        <h3>Aun no existe ningun registro de grupo</h3>
                        <p>Comienza por registrar a un grupo</p>
                        <a href="GestionGrupos.php" class="boton">Registrar Grupo</a>
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
