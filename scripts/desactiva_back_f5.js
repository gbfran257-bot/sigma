// JavaScript Document
//begin desabilitar teclas 
document.onkeydown = function(){  
//116->f5 
//122->f11 
if (window.event && (window.event.keyCode == 122 || window.event.keyCode == 116)){
 window.event.keyCode = 505;  
} 

if (window.event.keyCode == 505){  
return false;  
}  

if (window.event && (window.event.keyCode == 8)) 
{ 
valor = document.activeElement.value; 
if (valor==undefined) { return false; } //Evita Back en página. 
else 
{ 
if (document.activeElement.getAttribute('type')=='select-one') 
    { return false; } //Evita Back en select. 
if (document.activeElement.getAttribute('type')=='button') 
    { return false; } //Evita Back en button. 
if (document.activeElement.getAttribute('type')=='radio') 
    { return false; } //Evita Back en radio. 
if (document.activeElement.getAttribute('type')=='checkbox') 
    { return false; } //Evita Back en checkbox. 
if (document.activeElement.getAttribute('type')=='file') 
    { return false; } //Evita Back en file. 
if (document.activeElement.getAttribute('type')=='reset') 
    { return false; } //Evita Back en reset. 
if (document.activeElement.getAttribute('type')=='submit') 
    { return false; } //Evita Back en submit. 
else //Text, textarea o password 
{ 
    if (document.activeElement.value.length==0) 
        { return false; } //No realiza el backspace(largo igual a 0). 
    else 
        { document.activeElement.value.keyCode = 8; } //Realiza el backspace. 
} 
} 
} 
} 
//end desabilitar teclas 