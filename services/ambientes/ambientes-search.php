<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require '../../adata/Db.class.php';
require '../../bussiness/ambientes.php';

$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : '1';
$id = isset($_GET['id']) ? $_GET['id'] : '1';
$IdEmpresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : '1';
$IdCentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : '1';
$criterio = (isset($_GET['criterio'])) ? $_GET['criterio'] : '';
$criterio = trim(strip_tags($criterio));
$criterio = preg_replace('/\s+/', ' ', $criterio);
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : '1';

$objData = new clsAmbiente();
$row = $objData->ListarAmbientes($tipobusqueda, $IdEmpresa, $IdCentro, $id, $criterio, $pagina);

echo json_encode($row);
flush();
?>