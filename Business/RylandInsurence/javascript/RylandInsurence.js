//functions for task 
function showOrHideElement(id, status)
{
    if(status == 1)
        $("#"+id).slideDown();
    else
        $("#"+id).slideUp()();
}

//validation fuctions
function validateEmail(Email)
{

    var Epattern = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/
    if(Epattern.test(Email))
    {
       return 2;
    }
    
    return 1;
}

function isBlank(Fieldvalue)
{
    if(Fieldvalue == "")
        return true;
    
    return false;
}

function isAlphabet(textvalue)
{
    var Alphapattern = /^[a-zA-Z ]*$/
    if(Alphapattern.test(textvalue))
        return true;
    
    return false;
}

function MatchPassword(Originalpassword, Confirmpassword)
{
  if(Originalpassword === Confirmpassword)
    return true;
  return false;
}

function OnlyInt(e, errorbox)
{
    if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57))
    {
        $("#"+errorbox).html("Digits Only").show().fadeOut("slow");
        return false;
         
    }
}



