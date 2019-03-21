<?php
/*
* Este script se llama cuando se registraun usuario.
*/

require_once("../../seguridad/cafetea-s/Cafeteadb.class.php");
if (!isset($_POST["nombre"]) || !isset($_POST["email"]) || !isset($_POST["pass"]) || !isset($_POST["rep_pass"]) || !isset($_POST["fecha_nacimiento"]) || !isset($_POST["telefono"]) || !isset($_POST["provincia"]) || !isset($_POST["direccion"])) {
    header("Location: registro.php");
    exit;
}

$nombre = trim(strip_tags($_POST["nombre"]));
$email = trim(strip_tags($_POST["email"]));
$pass = trim(strip_tags($_POST["pass"]));
$repPass = trim(strip_tags($_POST["rep_pass"]));
$fecha_nacimiento = trim(strip_tags($_POST["fecha_nacimiento"]));
$telefono = trim(strip_tags($_POST["telefono"]));
$provincia = trim(strip_tags($_POST["provincia"]));
$direccion = trim(strip_tags($_POST["direccion"]));

/*Conexion BBDD*/
$canal = "";
$db = new Cafeteadb();
$db->conectar($canal);

/*Si el usuario es menor a 18 años, no deja registrarse*/
$f_nacimiento = new DateTime($fecha_nacimiento);
$hoy = new DateTime(date("Y-m-d H:i:s"));
$interval = $f_nacimiento->diff($hoy);
if ($interval->y < 18) {
    echo "No tienes 18.";
    header("Location: registro.php");
    exit;
}

/*Comprueba si el email ya existe*/
if ($db->existeEmail($canal, $email)) {
    echo "El email existe.";
    header("Location: registro.php?mensaje=".urlencode("El email ya existe. Por favor, introduzca otro."));
    exit;
}

/*Comprueba si las contraseñas coinciden*/
if (strcmp($pass, $repPass) !== 0) {
    echo "Las contras no coinciden.";
    header("Location: registro.php");
    exit;
}

/* 
* Inserta el usuario en la base de datos. 
* El metodo registrarUsuario se encarga de que se mande confirmacion al email. 
*/

if ($db->registrarUsuario($canal, $direccion, $email, $pass, $fecha_nacimiento, $nombre, $provincia, $telefono)) {
    echo "Registrado!";
} else {
    echo "Error";
}

$canal->close();
?>
