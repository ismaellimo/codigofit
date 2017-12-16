<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require '../../adata/Db.class.php';
require '../../bussiness/organigrama.php';

$IdEmpresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : '1';
$IdCentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : '1';
$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : '1';
$idpersonal = isset($_GET['idpersonal']) ? $_GET['idpersonal'] : '0';
$idarea = isset($_GET['idarea']) ? $_GET['idarea'] : '0';
$idcargo = isset($_GET['idcargo']) ? $_GET['idcargo'] : '0';
$criterio = (isset($_GET['criterio'])) ? $_GET['criterio'] : '';
$criterio = trim(strip_tags($criterio));
$criterio = preg_replace('/\s+/', ' ', $criterio);
$turno = isset($_GET['turno']) ? $_GET['turno'] : '00';
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : '1';

$objData = new clsOrganigrama();

$row = $objData->Listar($tipobusqueda, $IdEmpresa, $IdCentro, $idpersonal, $idarea, $idcargo, $criterio, $turno, $pagina);

echo json_encode($row);
flush();
?>