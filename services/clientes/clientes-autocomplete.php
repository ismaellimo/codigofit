<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require '../../adata/Db.class.php';
require '../../bussiness/clientes.php';

$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : '1';
$IdEmpresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : '1';
$IdCentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : '1';
$tipocliente = isset($_GET['tipocliente']) ? $_GET['tipocliente'] : 'NA';
$pagina = isset($_GET['page']) ? $_GET['page'] : '1';

$criterio = (isset($_GET['criterio'])) ? $_GET['criterio'] : '';
$criterio = trim(strip_tags($criterio));
$criterio = preg_replace('/\s+/', ' ', $criterio);

$objData = new clsCliente();

$row = $objData->Listar($tipobusqueda, $IdEmpresa, $IdCentro, 0, $tipocliente, $criterio, $pagina);
// $countrow = count($row);

// $response = array();
// $response['items'] = $row;
// $response['total_count'] = $countrow;

echo json_encode($row);
flush();
?>