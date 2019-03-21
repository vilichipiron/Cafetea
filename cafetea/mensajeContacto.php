<?php
require_once("../../seguridad/cafetea-s/MailManager.class.php");

//Recoge los datos
if (!isset($_POST["nombre"]) || !isset($_POST["email"]) || !isset($_POST["asunto"]) || !isset($_POST["mensaje"])) {
    header("Location: contacto.php");
    exit;
}

if (!isset($_POST["numeropedido"]) || $_POST["numeropedido"] == "") {
    $numeroPedido = "No indicado";
} else {
    $numeroPedido = trim(strip_tags($_POST["numeropedido"]));
}

$nombre = trim(strip_tags($_POST["nombre"]));
$email = trim(strip_tags($_POST["email"]));
$asunto = trim(strip_tags($_POST["asunto"]));
$mensaje = trim(strip_tags($_POST["mensaje"]));

//Manda el email
$mailManager = new MailManager();

if ($mailManager->correoContacto($nombre, $email, $asunto, $mensaje, $numeroPedido)) {
    echo "Se ha enviado correctamente";
    header("Location: contacto.php?mensaje=".urlencode("Se ha enviado tu mensaje. Recibirás la respuesta en tu correo."));
} else {
    echo "Errr2";
    header("Location: contacto.php?mensaje=".urlencode("Lo sentimos. Se ha producido un error."));
}
?>