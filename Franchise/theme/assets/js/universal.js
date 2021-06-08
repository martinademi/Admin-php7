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
        return true;
    }
    return false;
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


