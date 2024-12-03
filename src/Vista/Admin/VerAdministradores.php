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
            $admins = verAdmins(); 
            ?>
           <div class = "carousel"></div>
           <div class = "contenedor">
           
                <table class = "consultas">
                    <thead>
                        <td>Id</td>
                        <td>Nombre</td>
                        <td>Correo</td>
                        <td>Editar</td>
                    </thead>

                    <?php
                    while($row = mysqli_fetch_array($admins))
                    {
                    ?>
                        <tr>
                            <th><?php echo $row['idadmin'] ?></th>
                            <th><?php echo $row['nombre'] ?></th>
                            <th><?php echo $row['correo'] ?></th>
                            <th>
                            <a  class = "imagen" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" x-bind:width="size" x-bind:height="size" viewBox="0 0 24 24" fill="none" width="24" height="24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" x-bind:stroke-width="stroke" stroke="currentColor">
                                    <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4"></path>
                                    <path d="M13.5 6.5l4 4"></path>
                                    <path d="M16 19h6"></path>
                                </svg>

                        </tr>
            <?php   }   ?>
                </table>
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
        header("Location: ../../Controlador/logout.php");
    }

    
?>  