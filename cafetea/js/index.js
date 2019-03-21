$(document).ready(function () {
    /*
    * Event listeners
    */
    
    //Boton registro
    $("#registrarme").click(function() {
        irRegistro();
    });
    
    //Boton login
    $("#login").click(function() {
        irLogin();
    });
});

function irRegistro() {
    window.location.replace("registro.php");
}

function irLogin() {
    window.location.replace("login.php");
}