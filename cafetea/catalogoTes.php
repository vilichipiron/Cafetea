<?php
   
    require_once("Pantalla.class.php");
    require_once("clases/Constantes.class.php");
    require_once("../../seguridad/cafetea-s/Cafeteadb.class.php");

    //Recibe el mensaje si lo hay
    $mensaje = "";
    if (isset($_GET['mensaje'])) {
        $mensaje = trim(strip_tags($_GET['mensaje']));
    }

    $categoria = Constantes::$CATEGORIA_ALL;
    //Recibe la categoria si la hay
    if (isset($_POST['categoria'])) {
        $categoria = trim(strip_tags($_POST['categoria']));
    }

    /*Conexion BBDD*/
    $canal = "";
    $db = new Cafeteadb();
    $db->conectar($canal);

    //Obtiene las categorias existentes del tipo(Cafe,Te o Accesorio) en concreto
    $categorias = $db -> obtenerCategorias($canal, Constantes::$TIPO_TE);

    //Lista los productos
    $productos = $db -> listarProductos($canal, Constantes::$TIPO_TE, $categoria);

    $canal->close();
    
    /*PANTALLA SMARTY*/
    $pantalla = new Pantalla();
    $parametros = array('mensaje'=>$mensaje, 'categorias'=>$categorias);
    if ($categoria != Constantes::$CATEGORIA_ALL) {
        header("Content-type: application/json");
        echo json_encode($productos);
    } else {
        $parametros['productos'] = $productos;   
    }

    $pantalla -> mostrar("catalogoTes.tpl", $parametros); 
?>