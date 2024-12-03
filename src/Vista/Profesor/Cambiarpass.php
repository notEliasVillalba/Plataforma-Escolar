<?php
    require '../../Controlador/control.php';
    session_start();
    if(isset($_SESSION['id']) && isset($_SESSION['user']))
    {

        $id = $_SESSION['id'];
        $user = $_SESSION['user'];
        if(comprobarprofesor($user,$id))
        {
            include 'includes/header.php';
            
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