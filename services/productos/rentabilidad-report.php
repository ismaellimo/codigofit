<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require '../../adata/Db.class.php';
require '../../bussiness/insumos.php';

$IdEmpresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : '1';
$IdCentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : '1';

$idcategoria = isset($_GET['idcategoria']) ? $_GET['idcategoria'] : '0';
$tienreceta = isset($_GET['tienreceta']) ? $_GET['tienreceta'] : '1';
$anho_periodo = isset($_GET['anho_periodo']) ? $_GET['anho_periodo'] : '2017';
$mes_periodo = isset($_GET['mes_periodo']) ? $_GET['mes_periodo'] : '1';


$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : '1';

$objData = new clsInsumo();
$row = $objData->Rentabilidad_Reporte($IdEmpresa, $IdCentro, $idcategoria, $tienreceta, $anho_periodo, $mes_periodo);

echo json_encode($row);
flush();
?>