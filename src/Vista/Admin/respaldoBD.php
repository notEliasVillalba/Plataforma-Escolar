
<?php
require '../../Controlador/control.php';
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user'])) {
    $id = $_SESSION['id'];
    $user = $_SESSION['user'];
    if (verificaradmin($id, $user)) {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['backup'])) 
        {
            $exe = respaldoBase();
            if ($exe == false) 
            {
                echo "<script>
                        alert('Error al realizar el respaldo de la base de datos');
                        window.location.href = 'respaldoBD.php';
                      </script>";
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['restore'])) 
        {
            if (isset($_FILES['archivo_respaldo']) && $_FILES['archivo_respaldo']['error'] === UPLOAD_ERR_OK)
            {
                $archivoTemporal = $_FILES['archivo_respaldo']['tmp_name'];
                $resultado = restaurarBase($archivoTemporal);

                if ($resultado === true) 
                {
                    echo "<script>
                            alert('Base de datos restaurada con éxito');
                            window.location.href = 'respaldoBD.php';
                        </script>";
                } 
                else 
                {
                    echo "<script>
                            alert('Error al restaurar la base de datos. Detalles: " . addslashes($resultado) . "');
                            window.location.href = 'respaldoBD.php';
                        </script>";
                }
            } 
            else 
            {
                echo "<script>
                        alert('Error al subir el archivo de respaldo.');
                        window.location.href = 'respaldoBD.php';
                    </script>";
            }
        }

        include 'includes/header.php';
?>

            <div class="carousel"></div>

            <div class="contenedor-respaldo">
                <div>
                    <h2>Realizar respaldo</h2>
                    <form method="post" action="respaldoBD.php">
                        Se descargara un archivo SQL que incluye la base de datos y todos sus registros.
                        <button type="submit" name="backup" class="btn-backup">Realizar Respaldo</button>
                    </form>
                </div>

                <div>
                    <h2>Restaurar la base de datos</h2>
                    <form method="post" action="respaldoBD.php" enctype="multipart/form-data">
                        Se necesita seleccionar un archivo SQL donde se incluya el respaldo de la base de datos.
                        <input type="file" name="archivo_respaldo" accept=".sql" required>
                        <button type="submit" name="restore" class="btn-restore">Restaurar Base de Datos</button>
                    </form>
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


