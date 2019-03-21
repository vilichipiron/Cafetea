<?php
require_once("../../smarty/libs/Smarty.class.php");
class Pantalla extends Smarty{
	public function __construct() {
		date_default_timezone_set('europe/madrid');
		parent::__construct();
        $camino = "../../pantallas/cafetea";
		$this->template_dir=$camino."/templates/";
		$this->compile_dir=$camino."/templates_c/";
		$this->config_dir=$camino."/configs/";
		$this->cache_dir=$camino."/cache/";
	}
	
	public function mostrar($nombrePantalla, $parametros) {	
        if ($parametros != null) {
            foreach($parametros as $variable => $valor) {
                $this->assign($variable, $valor);
            }
        }
		$this->display($nombrePantalla);
	}
}
?>