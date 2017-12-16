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
                        Registro de Rutina
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
                                <input class="validate" type="text" id="txtImcActual" name="txtImcActual" value="0">
                                <label for="txtImcActual"><?php $translate->__('ImcActual'); ?></label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="input-field full-size">
                                <input class="validate" type="text" id="txtImcMeta" name="txtImcMeta" value="0">
                                <label for="txtImcMeta"><?php $translate->__('ImcMeta'); ?></label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="input-field full-size">
                                <input class="validate" type="text" id="txtFechaInicio" name="txtFechaInicio" value="0">
                                <label for="txtFechaInicio"><?php $translate->__('FechaInicio'); ?></label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="input-field full-size">
                                <input class="validate" type="text" id="txtFechaFinal" name="txtFechaFinal" value="0">
                                <label for="txtFechaFinal"><?php $translate->__('FechaFinal'); ?></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gp-body">
                    <div class="scrollbarra">
                        <div class="row no-margin">
                            <div class="col-md-12">
                                <h5><strong>Detalle de Rutina</strong></h5>
                            </div>
                        </div>
                        <div id="gvDetalle" class="gridview" data-selected="none" data-multiselect="false" data-actionbar="generic-actionbar">
                            <ul class="collection gridview-content"></ul>
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
                    <span class="mdl-layout-title">Registro de rutina</span>
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
                    <div class="col-md-12">
                        <div class="input-field">
                            <textarea id="txtDetalle"  name="txtDetalle" class="materialize-textarea"></textarea>
                            <label for="txtDetalle">Detalle del ejercicio</label>
                        </div>
                    </div>
                </div>
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
                            <select id="ddlequipo" name="ddlequipo" style="width: 100%;" class="browser-default">
                                <?php
                                require 'bussiness/equipo.php';
                                $objequipo = new clsEquipo();

                                $rowequipo = $objequipo->Listar('1', $IdEmpresa, $IdCentro, 0, '',0);
                                $countequipo = count($rowequipo);

                                if ($countequipo > 0):
                                    for ($i=0; $i < $countequipo; ++$i):
                                ?>
                                <option value="<?php echo $rowequipo[$i]['tm_idequipo']; ?>">
                                    <?php echo $rowequipo[$i]['tm_nombre']; ?>
                                </option>
                                <?php
                                    endfor;
                                endif;
                                ?>
                            </select>
                            <label class="active" for="ddlequipo"><?php $translate->__('Equipo o Accesorio'); ?></label>
                        </div>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-sm-4">
                            <div class="input-field full-size">
                                <input class="validate" type="text" id="txtSeries" name="txtSeries" value="0">
                                <label for="txtSeries"><?php $translate->__('Series'); ?></label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-field full-size">
                                <input class="validate" type="text" id="txtRepeticiones" name="txtRepeticiones" value="0">
                                <label for="txtRepeticiones"><?php $translate->__('Repeticiones'); ?></label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-field full-size">
                                <input class="validate" type="text" id="txtPeso" name="txtPeso" value="0">
                                <label for="txtPeso"><?php $translate->__('Peso (Kgs.)'); ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'common/generic-actionbar.php'; ?>
</form>