<?php
class clsProducto
{
	private $objData;
	
	function clsProducto()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $idcategoria, $idsubcategoria, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_producto_listar', array($tipo, $idempresa, $idcentro, $idcategoria, $idsubcategoria, $id, $criterio, $pagina));
		return $rs;
	}

	function Registrar($idproducto, $idempresa, $idcentro, $nombre, $idcategoria, $idsubcategoria, $foto, $precioVenta, $precioCompra, $idusuario, &$rpta, &$titulomsje, &$contenidomensaje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_producto_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idproducto, $idempresa, $idcentro, $nombre, $idcategoria, $idsubcategoria, $foto, $precioVenta, $precioCompra, $idusuario), '@rpta, @titulomsje, @contenidomsje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomsje'];
		return $rpta;
	}

	function MultiDelete($listIds)
	{
		$bd = $this->objData;
		$rpta = 0;
		$rpta = $bd->set_update(array('Activo' => '0'), 'tm_producto', "tm_idproducto IN ($listIds)");
		return $rpta;
	}

	function ToogleState($iditem, $state)
	{
		$bd = $this->objData;
		$rpta = 0;
		$rpta = $bd->set_update(array('Activo' => $state), 'tm_producto', "tm_idproducto = $iditem");
		return $rpta;
	}

	function RegistrarTiempoPreparacion($idproducto, $tipomenudia, $tiempo)
	{
		$bd = $this->objData;
		$sp_name = 'pa_producto_preparacion_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idproducto, $tipomenudia, $tiempo), '@rpta');
		$rpta = $result[0]['@rpta'];
		return $rpta;
	}

	function ListarTiempoPreparacion($tipo, $idempresa, $idcentro, $idproducto, $tipomenu)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_producto_preparacion_listar', array($tipo, $idempresa, $idcentro, $idproducto, $tipomenu));
		return $rs;
	}

	function ListarPrecios($tipo, $idempresa, $idcentro, $idproducto, $tipomenu)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_precio_articulo_listar', array($tipo, $idempresa, $idcentro, $idproducto, $tipomenu));
		return $rs;
	}

	function ListarArticulosAgregados($tipo, $idempresa, $idcentro, $tipomenudia, $fecha)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_producto_agregados_listar', array($tipo, $idempresa, $idcentro, $tipomenudia, $fecha));
		return $rs;
	}

	function CalcularPorciones($idempresa, $idcentro, $idproducto, $tipomenudia, $nroporciones, $idusuario, &$rpta, &$titulomsje, &$contenidomensaje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_producto_avgporcion_calcular';
		$result = $bd->exec_sp_iud($sp_name, array($idempresa, $idcentro, $idproducto, $tipomenudia, $nroporciones, $idusuario), '@rpta, @titulomsje, @contenidomsje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomsje'];
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_producto_eliminar_stepbystep';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }

    function Rentabilidad_Report()
    {
    	$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_stock_programado_reporte', array($idempresa, $idcentro, $fechaini, $fechafin, $pagina));
		return $rs;
    }

    function ListarParaAsignar($tipo, $idempresa, $idcentro, $idcategoria, $idsubcategoria, $id, $tipomenudia, $fecha, $criterio, $pagina)
    {
    	$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_producto_asignar_listar', array($tipo, $idempresa, $idcentro, $idcategoria, $idsubcategoria, $id, $tipomenudia, $fecha, $criterio, $pagina));
		return $rs;
    }

    function checkNombre($nombre, $idregistro, $idempresa, $idcentro)
    {
    	$bd = $this->objData;
		$condicion = "tm_nombre = '".$nombre."' AND tm_idempresa = ".$idempresa." AND ".$idcentro." AND tm_idproducto <> " . $idregistro;
		$tabla = 'tm_producto';
		$campos = 'tm_idproducto';
		$rs = $bd->set_select($campos, $tabla, $condicion);
		return $rs;
    }
}
?>