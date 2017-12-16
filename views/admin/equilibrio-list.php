<?php
        require 'bussiness/tabla.php';
        $objTabla = new clsTabla();
?>
<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdIdEmpresa" name="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
    <input type="hidden" id="hdIdCentro" name="hdIdCentro" value="<?php echo $IdCentro; ?>" />
    <div class="page-region">
        <div id="pnlListado" class="demo-layout-waterfall mdl-layout mdl-js-layout mdl-layout--fixed-header">
            <header class="mdl-layout__header mdl-layout__header--waterfall">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Metas Institucionales</span>
                    <div class="mdl-layout-spacer"></div>
                    <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnSearch" data-type="search">
                        <i class="material-icons">&#xE8B6;</i>
                    </button>
                    <button type="button" class="btnOpciones mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnOpciones">
                        <i class="material-icons">&#xE5D4;</i>
                    </button>
                </div>
            </header>
            <?php include 'common/droplist-generic.php'; ?>
            <div class="control-inner-app mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D2;</i>
                </a>
            </div>
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
    <div id="pnlForm" class="modal-example-content modaluno expand-phone without-footer">
        <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0" />
        <input type="hidden" id="hdFoto" name="hdFoto" value="no-set" />
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Metas Institucionales</span>
                    <div class="mdl-layout-spacer"></div>
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
            <div class="scrollbarra padding20">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-field">
                            <select name="ddlmes" id="ddlmes" class="browser-default">
                                <?php
                                $rowmes = $objTabla->ValorPorCampo_Ordenado('ta_mes', 'ta_codigo', 'ASC');
                                $countRowmes = count($rowmes);

                                if ($countRowmes > 0):
                                    for ($i=0; $i < $countRowmes; ++$i):
                                ?>
                                <option value="<?php echo $rowmes[$i]['ta_codigo']; ?>">
                                    <?php echo $rowmes[$i]['ta_denominacion']; ?>
                                </option>
                                <?php
                                    endfor;
                                endif;
                                ?>
                            </select>
                            <label class="active" for="ddlmes"><?php $translate->__('Mes a evaluar'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-field">
                            <select name="ddlanno" id="ddlanno" class="browser-default">
                                <?php
                                $rowanno = $objTabla->ValorPorCampo('ta_anno');
                                $countRowanno = count($rowanno);

                                if ($countRowanno > 0):
                                    for ($i=0; $i < $countRowanno; ++$i):
                                ?>
                                <option value="<?php echo $rowanno[$i]['ta_codigo']; ?>">
                                    <?php echo $rowanno[$i]['ta_denominacion']; ?>
                                </option>
                                <?php
                                    endfor;
                                endif;
                                ?>
                            </select>
                            <label class="active" for="ddlanno"><?php $translate->__('Año a Evaluar'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="input-field full-size">
                            <input class="validate" type="number" id="txtServicios" name="txtServicios" require>
                            <label for="txtServicios">Gastos de Servicios del periodo</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-field full-size">
                            <input class="validate" type="number" id="txtSueldos" name="txtSueldos">
                            <label for="txtSueldos"><?php $translate->__('Gastos de sueldos'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="input-field full-size">
                            <input class="validate" type="number" id="txtotros" name="txtotros">
                            <label for="txtotros"><?php $translate->__('Otros gastos'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-field full-size">
                            <input class="validate" type="number" id="txtutilidad" name="txtutilidad">
                            <label for="txtutilidad"><?php $translate->__('Utilidad mínima (%)'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'common/generic-actionbar.php'; ?>
</form>