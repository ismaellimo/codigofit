<?php
ini_set('display_errors', 1);
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
            <a id="btnNuevo" class="mdl-button mdl-js-button mdl-button--fab animate mdl-js-ripple-effect mdl-button--colored" style="bottom: 45px; right: 24px; position: absolute; z-index: 900;">
                <i class="material-icons">&#xE145;</i>
            </a>
        </div>
    </div>
    <div id="pnlForm" class="modal-example-content modaldos expand-phone without-footer">
        <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0" />
        <input type="hidden" id="hdFoto" name="hdFoto" value="no-set" />
        <input type="hidden" id="hdCodigoOri" name="hdCodigoOri" value="0">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">
                        Registro de evaluaci&oacute;n
                    </span>
                    <div class="mdl-layout-spacer"></div>
                    <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Agregar items al detalle" id="btnNuevoDetalle">
                        <i class="material-icons">&#xE145;</i>
                    </button>
                    <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Guardar cambios" id="btnGuardar">
                        <i class="material-icons">&#xE5CA;</i>
                    </button>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <div id="gpFormDetalle" class="generic-panel">
                <div class="gp-header">
                    <div class="row no-margin">
                        <div class="col-sm-3">
                            <div class="input-field full-size">
                                <input class="validate" type="text" id="txtAltura" name="txtAltura" value="0">
                                <label for="txtAltura"><?php $translate->__('Altura'); ?></label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="input-field full-size">
                                <input class="validate" type="text" id="txtPeso" name="txtPeso" value="0">
                                <label for="txtPeso"><?php $translate->__('Peso'); ?></label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="input-field full-size">
                                <input class="validate" type="text" id="txtIMC" name="txtIMC" value="0">
                                <label for="txtIMC"><?php $translate->__('IMC'); ?></label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="input-field full-size">
                                <input class="validate" type="text" id="txtPorcentajeGrasa" name="txtPorcentajeGrasa" value="0">
                                <label for="txtPorcentajeGrasa"><?php $translate->__('Porcentaje de grasa'); ?></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gp-body">
                    <div class="scrollbarra">
                        <div class="row no-margin">
                            <div class="col-md-12">
                                <h5><strong>Detalle de evaluaci&oacute;n</strong></h5>
                            </div>
                        </div>
                        <div id="gvDetalle" class="gridview" data-selected="none" data-multiselect="false" data-actionbar="generic-actionbar">
                            <ul class="collection gridview-content"></ul>
                        </div>
                    </div>
                </div>
                <div class="gp-footer">
                    <div class="row no-margin">
                        <div class="col-md-12">
                            <div class="input-field">
                                <textarea id="txtObservacion_Cabecera"  name="txtObservacion_Cabecera" class="materialize-textarea"></textarea>
                                <label for="txtObservacion_Cabecera">Observaciones</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="pnlRegisterItemDetalle" class="modal-example-content modaluno">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Registro de detalle</span>
                    <div class="mdl-layout-spacer"></div>
                    <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Agregar" id="btnAgregar">
                        <i class="material-icons">&#xE5CA;</i>
                    </button>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <div class="padding20">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="input-field full-size">
                            <select id="ddlZonaCorporal" name="ddlZonaCorporal" style="width: 100%;" class="browser-default">
                                <?php
                                require 'bussiness/zonacorporal.php';
                                $objZona = new clszonacorporal();

                                $rowzona = $objZona->Listar('1', $IdEmpresa, $IdCentro, 0, '');
                                $countZona = count($rowzona);

                                if ($countZona > 0):
                                    for ($i=0; $i < $countZona; ++$i):
                                ?>
                                <option value="<?php echo $rowzona[$i]['tm_idzonacorporal']; ?>">
                                    <?php echo $rowzona[$i]['tm_nombre']; ?>
                                </option>
                                <?php
                                    endfor;
                                endif;
                                ?>
                            </select>
                            <label class="active" for="ddlZonaCorporal"><?php $translate->__('Zona corporal'); ?></label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-field full-size">
                            <input class="validate" type="text" id="txtMedida" name="txtMedida" value="0">
                            <label for="txtMedida"><?php $translate->__('Medida'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-field">
                            <textarea id="txtObservacion_Detalle"  name="txtObservacion_Detalle" class="materialize-textarea"></textarea>
                            <label for="txtObservacion_Detalle">Observaciones</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'common/generic-actionbar.php'; ?>
</form>