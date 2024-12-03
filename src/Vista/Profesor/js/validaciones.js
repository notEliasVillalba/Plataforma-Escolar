function validacionContra()
{
    if(document.frm.actual.value.trim().length <= 2) 
    {  
        document.getElementById("actual").focus();
        o.style.display="";
        return false;
    }
    o.style.display="none";
        
    if(document.frm.nueva.value.trim().length <= 2) 
    { 
        document.getElementById("nueva").focus();
        n.style.display="";
        return false;
    }
    n.style.display="none";

    if (document.frm.confirmacion.value.trim() !== document.frm.nueva.value.trim()) 
    {
        document.getElementById("confirmacion").focus();
        con.style.display="";
        return false;
    }
    con.style.display="none";
    
    frm.submit();

}