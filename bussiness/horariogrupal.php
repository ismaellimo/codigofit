<?php
class clshorariogrupal {

	private $objData;
	
	function clshorariogrupal(){
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $Dia, $Idrutina, $Idinstructor, $id, $criterio){
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_horariogrupal_listar', array($tipo, $idempresa, $idcentro, $Dia, $Idrutina, $Idinstructor, $id, $criterio));
		return $rs;
	}

	function Registrar($idhorariogrupal, $idempresa, $idcentro, $Rutina, $Instructor, $Ambiente, $Dia, $HoraInicio, $HoraFinal, $Aforo, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_horariogrupal_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idhorariogrupal, $idempresa, $idcentro, $Rutina, $Instructor, $Ambiente, $Dia, $HoraInicio, $HoraFinal, $Aforo, $idusuario), '@rpta, @titulomsje, @contenidomensaje');
		
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_horariogrupal_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }
}
?>