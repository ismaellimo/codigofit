<?php
require 'bussiness/documentos.php';
require 'bussiness/tabla.php';
require 'bussiness/banco.php';

$objBanco = new clsBanco();
$objDocIdentidad = new clsDocumentos();
$objTabla = new clsTabla();

$rowDocIdentNat = $objDocIdentidad->CodigoTributable('1');
$countRowDocIdentNat = count($rowDocIdentNat);

$rowDocIdentJur = $objDocIdentidad->CodigoTributable('6');
$countRowDocIdentJur = count($rowDocIdentJur);
?>
<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPageGeneral" name="hdPageGeneral" value="1" />
    <input type="hidden" id="hdIdEmpresa" name="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
    <input type="hidden" id="hdIdCentro" name="hdIdCentro" value="<?php echo $IdCentro; ?>" />
    <div class="page-region">
        <div id="pnlListado" class="demo-layout-waterfall mdl-layout mdl-js-layout mdl-layout--fixed-header">
            <main class="mdl-layout__content">
                <div class="page-content">
                    <div id="gvDatos" class="gridview" data-selected="none" data-multiselect="false" data-actionbar="generic-actionbar">
                        <ul class="collection gridview-content">
                        </ul>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <?php include 'common/generic-actionbar.php'; ?>
</form>