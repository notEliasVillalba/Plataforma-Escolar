<?php
    require '../../Controlador/control.php';
    session_start();
    if(isset($_SESSION['id']) && isset($_SESSION['user']))
    {
        $id = $_SESSION['id'];
        $user = $_SESSION['user'];
        if(verificaradmin($id, $user))
        {
            $acciones = obteneracciones();
            include 'includes/header.php';
            if(mysqli_num_rows($acciones) > 0)
            {
?>
                <div class="carousel"></div>
                <div class = "contenedor">
                            <table class = "consultas">
                            <thead>
                                <th>ID</th>
                                <th>Accion</th>
                                <th>Fecha y Hora</th>
                            </thead>
<?php
                            while($rows = mysqli_fetch_array($acciones))
                            {
?>

                                <thead>
                                    <th><?php echo $rows['idaccion']?></th>
                                    <th><?php echo $rows['accion']?></th>
                                    <th><?php echo $rows['fecha']?></th>
                                </thead>
<?php
                            }

?>
                        </table>
                    
                </div>
<?php   
            }
            else
            {
                echo"<h1>No hay registros</h1>";
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