<?php
require '../../adata/Db.class.php';
require '../../bussiness/servicios.php';

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

if ( !isset($_REQUEST['id']) ) {
	exit;
}

$row = array(array());

$id = isset($_GET['id']) ? $_GET['id'] : '0';

$objData = new clsServicios();
$row = $objData->Listar('2', 0, 0, $id, '', 0);

if (isset($row))
	echo json_encode($row);
flush();
?>