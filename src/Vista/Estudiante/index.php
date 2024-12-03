<?php
    require '../../Controlador/control.php';
    session_start();

    if(isset($_SESSION['id']) && isset($_SESSION['user'])) {
        $id = $_SESSION['id'];
        $user = $_SESSION['user'];

        if(verificarestudiante($id, $user)) 
        {
            $info = infoEstudiante($id) ;
            $informacionEstudiante = mysqli_fetch_array($info);

            include 'includes/header.php';
?>
            <div class="carousel"></div>

            <div class="contenedor-info">
                <div class="info-usuario">
                    <h3>Información del Estudiante</h3>
                    <p><strong>Nombre:</strong> <?php echo $informacionEstudiante['nombre']; ?></p>
                    <p><strong>Apellido Paterno:</strong> <?php echo $informacionEstudiante['apepat']; ?></p>
                    <p><strong>Apellido Materno:</strong> <?php echo $informacionEstudiante['apemat']; ?></p>
                    <p><strong>Fecha de Nacimiento:</strong> <?php echo $informacionEstudiante['fechanac']; ?></p>
                    <p><strong>Género:</strong> <?php echo $informacionEstudiante['genero']; ?></p>
                    <p><strong>Matrícula:</strong> <?php echo $informacionEstudiante['matricula']; ?></p>
                    <p><strong>Carrera:</strong> <?php echo $informacionEstudiante['n_Carrera']; ?></p>
                    <p><strong>Correo:</strong> <?php echo $informacionEstudiante['correo']; ?></p>
                </div>
                <div class="foto-usuario">
                    <img src="img/usuario.png" alt="Foto del usuario" />
                </div>
            </div>


            <div class="contenedor">
                <div>
                    <h1>Calificaciones</h1>
                    <a href="VerCalificacion.php">Kardex</a>
                </div>
                <div>
                    <h1>Contraseña</h1>
                    <a href="cambiarContraseña.php">Cambiar contraseña</a>
                </div>
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
        mostrarlogin();
    }
?>
