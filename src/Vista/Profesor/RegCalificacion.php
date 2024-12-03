<?php
    require '../../Controlador/control.php';
    session_start();
    if(isset($_SESSION['id']) && isset($_SESSION['user']))
    {

        $id = $_SESSION['id'];
        $user = $_SESSION['user'];
        if(comprobarprofesor($user,$id))
        {
            $materias = materiadeprofe($id);
            include 'includes/header.php';


?>          <div class = "carousel"></div>
            <div class = "contenedor">
                <form action="RegCalificacion_2.php" method = 'POST'>
                    <label for="idMateria">Selecciona una materia</label>
                    <select class="campo" name="idMateria" id="idMateria">
                    <?php
                        while($row = mysqli_fetch_array($materias))
                        {
                    ?>      <option value= "<?php echo $row['id_materia']?>" ><?php echo $row['clave_materia'] . " : " . $row['nombre_materia']?></option>
                <?php   }  ?>
                    </select>

                    <button class = "Boton_Registro">Siguiente</button>
                </form>
            </div>
            
<?php
            include 'includes/footer.php';
?>
            
<?php           
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