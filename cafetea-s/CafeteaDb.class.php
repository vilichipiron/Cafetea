<?php
class Cafeteadb {
    /*
    * Esta clase recoge algunos metodos para trabajar con la base de datos. 
    */  

    const IP = "127.0.0.1";
    const USUARIO = "cafetea";
    const CLAVE = "cafetea";
    const BD = "cafetea";
    
    public function conectar(&$canal) {
        $canal = new mysqli(self::IP,self::USUARIO,self::CLAVE,self::BD);
        if ($canal->connect_errno) {
            die("Error fatal.");
            return false;
        }
        $canal->set_charset("utf8");
        date_default_timezone_set('Europe/Madrid');
        return true;
    }
    
    public function existeEmail(&$canal, $email) {
        $existe = false;
        
        $consulta = $canal -> prepare("SELECT COUNT(email) FROM usuarios WHERE email = ?");
        if (!$consulta) {
            return false;
            exit;
        }
        
        $consulta->bind_param("s", $email);
        $consulta->execute();
        $consulta->bind_result($rEmails);
        $consulta->store_result();
        
        //Si no devuelve 0 es que existe
        if ($rEmails != 0) {
            $existe = true;
        }
        
        $consulta->close();
        
        return $existe;
     }
    
    public function registrarUsuario(&$canal, $direccion, $email, $pass, $fecha_nacimiento, $nombre, $provincia, $telefono) {
        require_once ("MailManager.Class.php");
        $pass = password_hash($pass, PASSWORD_DEFAULT); //Primero encripta la pass. 
        
        //Inserta el usuario
        $consulta = $canal->prepare("INSERT INTO usuarios (direccion, email, password, fecha_nacimiento, nombre, provincia, telefono) VALUES (?,?,?,?,?,?,?)");
        $consulta->bind_param("sssssss", $direccion, $email, $pass, $fecha_nacimiento, $nombre, $provincia, $telefono);
        $consulta->execute();
        
        if ($consulta->affected_rows == 1) {
            $consulta->close();
            //Si se ha insertado correctamente manda el email de confirmacion. 
            $mailManager = new MailManager();
            if ($mailManager->confirmacionRegistro($email, $nombre)) {
                return true;
            } else {
                return false;
            }
            
        } else {
            $consulta->close();
            return false;
        }
    }  
    
    public function listarProductos(&$canal, $tipo, $categoria="ALL", $filtro=null) {
        require_once("../../www/cafetea/clases/Producto.class.php");
        require_once("../../www/cafetea/clases/Constantes.class.php");
    
        $productos = [];
        
        /******QUERY******/
        $query = "SELECT cod_producto, nombre, tipo, categoria, descripcion, foto, precio FROM productos WHERE tipo = ?";
        
        /*** FALTA AÑADIR FILTRO DE NOMBRE, PRECIO ASC O DESC.***/
        
        if ($categoria !== Constantes::$CATEGORIA_ALL) {
            $query .= " AND categoria = ?";
            $consulta = $canal->prepare($query);
            
            if (!$consulta) {
                return null;
                exit;
            }
            
            $consulta->bind_param("ss", $tipo, $categoria);
        } else {
            $consulta = $canal->prepare($query);
            
            if (!$consulta) {
                return null;
                exit;
            }
            
            $consulta->bind_param("s", $tipo);
        }
        
        $consulta->execute();
        $consulta->bind_result($rCod_producto, $rNombre, $rTipo, $rCategoria, $rDescripcion, $rFoto, $rPrecio);
        $consulta->store_result();
        /******FIN DE QUERY*******/
        
        
        /*Rellena el array de productos*/
        while($consulta->fetch()) {
            array_push($productos, new Producto($rCod_producto, $rNombre, $rTipo, $rCategoria, $rDescripcion, $rFoto, $rPrecio));
        }
        
        $consulta->close();
    
        return $productos;  
    }
    
    public function obtenerCategorias(&$canal, $tipo) {
        $categorias = [];
    
        $consulta = $canal->prepare("SELECT DISTINCT categoria FROM productos WHERE tipo = ?");
        $consulta->bind_param("s", $tipo);
        
        $consulta->execute();
        $consulta->bind_result($rCategoria);
        $consulta->store_result();
        
        while ($consulta->fetch()) {
            array_push($categorias, ucfirst($rCategoria));
        }
        
        $consulta->close();
        
        return $categorias;
    }
}
?>