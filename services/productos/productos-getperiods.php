<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

if ( !isset($_REQUEST['idproducto']) ) {
	exit;
}

require '../../adata/Db.class.php';
require '../../bussiness/productos.php';

$idempresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : '0';
$idcentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : '0';
$idproducto = isset($_GET['idproducto']) ? $_GET['idproducto'] : '0';
$tipomenu = isset($_GET['tipomenu']) ? $_GET['tipomenu'] : '01';

$objData = new clsProducto();
$row = $objData->ListarTiempoPreparacion('1', $idempresa, $idcentro, $idproducto, $tipomenu);

echo json_encode($row);
flush();
?>