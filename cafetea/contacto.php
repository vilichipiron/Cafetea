<?php
    require_once("Pantalla.class.php");

    //Recibe el mensaje si lo hay
    $mensaje = "";
    if (isset($_GET['mensaje'])) {
        $mensaje = trim(strip_tags($_GET['mensaje']));
    }

    /*PANTALLA SMARTY*/
    $pantalla = new Pantalla();
    $parametros = array('mensaje'=>$mensaje);
    $pantalla -> mostrar("contacto.tpl", $parametros);
?>