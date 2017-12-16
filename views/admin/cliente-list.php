<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdIdEmpresa" name="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
    <input type="hidden" id="hdIdCentro" name="hdIdCentro" value="<?php echo $IdCentro; ?>" />
    <div class="page-region">
        <div id="pnlListado" class="demo-layout-waterfall mdl-layout mdl-js-layout mdl-layout--fixed-header">
            <header class="mdl-layout__header mdl-layout__header--waterfall">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Socios</span>
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
                    <span class="mdl-layout-title">Socios</span>
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
                                    <input class="validate" type="text" id="txtnroDNI" name="txtnroDNI">
                                    <label for="txtnroDNI">DNI</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p>
                                        <input type="radio" name="rbSexo" id="rbSexo__Masculino" value="1">
                                        <label for="rbSexo__Masculino">Masculino</label>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p>
                                        <input type="radio" name="rbSexo" id="rbSexo__Femenino" value="2">
                                        <label for="rbSexo__Femenino">Femenino</label>
                                    </p>
                                </div>
                            </div>    
                            <div class="row">
                                <div class="input-field full-size">
                                    <input class="validate" type="text" id="txtFechaNacimiento" name="txtFechaNacimiento">
                                    <label for="txtFechaNacimiento">Fecha de Nacimiento</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <input class="validate" type="text" id="txtNombres" name="txtNombres">
                                    <label for="txtNombres"><?php $translate->__('Nombres'); ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <input class="validate" type="text" id="txtApellidos" name="txtApellidos">
                                    <label for="txtApellidos"><?php $translate->__('Apellidos'); ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <input class="validate" type="text" id="txtUbigeo" name="txtUbigeo">
                                    <label for="txtUbigeo"><?php $translate->__('Ubigeo'); ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <input class="validate" type="text" id="txtDireccion" name="txtDireccion">
                                    <label for="txtDireccion"><?php $translate->__('Dirección'); ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <input class="validate" type="text" id="txtTelefono" name="txtTelefono">
                                    <label for="txtTelefono"><?php $translate->__('Telefono fijo'); ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <input class="validate" type="text" id="txtCelular" name="txtCelular">
                                    <label for="txtCelular"><?php $translate->__('Celular'); ?></label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field full-size">
                                    <input class="validate" type="text" id="txtEmail" name="txtEmail">
                                    <label for="txtEmail"><?php $translate->__('Email'); ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <input class="validate" type="text" id="txtFacebook" name="txtFacebook">
                                    <label for="txtFacebook"><?php $translate->__('Facebook'); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="pnlDetalleCliente" class="modal-example-content modaldos expand-phone without-footer without-header">
        <div class="modal-example-body">
            <div id="tabDetalleCliente" class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect all-height">
                <a class="close-dialog mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon place-top-left margin10">
                    <i class="material-icons">&#xE14C;</i>
                </a>
                <div class="mdl-tabs__tab-bar">
                    <a href="#asistenciacliente" class="mdl-tabs__tab">Asistencia</a>
                    <a href="#clasescliente" class="mdl-tabs__tab">Clases</a>
                    <a href="#evaluacioncliente" class="mdl-tabs__tab">Evaluaci&oacute;n</a>
                    <a href="#rutinacliente" class="mdl-tabs__tab">Rutinas</a>
                    <a href="#dietacliente" class="mdl-tabs__tab">Dietas</a>
                </div>
                <div class="mdl-tabs__panel" id="asistenciacliente">
                    <div class="mdl-tabs__panel-content">
                    </div>
                </div>
                <div class="mdl-tabs__panel" id="clasescliente">
                    <div class="mdl-tabs__panel-content">
                    </div>
                </div>
                <div class="mdl-tabs__panel" id="evaluacioncliente">
                    <div class="mdl-tabs__panel-content">
                    </div>
                </div>
                <div class="mdl-tabs__panel" id="rutinacliente">
                    <div class="mdl-tabs__panel-content">
                    </div>
                </div>
                <div class="mdl-tabs__panel" id="dietacliente">
                    <div class="mdl-tabs__panel-content">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'common/generic-actionbar.php'; ?>
</form>