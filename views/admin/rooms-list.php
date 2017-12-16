<form id="form1" name="form1" method="post">
    <input type="hidden" name="hdIdEmpresa" id="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>">
    <input type="hidden" name="hdIdCentro" id="hdIdCentro" value="<?php echo $IdCentro; ?>">
    <div class="page-region">
        <div id="pnlListado" class="demo-layout-waterfall mdl-layout mdl-js-layout mdl-layout--fixed-header">
            <header class="mdl-layout__header mdl-layout__header--waterfall">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title"><?php $translate->__('Registro de M&aacute;quinas'); ?></span>
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
                    <div class="gridview">
                        <ul id="nav" class="collapsible popout" data-collapsible="accordion">
                        </ul>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <a id="btnNuevoAmbiente" class="mdl-button mdl-js-button mdl-button--fab animate mdl-js-ripple-effect mdl-button--colored" style="bottom: 45px; right: 24px; position: absolute; z-index: 900;">
        <i class="material-icons">&#xE145;</i>
    </a>
    <div id="modalAmbiente" class="modalseis modal-example-content expand-phone">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Registro de ambientes</span>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <input type="hidden" id="hdIdAmbiente" name="hdIdAmbiente" value="0" />
            <div class="scrollbarra padding20">
                <div class="row">
                    <div class="input-field">
                        <input id="txtCodigoAmbiente" name="txtCodigoAmbiente" type="text" />
                        <label for="txtCodigoAmbiente"><?php $translate->__('C&oacute;digo'); ?></label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field">
                        <input id="txtNombreAmbiente" name="txtNombreAmbiente" type="text" />
                        <label for="txtNombreAmbiente"><?php $translate->__('Nombre de ambiente'); ?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnGuardarAmbiente" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">
                Guardar
            </button>
            <button id="btnLimpiarAmbiente" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect right">
                Limpiar
            </button>
        </div>
    </div>
    <div id="modalMesa" class="modalseis modal-example-content expand-phone">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Registro de M&aacute;quinas</span>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <input type="hidden" id="hdIdMesa" name="hdIdMesa" value="0" />
           <div class="scrollbarra padding10">
                <div class="row">
                    <div class="col-md-4">
                        <p>
                          <input type="checkbox" class="filled-in" id="chkCorrelativoMesa" name="chkCorrelativoMesa" checked value="1" />
                          <label for="chkCorrelativoMesa"><?php $translate->__('Correlativo'); ?></label>
                        </p>
                    </div>
                </div>
                <div class="row no-margin">
                    <div class="col-md-6">
                        <div class="input-field">
                            <input id="txtCodigoMesa" name="txtCodigoMesa" type="text" />
                            <label for="txtCodigoMesa"><?php $translate->__('C&oacute;digo'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-field">
                            <input id="txtNroComensales" name="txtNroComensales" type="number" class="only-numbers" value="1" />
                            <label for="txtNroComensales"><?php $translate->__('Clientes'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="row no-margin hide">
                    <div class="col-md-12">
                        <div class="input-field">
                            <input id="txtNombreMesa" name="txtNombreMesa" type="text" value="" />
                            <label for="txtNombreMesa"><?php $translate->__('Nombre de M&aacute;quina'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnGuardarMesa" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">
                Guardar
            </button>
            <button id="btnLimpiarMesa" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect right">
                Limpiar
            </button>
        </div>
    </div>
    <?php include 'common/generic-actionbar.php'; ?>
</form>