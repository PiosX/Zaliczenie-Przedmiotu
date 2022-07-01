function showBut(){
    var but1 = document.getElementById("profile-edit");
    var but2 = document.getElementById("save-changes");
    var but3 = document.getElementById("upload-image");
    if(!but2.style.display || but2.style.display == "none")
    {
        but1.style.display = "none";
        but2.style.display = "block";
        but3.style.display = "block";
    }
    else
    {
        but1.style.display = "block";
        but2.style.display = "none";
        but3.style.display = "none";
    }
}

function closeDiv()
{
    var div = document.getElementById("shadow-log");
    if(!div.style.display || div.style.display == "none")
    {
        div.style.display = "block";
    }
    else
    {
        div.style.display = "none";
    }
}

function switchReg()
{
    var reg = document.getElementById("reg-form");
    var log = document.getElementById("login-form");
    var ani = document.getElementById("ani-reg");
    var reg_inf = document.getElementById("reg-inf");
    var log_inf = document.getElementById("log-inf");

    if(!reg.style.display || reg.style.display == "none")
    {
        log.style.display = "none";
        log_inf.style.display= "none";
        reg_inf.style.display = "block";
        ani.style.display = "block";
        reg.style.display = "block";  
    }
    else
    {
        reg.style.display = "none";
        ani.style.display = "none";
        log.style.display = "block";
        log_inf.style.display= "block";
        reg_inf.style.display = "none";
    }
}

function checkWatch()
{
    var but = document.getElementById("confirm-cont");

    if (!but.style.display || but.style.display == "none")
    {
        but.style.display="block";
        check = 'f';
    } 
    else
    {
        but.style.display="none";
        check = 't';
    }
}