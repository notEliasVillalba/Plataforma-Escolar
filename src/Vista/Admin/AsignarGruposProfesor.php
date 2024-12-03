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
                $idProfesor  = $_POST['idProfesor'];
                $idMateria = $_POST['idMateria'];
                $idGrupo = $_POST['idGrupo'];

                if(registrarProfesorGrupo($idProfesor,$idMateria,$idGrupo))
                {
?>
                    <script>
                        alert('Grupo asignado exitosamente');
                        window.location.href = 'VerMatGruProf.php';
                    </script>
<?php
                }
                else
                {
?>
                    <script>
                        alert('No se pudo realizar la operacion');
                        window.location.href = 'index.php';
                    </script>
<?php
                }
            }


            $profesores = verProfesores();
            $grupos = verGrupos();
            $materias = verMaterias();
            include 'includes/header.php';
?>          
            <div class = "carousel"></div>
            <div class = "contenedor">
                <form action="AsignarGruposProfesor.php" name = "frm" id = "frm" method = 'POST'>
                    <label for="idProfesor">Selecciona un profesor:</label>
                    <select class = "campo" name="idProfesor" id="idProfesor">
                        <option value="0">Seleccione a un profesor.....</option>
                    <?php
                        while($row = mysqli_fetch_array($profesores))
                        { 
                    ?>
                            <option value="<?php echo $row['idProfesor']?>"><?php echo $row['nombre'] . ' '. $row['apepat'] . ' ' . $row['apemat']?></option>
                    <?php
                        }
                    ?>
                    </select>
                    <p class = "alert alert-danger" id = "pro" name = "pro" style="display: none;">Ingresa un profesor...</p>
                    <label for="idGrupo">Selecciona un grupo:</label>
                    <select class = "campo" name="idGrupo" id="idGrupo">
                        <option value="0">Seleccione un grupo.....</option>
                    <?php
                        while($row = mysqli_fetch_array($grupos))
                        { 
                    ?>
                            <option value="<?php echo $row['idGrupo']?>"><?php echo $row['nombre'] . ' Generacion '. $row['generacion']?></option>
                    <?php
                        }
                    ?>        
                    </select>
                    <p class = "alert alert-danger" id = "gru" name = "gru" style="display: none;">Ingresa un grupo...</p>
                    <label for="idMateria">Selecciona una materia:</label>
                    <select class = "campo" name="idMateria" id="idMateria">
                        <option value="0">Seleccione una materia.....</option>
                    <?php
                        while($row = mysqli_fetch_array($materias))
                        { 
                    ?>
                            <option value="<?php echo $row['idMateria']?>"><?php echo $row['clave'] . ': '. $row['nombre']?></option>
                    <?php
                        }
                    ?>        
                    </select>
                    <p class = "alert alert-danger" id = "mat" name = "mat" style="display: none;">Ingresa una materia...</p>
                    <input class = "Boton_Registro" value = "Registrar" type="button" onclick="validacionProfesorMateria();">

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
        header("Location: ../../Controlador/logout.php");
    }
?>    