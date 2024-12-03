var expreNomyApe = /^[a-zA-ZÀ-ÿ\s]{1,40}$/;
var expreGrupo = /^[a-zA-Z0-9\s\-\_]{3,100}$/;
var expreMateria = /^[a-zA-ZÀ-ÿ0-9\s]{3,100}$/;

//Var para carrera
var expreNomCarrera = /^[a-zA-ZÀ-ÿ\s]{1,100}$/;
var expreClave = /^[a-zA-Z0-9]{2,5}$/;


function validacionEstudiantes() 
{
    if((document.frm.nombre.value.trim().length <= 2) || (!expreNomyApe.test(document.frm.nombre.value)))
    {
     
        document.getElementById("nombre").focus();
        nom.style.display="";
        return false;
    }
    nom.style.display="none";

    if((document.frm.apepat.value.trim().length <= 2 )|| (!expreNomyApe.test(document.frm.apepat.value)))
    {
        
        document.getElementById("apepat").focus();
        app.style.display = "";
        return false;
    }
    app.style.display = "none";

    if(document.frm.apemat.value.trim().length > 0 )
    {
        if( (!expreNomyApe.test(document.frm.apemat.value)) || (document.frm.apemat.value.trim().length <= 2))
        {    
            document.getElementById("apemat").focus();
            apm.style.display="";
            return false;
        }
    }
    apm.style.display ="none";
    if (frm.genero.value === "0") 
    {
        document.getElementById("gen").focus();
        gen.style.display="";
        return false;
    } 
    gen.style.display="none";
    if (frm.fecnac.value === "") 
    {
        frm.fecnac.focus();
        fc.style.display="";
        return false;
    }
    fc.style.display="none";
    if(frm.idCarrera.value === "0" )
    {
        frm.idCarrera.focus();
        c.style.display="";
        return false;
    }
    c.style.display="none";
    

    frm.submit();
}

function validacionProfesor()
{
    if((document.frm.nombre.value.trim().length <= 2) || (!expreNomyApe.test(document.frm.nombre.value)))
    {  
        document.getElementById("nombre").focus();
        nom.style.display="";
        return false;
    }
    nom.style.display="none";
    
    if((document.frm.apepat.value.trim().length <= 2 )|| (!expreNomyApe.test(document.frm.apepat.value)))
    {    
        document.getElementById("apepat").focus();
        app.style.display = "";
        return false;
    }
    app.style.display = "none";
    
    if(document.frm.apemat.value.trim().length > 0 )
    {
        if( (!expreNomyApe.test(document.frm.apemat.value)) || (document.frm.apemat.value.trim().length <= 2))
        {    
            document.getElementById("apemat").focus();
            apm.style.display="";
            return false;
        }
    }
    apm.style.display ="none";

    var fechaNac = new Date(frm.fecnac.value);
    var hoy = new Date();
    var edad = hoy.getFullYear() - fechaNac.getFullYear();
    var mes = hoy.getMonth() - fechaNac.getMonth();
    if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNac.getDate()))
    {
        edad--;
    }

    if (edad < 18 || frm.fecnac.value === "" )
    {
        frm.fecnac.focus();
        fc.style.display="";
        return false;
    }
    fc.style.display="none";
    
    if (frm.genero.value === "0") 
    {
        document.getElementById("gen").focus();
        gen.style.display="";
        return false;
    }     
    gen.style.display="none";

    if(document.frm.vocacion.value.trim().length <= 3 )
    {
        document.getElementById("vocacion").focus();
        v.style.display="";
        return false;
    }
    v.style.display="none";
    frm.submit();
}

function validacionCarrera()
{
    if((document.frm.nombre.value.trim().length <= 2) || (!expreNomCarrera.test(document.frm.nombre.value)))
    {  
        document.getElementById("nombre").focus();
        nom.style.display="";
        return false;
    }
    nom.style.display="none";

    if((document.frm.clave.value.trim().length <= 2) || (!expreClave.test(document.frm.clave.value)))
    {  
        document.getElementById("clave").focus();
        cla.style.display="";
        return false;
    }
    cla.style.display="none";
    frm.submit();
}

function validacionGrupo() 
{
    if ((document.frm.nombre.value.trim().length < 3) || (!expreGrupo.test(document.frm.nombre.value))) {
        document.getElementById("nombre").focus();
        nom.style.display = "";
        return false;
    }
    nom.style.display = "none";

    if ((document.frm.salon.value.trim().length < 2) || (!expreGrupo.test(document.frm.salon.value))) {
        document.getElementById("salon").focus();
        sal.style.display = "";
        return false;
    }
    sal.style.display = "none";

    var expreGeneracion = /^[0-9]{4}$/;
    if ((document.frm.generacion.value.trim().length !== 4) || (!expreGeneracion.test(document.frm.generacion.value))) {
        document.getElementById("generacion").focus();
        gen.style.display = "";
        return false;
    }
    gen.style.display = "none";

    frm.submit();
}

function validacionMateria() 
{
    if ((document.frm.nombre.value.trim().length < 3) || (!expreMateria.test(document.frm.nombre.value))) {
        document.getElementById("nombre").focus();
        document.getElementById("nom").style.display = "";
        return false;
    }
    document.getElementById("nom").style.display = "none";

    if ((document.frm.clave.value.trim().length < 2) || (!expreClave.test(document.frm.clave.value))) {
        document.getElementById("clave").focus();
        document.getElementById("cla").style.display = "";
        return false;
    }
    document.getElementById("cla").style.display = "none";

    if (document.frm.horas.value === "0") {
        document.getElementById("horas").focus();
        document.getElementById("h").style.display = "";
        return false;
    }
    document.getElementById("h").style.display = "none";

    document.frm.submit();
}



function validacionProfesorMateria()
{
    var pro = document.getElementById("pro");
    var gru = document.getElementById("gru");
    var mat = document.getElementById("mat");

    if (frm.idProfesor.value === "0" || frm.idProfesor.value === "")
    {
        document.getElementById("idProfesor").focus();
        pro.style.display = "block";
        return false;
    }
    pro.style.display = "none";

    if (frm.idGrupo.value === "0" || frm.idGrupo.value === "") 
    {
        document.getElementById("idGrupo").focus();
        gru.style.display = "block";
        return false;
    }
    gru.style.display = "none";

    if (frm.idMateria.value === "0" || frm.idMateria.value === "") 
    {
        document.getElementById("idMateria").focus();
        mat.style.display = "block";
        return false;
    }
    mat.style.display = "none";

    frm.submit();
}


function cargarMaterias() {
    var grupo = document.getElementById("grupo").value;
    if (grupo != "0") {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "cargarMaterias.php?grupo=" + grupo, true);
        xhr.onload = function() {
            if (xhr.status == 200) {
                document.getElementById("idMateria").innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    } else {
        document.getElementById("idMateria").innerHTML = "<option value='0'>Selecciona una materia...</option>";
    }
}

// Función para cargar los estudiantes según la materia seleccionada
function cargarEstudiantes()
{
    var materia = document.getElementById("idMateria").value;
    var grupo = document.getElementById("grupo").value;
    if (materia != "0" && grupo != "0") {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "cargarEstudiantes.php?grupo=" + grupo + "&materia=" + materia, true);
        xhr.onload = function() {
            if (xhr.status == 200) {
                document.getElementById("idEstudiante").innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    } else {
        document.getElementById("idEstudiante").innerHTML = "<option value='0'>Selecciona un estudiante...</option>";
    }
}