
$(document).ready(function(){

$("#contactForm").submit(function () {  
    if($("#contactNameField").val().length < 0) {  
        alert("El nombre debe tener como mínimo 5 caracteres");  
        return false;  
    }  
    return false;  
}); 
 });
