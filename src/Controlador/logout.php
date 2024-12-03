<?php
    require 'control.php';
    session_start();
    session_destroy();
    sleep(.9);
    mostrarlogin();
?>