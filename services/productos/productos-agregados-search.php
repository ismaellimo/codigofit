<?php
require '../../adata/Db.class.php';
require '../../bussiness/productos.php';

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

$row = array(array());

$IdEmpresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : '0';
$IdCentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : '0';
$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : '1';
$tipomenudia = isset($_GET['tipomenudia']) ? $_GET['tipomenudia'] : '';
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');

$objProducto = new clsProducto();

$row = $objProducto->ListarArticulosAgregados($tipobusqueda, $IdEmpresa, $IdCentro, $tipomenudia, $fecha);

if (isset($row))
	echo json_encode($row);
flush();
?>