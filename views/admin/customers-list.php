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
    <div id="pnlForm" class="modal-example-content modaldos expand-phone">
        <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0" />
        <input type="hidden" id="hdFoto" name="hdFoto" value="no-set" />
        <input type="hidden" id="hdCodigoOri" name="hdCodigoOri" value="0">
        <input type="hidden" id="hdTipoCliente" name="hdTipoCliente" value="NA">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">
                        <a class="waves-effect waves-light indigo no-shadow white-text padding10 dropbutton-material" id="btnTipoCliente"><i class="material-icons right">&#xE5C5;</i><span class="text">Cliente natural</span></a>
                    </span>
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
        <ul id="mnuTipoCliente" class="dropdown dropdown-sites">
            <li><a href="#tabNatural" data-tipocliente="NA">Cliente natural</a></li>
            <li><a href="#tabJuridico" data-tipocliente="JU">Cliente jur&iacute;dico</a></li>
        </ul>
        <div class="modal-example-body">
            <div class="flex-grid all-height">
                <div class="row all-height pos-rel form-photo no-margin">
                    <div class="cell colspan6 all-height header-on-phone">
                        <div class="pos-rel padding10 all-height">
                            <?php include 'common/component-photo.php'; ?>
                        </div>
                    </div>
                    <div class="cell colspan6 all-height body-on-phone no-footer z-depth-2">
                        <section id="tabNatural" class="scrollbarra padding20">
                            <div class="row">
                                <div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label full-size">
                                    <select id="ddlTipoDocNatural" name="ddlTipoDocNatural" class="mdl-selectfield__select full-size">
                                        <?php
                                        for ($i=0; $i < $countRowDocIdentNat; $i++):
                                        ?>
                                        <option value="<?php echo $rowDocIdentNat[$i]['tm_iddocident']; ?>">
                                            <?php $translate->__($rowDocIdentNat[$i]['tm_descripcion']); ?>
                                        </option>
                                        <?php
                                        endfor;
                                        ?>
                                    </select>
                                    <label for="ddlTipoDocNatural" class="mdl-selectfield__label"><?php $translate->__('Tipo de documento'); ?></label>
                                    <span class="mdl-selectfield__error">Input is not a empty!</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <input class="validate" type="text" id="txtNroDocNatural" name="txtNroDocNatural">
                                    <label for="txtNroDocNatural"><?php $translate->__('Documento de identidad'); ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <input class="validate" type="text" id="txtApePaterno" name="txtApePaterno">
                                    <label for="txtApePaterno"><?php $translate->__('Apellido paterno'); ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <input class="validate" type="text" id="txtApeMaterno" name="txtApeMaterno">
                                    <label for="txtApeMaterno"><?php $translate->__('Apellido materno'); ?></label>
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
                                    <input class="validate" type="text" id="txtDireccionNatural" name="txtDireccionNatural">
                                    <label for="txtDireccionNatural"><?php $translate->__('Direcci&oacute;n'); ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <input class="validate" type="text" id="txtTelefonoNatural" name="txtTelefonoNatural">
                                    <label for="txtTelefonoNatural"><?php $translate->__('Tel&eacute;fono'); ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <input class="validate" type="text" id="txtEmailNatural" name="txtEmailNatural">
                                    <label for="txtEmailNatural"><?php $translate->__('Email'); ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <select id="ddlPaisNatural" name="ddlPaisNatural" class="browser-default">
                                    <?php echo loadOpcionSel("tp_pais", "Activo=1", "tp_idpais", "tp_nombre", "", "", "tp_codigo DESC"); ?>
                                    </select>
                                    <label for="ddlPaisNatural" class="active"><?php $translate->__('Pa&iacute;s'); ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <select id="ddlRegionNatural" name="ddlRegionNatural" class="browser-default">
                                    </select>
                                    <label for="ddlRegionNatural" class="active"><?php $translate->__('Regi&oacute;n'); ?></label>
                                </div>
                            </div>
                        </section>
                        <section id="tabJuridico" class="scrollbarra hide padding20">
                            <div class="row">
                                <div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label full-size">
                                    <select id="ddlTipoDocJuridica" name="ddlTipoDocJuridica" class="mdl-selectfield__select full-size">
                                        <?php
                                        for ($i=0; $i < $countRowDocIdentJur; $i++):
                                        ?>
                                        <option value="<?php echo $rowDocIdentJur[$i]['tm_iddocident']; ?>">
                                            <?php $translate->__($rowDocIdentJur[$i]['tm_descripcion']); ?>
                                        </option>
                                        <?php
                                        endfor;
                                        ?>
                                    </select>
                                    <label for="ddlTipoDocJuridica" class="mdl-selectfield__label"><?php $translate->__('Tipo de documento'); ?></label>
                                    <span class="mdl-selectfield__error">Input is not a empty!</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <input class="validate" type="text" id="txtRucEmpresa" name="txtRucEmpresa">
                                    <label for="txtRucEmpresa"><?php $translate->__('N&uacute;mero de contribuyente'); ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <input class="validate" type="text" id="txtRazonSocial" name="txtRazonSocial">
                                    <label for="txtRazonSocial"><?php $translate->__('Raz&oacute;n Social'); ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <input class="validate" type="text" id="txtDireccionEmpresa" name="txtDireccionEmpresa">
                                    <label for="txtDireccionEmpresa"><?php $translate->__('Direcci&oacute;n'); ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <input class="validate" type="text" id="txtTelefonoEmpresa" name="txtTelefonoEmpresa">
                                    <label for="txtTelefonoEmpresa"><?php $translate->__('Tel&eacute;fono'); ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <input class="validate" type="text" id="txtEmailEmpresa" name="txtEmailEmpresa">
                                    <label for="txtEmailEmpresa"><?php $translate->__('Email'); ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <input class="validate" type="text" id="txtWebEmpresa" name="txtWebEmpresa">
                                    <label for="txtWebEmpresa"><?php $translate->__('P&aacute;gina web'); ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <select id="ddlPaisEmpresa" name="ddlPaisEmpresa" class="browser-default">
                                        <?php echo loadOpcionSel("tp_pais", "Activo=1", "tp_idpais", "tp_nombre", "", "", "tp_codigo DESC"); ?>
                                    </select>
                                    <label for="ddlPaisEmpresa" class="active"><?php $translate->__('Pa&iacute;s'); ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <select id="ddlRegionEmpresa" name="ddlRegionEmpresa" class="browser-default">
                                    </select>
                                    <label for="ddlRegionEmpresa" class="active"><?php $translate->__('Regi&oacute;n'); ?></label>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer grey lighten-2">
            <p>
              <input type="checkbox" class="filled-in" name="chkCrearUsuario" id="chkCrearUsuario" checked />
              <label for="chkCrearUsuario">Crear usuario</label>
            </p>
        </div>
    </div>
    <div id="modalUploadExcel" class="modal-dialog modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Importar datos
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid">
                <div class="row text-center">
                    <div class="droping-air mode-file">
                        <input type="file" class="file-import">
                        <div class="icon"></div>
                        <div class="help">
                            Seleccione o arrastre un archivo de Excel
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="progress-bar large" data-role="progress-bar" data-value="0" data-color="bg-cyan"></div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span6">
                        <button id="btnSubirDatos" type="button" disabled="" class="command-button disabled">Iniciar subida</button>
                    </div>
                    <div class="span6">
                        <button id="btnCancelarSubida" type="button" class="command-button danger">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="pnlLineaCredito" class="modal-example-content modaldos without-footer">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">L&iacute;neas de cr&eacute;dito de <span id="lblCliente"></span></span>
                    <div class="mdl-layout-spacer"></div>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <div class="scrollbarra">
                <div id="tableLineaCredito" class="pos-rel all-height" data-selected="none" data-multiselect="false">
                    <div class="table-responsive-vertical shadow-z-1 all-height">
                        <table class="table table-bordered table-hover mdl-shadow--2dp all-height no-margin">
                            <thead>
                                <tr>
                                    <th class="align-center">#</th>
                                    <th class="align-center"><?php $translate->__('Registro'); ?></th>
                                    <th class="align-center"><?php $translate->__('Cr&eacute;dito'); ?></th>
                                    <th class="align-center"><?php $translate->__('Consumo'); ?></th>
                                    <th class="align-center"><?php $translate->__('Pagado'); ?></th>
                                    <th class="align-center"><?php $translate->__('Saldo'); ?></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="empty_state hide">
                         <div class="empty_state__container">
                            <div class="empty_state__content">
                                <i class="material-icons md-64">&#xE25C;</i>
                                <h1>Sin l&iacute;nea de cr&eacute;dito</h1>
                                <p>No hay l&iacute;nea de cr&eacute;dito asociada a este cliente</p>
                                <br>
                                <button id="btnGenerarLineaCredito" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--raised mdl-button--colored center-block">
                                    Generar l&iacute;nea de cr&eacute;dito
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="pnlDetalleLineaCredito" class="modal-example-content modalcuatro-xl without-footer">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Detalle de l&iacute;nea</span>
                    <div class="mdl-layout-spacer"></div>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <div class="scrollbarra">
                <div id="tableLineaDetalleCredito" class="pos-rel all-height" data-selected="none" data-multiselect="false">
                    <div class="table-responsive-vertical shadow-z-1 all-height">
                        <table class="table table-bordered table-hover mdl-shadow--2dp all-height no-margin">
                            <thead>
                                <tr>
                                    <th class="align-center">#</th>
                                    <th class="align-center"><?php $translate->__('Registro'); ?></th>
                                    <th class="align-center"><?php $translate->__('Inicio'); ?></th>
                                    <th class="align-center"><?php $translate->__('Vencimiento'); ?></th>
                                    <th class="align-center"><?php $translate->__('Importe Mora'); ?></th>
                                    <th class="align-center"><?php $translate->__('Importe deuda'); ?></th>
                                    <th class="align-center"><?php $translate->__('Importe cancelado'); ?></th>
                                    <th class="align-center"><?php $translate->__('Saldo'); ?></th>
                                    <th class="align-center"><?php $translate->__('Estado deuda'); ?></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="empty_state hide">
                         <div class="empty_state__container">
                            <div class="empty_state__content">
                                <i class="material-icons">&#xE420;</i>
                                <h1>Sin deudas por cobrar</h1>
                                <p>No hay deudas asociadas a este cliente.</p>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="pnlCobroDeuda" class="modal-example-content modaluno expand-phone">
        <input type="hidden" id="hdIdDeudaCobrar" name="hdIdDeudaCobrar" value="0" />
        <input type="hidden" id="hdImagenVoucher" name="hdImagenVoucher" value="no-set" />
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Cobro de deuda</span>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="input-field">
                        <select name="ddlTipoOperacion" id="ddlTipoOperacion" class="browser-default">
                            <?php
                            $rsTipoOperacion = $objTabla->Listar('BY-FIELD', 'ta_tipo_operacion');
                            $countTipoOperacion = count($rsTipoOperacion);
                            
                            if ($countTipoOperacion > 0):
                                for ($i=0; $i < $countTipoOperacion; ++$i):
                            ?>
                            <option value="<?php echo $rsTipoOperacion[$i]['ta_codigo']; ?>">
                                <?php echo $rsTipoOperacion[$i]['ta_denominacion']; ?>
                            </option>
                            <?php
                                endfor;
                            endif;
                            ?>
                        </select>
                        <label class="active" for="ddlTipoOperacion"><?php $translate->__('Tipo Operaci&oacute;n'); ?></label>
                    </div>
                </div>
            </div>
            <div class="row rowOperacion hide">
                <div class="col-md-4">
                    <div class="input-field">
                        <select name="ddlBanco" id="ddlBanco" class="browser-default">
                            <?php
                            $rsBanco = $objBanco->Listar('1', 0, '', 0);
                            $countBanco = count($rsBanco);
                            
                            if ($countBanco > 0):
                                for ($i=0; $i < $countBanco; ++$i):
                            ?>
                            <option value="<?php echo $rsBanco[$i]['tm_idbanco']; ?>">
                                <?php echo $rsBanco[$i]['tm_nombre']; ?>
                            </option>
                            <?php
                                endfor;
                            endif;
                            ?>
                        </select>
                        <label class="active" for="ddlBanco"><?php $translate->__('Banco'); ?></label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-field">
                        <input id="txtNroCuentaBancaria" name="txtNroCuentaBancaria" type="text"  value="" placeholder="" />
                        <label for="txtNroCuentaBancaria"><?php $translate->__('N&uacute;mero de Cuenta Bancaria'); ?></label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-field">
                        <input id="txtNroOperacion" name="txtNroOperacion" type="text"  value="" placeholder="" />
                        <label for="txtNroOperacion"><?php $translate->__('&uacute;mero de Operaci&oacute;n'); ?></label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group required no-margin">
                        <label class="control-label" for="txtFechaPago">Fecha:</label>
                        <div class="input-group date date-register" data-provide="datepicker">
                            <input type="text" name="txtFechaPago" id="txtFechaPago" class="form-control" value="<?php echo date('d/m/Y'); ?>" />
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-field">
                        <input id="txtImportePago" name="txtImportePago" type="number"  value="0.00" placeholder="" />
                        <label for="txtImportePago"><?php $translate->__('Importe de pago'); ?></label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-field">
                        <input id="txtImporteMora" name="txtImporteMora" type="number"  value="0.00" placeholder="" />
                        <label for="txtImporteMora"><?php $translate->__('Importe de mora'); ?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnCobrarDeuda" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">
                Cobrar deuda
            </button>
        </div>
    </div>
    <div id="pnlFormLineaCredito" class="modal-example-content modal-half expand-phone">
        <input type="hidden" id="hdIdCliente" name="hdIdCliente" value="0" />
        <input type="hidden" name="hdIdLineaCredito" id="hdIdLineaCredito" value="0">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Creaci&oacute; de l&iacute;nea de cr&eacute;dito</span>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <div class="scrollbarra padding10">
                 <div class="row">
                     <div class="col-md-12">
                         <div class="input-field">
                            <input id="txtImporteLinea" name="txtImporteLinea" type="number"  value="0.00" placeholder="" class="text-right" />
                            <label for="txtImporteLinea"><?php $translate->__('Importe de l&iacute;nea de cr&eacute;dito'); ?></label>
                        </div>
                     </div>
                 </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnAplicarLineaCredito" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">
                Crear l&iacute;nea de cr&eacute;dito
            </button>
        </div>
    </div>
    <?php include 'common/generic-actionbar.php'; ?>
</form>