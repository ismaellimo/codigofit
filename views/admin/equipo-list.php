<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdIdEmpresa" name="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
    <input type="hidden" id="hdIdCentro" name="hdIdCentro" value="<?php echo $IdCentro; ?>" />
    <div class="page-region">
        <div id="pnlListado" class="demo-layout-waterfall mdl-layout mdl-js-layout mdl-layout--fixed-header">
            <header class="mdl-layout__header mdl-layout__header--waterfall">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Equipos</span>
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
    <div id="pnlForm" class="modal-example-content modaldos expand-phone without-footer">
        <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0" />
        <input type="hidden" id="hdFoto" name="hdFoto" value="no-set" />
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Equipo</span>
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
            <div class="flex-grid all-height">
                <div class="row all-height pos-rel form-photo no-margin">
                    <div class="cell colspan6 all-height header-on-phone">
                        <div class="pos-rel padding10 all-height">
                            <?php include 'common/component-photo.php'; ?>
                        </div>
                    </div>
                    <div class="cell colspan6 all-height body-on-phone no-footer mdl-shadow--4dp">
                        <div class="scrollbarra padding20">
                            <div class="row">
                                <div class="input-field full-size">
                                    <input class="validate" type="text" id="txtNombre" name="txtNombre" require>
                                    <label for="txtNombre">Nombre de Equipo</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-field">
                                        <select name="ddlAmbiente" id="ddlAmbiente" class="browser-default">
                                        </select>
                                        <label class="active" for="ddlAmbiente"><?php $translate->__('Ambiente'); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-field">
                                        <select name="ddlZonacorporal" id="ddlZonacorporal" class="browser-default">
                                        </select>
                                        <label class="active" for="ddlZonacorporal"><?php $translate->__('Zonacorporal'); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <input class="validate" type="text" id="txtCodigo" name="txtCodigo">
                                    <label for="txtCodigo"><?php $translate->__('Código'); ?></label>
                                </div>
                            </div>  
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-field">
                                        <select name="ddlTipoEquipo" id="ddlTipoEquipo" class="browser-default">
                                            <?php
                                            require 'bussiness/tabla.php';
                                            $objTabla = new clsTabla();

                                            $rowTipoEquipo = $objTabla->ValorPorCampo('ta_tipo_equipo');
                                            $countRowTipoEquipo = count($rowTipoEquipo);

                                            if ($countRowTipoEquipo > 0):
                                                for ($i=0; $i < $countRowTipoEquipo; ++$i):
                                            ?>
                                            <option value="<?php echo $rowTipoEquipo[$i]['ta_codigo']; ?>">
                                                <?php echo $rowTipoEquipo[$i]['ta_denominacion']; ?>
                                            </option>
                                            <?php
                                                endfor;
                                            endif;
                                            ?>
                                        </select>
                                        <label class="active" for="ddlTipoEquipo"><?php $translate->__('Tipo de Equipo'); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <input class="validate" type="text" id="txtCantidad" name="txtCantidad">
                                    <label for="txtCantidad"><?php $translate->__('Cantidad'); ?></label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field full-size">
                                    <input class="validate" type="text" id="txtVideo" name="txtVideo">
                                    <label for="txtVideo"><?php $translate->__('Video'); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'common/generic-actionbar.php'; ?>
</form>