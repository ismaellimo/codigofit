<?php
include('bussiness/categoria.php');

$IdEmpresa = 1;
$IdCentro = 1;

$counterCategoria = 0;
// $counterUM = 0;
// $counterArea = 0;

$objCategoria = new clsCategoria();

$rowCategoria = $objCategoria->Listar('3', $IdEmpresa, $IdCentro, '0',  '', 0);
$countRowCategoria = count($rowCategoria);

?>
<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdIdEmpresa" name="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
    <input type="hidden" id="hdIdCentro" name="hdIdCentro" value="<?php echo $IdCentro; ?>" />
    <div class="page-region">
        <div id="pnlListado" class="demo-layout-waterfall mdl-layout mdl-js-layout mdl-layout--fixed-header">
            <header class="mdl-layout__header mdl-layout__header--waterfall">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Productos</span>
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
                    <span class="mdl-layout-title">Producto</span>
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
                                    <input class="validate" type="text" id="txtNombreProducto" name="txtNombreProducto">
                                    <label for="txtNombreProducto"><?php $translate->__('Nombre'); ?></label>
                                </div>
                            </div>
                           <div class="row margin-bottom-20">
                                <div class="input-field full-size">
                                    <select id="ddlCategoriaReg" name="ddlCategoriaReg" style="width: 100%;" class="browser-default">
                                        <?php
                                        if ($countRowCategoria > 0):
                                            for ($counterCategoria=0; $counterCategoria < $countRowCategoria; $counterCategoria++):
                                        ?>
                                        <option value="<?php echo $rowCategoria[$counterCategoria]['tm_idcategoria']; ?>"><?php echo $rowCategoria[$counterCategoria]['tm_nombre']; ?></option>
                                        <?php
                                            endfor;
                                        endif;
                                        ?>
                                    </select>
                                    <label class="active" for="ddlCategoriaReg"><?php $translate->__('Categor&iacute;a'); ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <input class="validate" type="text" id="txtPrecioVenta" name="txtPrecioVenta">
                                    <label for="txtPrecioVenta"><?php $translate->__('Precio Venta'); ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <input class="validate" type="text" id="txtPrecioCompra" name="txtPrecioCompra">
                                    <label for="txtPrecioCompra"><?php $translate->__('Precio Compra'); ?></label>
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