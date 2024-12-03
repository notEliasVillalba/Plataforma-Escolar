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
            $materia = $_POST['idMateria'];
            $mat = verMateriaporID($materia);
            $row = mysqli_fetch_assoc($mat);

            $grupos = verMateriasprofgrup($id, $materia);
?>
            <div class = "carousel"></div>
            <div class = "contenedor">
                <form action="AsignarCalificacion.php" method = 'POST'>
                    <label for="idMateria">Selecciona una materia:</label>
                    <select name="idMateria" id="idMateria" class = "campo">
                        <option value="<?php echo $row['idMateria']?>"><?php echo $row['clave'] . " : " . $row['nombre']?></option>
                    </select>

                    <label for="idGrupo" >Selecciona un grupo:</label>
                    <select class = "campo" name="idGrupo" id="idGrupo">
                    <?php
                        while($rows = mysqli_fetch_array($grupos))
                        {       ?>
                            <option value="<?php echo $rows['idGrupo']?>"><?php echo $rows['nombre'] . ' Generacion : ' . $rows['generacion'] ?></option>
<?php                   }       ?>
                    </select>
                    <button class = "Boton_Registro">Siguiente</button>

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