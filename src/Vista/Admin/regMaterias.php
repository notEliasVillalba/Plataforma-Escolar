<?php
    require '../../Controlador/control.php';
    session_start();
    if(isset($_SESSION['id']) && isset($_SESSION['user']))
    {
        $id = $_SESSION['id'];
        $user = $_SESSION['user'];
        if(verificaradmin($id, $user))
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                $nombre = $_POST['nombre'];
                $clave = $_POST['clave'];
                $horas = $_POST['horas'];

                if(regMateria($nombre, $clave, $horas))
                {
?>  
                    <script>
                        alert('Materia registrada exitosamente');
                        window.location.href = 'index.php';
                    </script>
<?php
                }
                else
                {
?>  
                    <script>
                        alert('No se pudo registrar la materia');
                        window.location.href = 'index.php';
                    </script>
<?php
                }
            }
            
            include 'includes/header.php';

?>
            <div class="carousel"></div>
            <div class = "contenedor">
                <form name = "frm" id = "frm" action = "regMaterias.php" method = 'POST' >
                    <label for="nombre">Nombre de la materia:</label>
                    <input class = "campo" type="text" name = "nombre" id = "nombre">
                    <p class = "alert alert-danger" id = "nom" name = "nom" style="display: none;">Ingresa un nombre valido!!!</p>

                    <label for="clave">Clave:</label>
                    <input class = "campo" type="text" name = "clave" id = "clave">
                    <p class = "alert alert-danger" id = "cla" name = "cla" style="display: none;">Ingresa una clave valida!!!</p>

                    <label for="horas">Horas Semanales:</label>
                    <select class = "campo" name="horas" id="horas">
                        <option value="0">Ingresa un numero...</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                    </select>
                    <p class = "alert alert-danger" id = "h" name = "h" style = "display: none;">Ingresa un numero de horas!!!</p>
                    <input class = "Boton_Registro" value = "Registrar" type="button" onclick="validacionMateria();"></input>
                </form>
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

