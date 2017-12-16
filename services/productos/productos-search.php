<?php
require '../../adata/Db.class.php';
require '../../bussiness/productos.php';
////require '../../bussiness/precios.php';
////require '../../bussiness/cartadia.php';

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

$row = array(array());

$IdEmpresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : '1';
$IdCentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : '1';

$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : '00';
$idcategoria = isset($_GET['idcategoria']) ? $_GET['idcategoria'] : '0';
$idsubcategoria = isset($_GET['idsubcategoria']) ? $_GET['idsubcategoria'] : '0';
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : '0';
$criterio = (isset($_GET['criterio'])) ? $_GET['criterio'] : '';
$criterio = trim(strip_tags($criterio));
$criterio = preg_replace('/\s+/', ' ', $criterio);
///$fecha = isset($_GET['fecha']) ? $_GET['fecha']: date('Y-m-d');
///$idgrupo = isset($_GET['idgrupo']) ? $_GET['idgrupo']: '0';
///$idorden = isset($_GET['idorden']) ? $_GET['idorden']: '0';
///$estadoapertura = isset($_GET['estadoapertura']) ? $_GET['estadoapertura']: '0';

$objProducto = new clsProducto();

	$row = $objProducto->Listar('1', $IdEmpresa, $IdCentro, $idcategoria, $idsubcategoria, 0, $criterio, $pagina);

echo json_encode($row);
flush();
?>