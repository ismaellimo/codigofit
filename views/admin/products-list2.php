<?php
include('bussiness/categoria.php');
include('bussiness/unidadmedida.php');
include('bussiness/areas.php');
include('bussiness/monedas.php');

$IdEmpresa = 1;
$IdCentro = 1;

$counterCategoria = 0;
$counterUM = 0;
$counterArea = 0;

$objCategoria = new clsCategoria();
$objUM = new clsUnidadMedida();
$objArea = new clsArea();
$objMoneda = new clsMoneda();

$rowCategoria = $objCategoria->Listar('3', $IdEmpresa, $IdCentro, '0',  '', 0);
$countRowCategoria = count($rowCategoria);

$rowUM = $objUM->Listar('1', 0, '');
$countRowUM = count($rowUM);

$rowArea = $objArea->Listar('3', $IdEmpresa, $IdCentro, 0, '');
$countRowArea = count($rowArea);

$rowMoneda = $objMoneda->ListarVigMoneda();
$countRowMoneda = count($rowMoneda);
?>
<form id="form1" name="form1" method="post">
    <input type="hidden" name="fnPost" id="fnPost" value="fnPost" />
    <input type="hidden" name="lang" id="lang" value="<?php echo $lang; ?>" />
    <input type="hidden" name="hdPageGeneral" id="hdPageGeneral" value="1" />
    <input type="hidden" name="hdPageCategoria" id="hdPageCategoria" value="1" />
    <input type="hidden" name="hdPageArticulo" id="hdPageArticulo" value="1" />
    <input type="hidden" name="hdPageCarta_lista" id="hdPageCarta_lista" value="1" />
    <input type="hidden" name="hdPageCarta_grilla" id="hdPageCarta_grilla" value="1" />
    <input type="hidden" name="hdPageGrupo_lista" id="hdPageGrupo_lista" value="1" />
    <input type="hidden" name="hdPageGrupo_grilla" id="hdPageGrupo_grilla" value="1" />
    <input type="hidden" name="hdPageDetalle" id="hdPageDetalle" value="1" />
    <input type="hidden" id="hdFecha" name="hdFecha" value="<?php echo date('Y-m-d'); ?>" />
    <input type="hidden" id="hdTipoCarta" name="hdTipoCarta" value="00" />
    <input type="hidden" id="hdEstadoApertura" name="hdEstadoApertura" value="00" />
    <input type="hidden" name="hdIdEmpresa" id="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
    <input type="hidden" name="hdIdCentro" id="hdIdCentro" value="<?php echo $IdCentro; ?>" />
    <div class="page-region">
        <div id="pnlMenuCarta" class="page generic-panel gp-no-footer mdl-layout mdl-layout--fixed-header">
            <header class="gp-header mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">
                        <a class="waves-effect waves-light indigo no-shadow white-text padding10 dropbutton-material" id="btnShowCalendar"><i class="material-icons right">&#xE5C5;</i>
                            <span id="lblFechaCompleta" class="text hide-on-small-only"></span>
                            <span id="lblFechaCorta" class="text hide-on-med-and-up"></span>
                        </a>
                        <span id="lblTitulo" class="hide">Carta</span>
                    </span>
                    <div class="mdl-layout-spacer"></div>
                    <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnSearchMenu" data-type="search">
                        <i class="material-icons">&#xE8B6;</i>
                    </button>
                    <button type="button" class="btnOpciones mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnOpcionesMenu">
                        <i class="material-icons">&#xE5D4;</i>
                    </button>
                </div>
            </header>
            <ul id="mnuOpcionesMenu" class="mnuOpciones dropdown">
                <li><a href="#" data-action="select-all" class="waves-effect">Seleccionar todo</a></li>
                <li><a href="#" data-action="unselect-all" class="waves-effect oculto">Quitar selecci&oacute;n</a></li>
                <li><a href="#" data-action="close" class="close-inner-window waves-effect">Cerrar</a></li>
            </ul>
            <div class="control-inner-app mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D2;</i>
                </a>
            </div>
            <main class="gp-body no-overflow">
                <div id="pnlViewAllArticles" class="generic-panel gp-no-footer mdl-layout mdl-layout--fixed-header">
                    <header class="gp-header mdl-layout__header white">
                        <div class="mdl-layout__header-row">
                            <span id="titleMenuCarta" class="mdl-layout-title row no-margin grey-text text-darken-1 hide"></span>
                            <div class="mdl-layout-spacer"></div>
                            <button data-action="view-list" type="button" class="view-button mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon active">
                                <i class="material-icons">&#xE8EE;</i>
                            </button>
                            <button data-action="view-menu" type="button" class="view-button mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                                <i class="material-icons">&#xE8F1;</i>
                            </button>
                        </div>
                    </header>
                    <div id="btnShowSubOpciones" class="mdl-layout__drawer-button hide">
                        <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon grey-text text-darken-1">
                            <i class="material-icons">&#xE5D2;</i>
                        </a>
                    </div>
                    <main class="gp-body no-overflow pos-rel">
                        <div class="scrollbarra">
                            <div id="gvArticuloMenu" class="gridview pos-rel padding20" data-selected="none" data-multiselect="false" data-actionbar="articulos-actionbar">
                                <div class="table-responsive-vertical shadow-z-1">
                                    <table class="table table-bordered table-hover mdl-shadow--2dp">
                                      <thead>
                                        <tr>
                                            <th><?php $translate->__('Articulo'); ?></th>
                                            <th><?php $translate->__('Stock'); ?></th>
                                            <th><?php $translate->__('Precio'); ?></th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
                <div id="pnlShowCalendar" class="place-top-left mdl-shadow--2dp grey lighten-5" style="display: none;">
                    <div id="pnlCalendarioIndividual" class="responsive-calendar">
                        <div class="controls padding10">
                            <a class="left mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon padding10" data-go="prev"><h1><i class="material-icons">&#xE5CB;</i></h1></a>
                            <h2><span data-head-year></span> <span data-head-month></span></h2>
                            <a class="right mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon padding10" data-go="next"><h1><i class="material-icons">&#xE5CC;</i></h1></a>
                            <div class="clear"></div>
                        </div>
                        <div class="day-headers">
                            <div class="day header white-text"><?php $translate->__('Lun'); ?></div>
                            <div class="day header white-text"><?php $translate->__('Mar'); ?></div>
                            <div class="day header white-text"><?php $translate->__('Mie'); ?></div>
                            <div class="day header white-text"><?php $translate->__('Jue'); ?></div>
                            <div class="day header white-text"><?php $translate->__('Vie'); ?></div>
                            <div class="day header white-text"><?php $translate->__('Sab'); ?></div>
                            <div class="day header white-text"><?php $translate->__('Dom'); ?></div>
                        </div>
                        <div class="days-container">
                            <div class="days grey lighten-5" data-group="days"></div>
                        </div>
                    </div>
                </div>
                <div id="pnlSubMenu" class="control-center menu-carta">
                    <ul id="optIndividual" class="list-options no-margin no-border">
                        <li><a class="waves-effect pos-rel padding20 grey-text text-darken-4 row no-margin" data-idmodel="0" data-type="menu" href="#"><div class="col s12 v-align-middle">INDIVIDUALES</div></a></li>
                    </ul>
                    <ul id="optSubMenu" class="list-options no-margin no-border">
                    </ul>
                </div>
            </main>
            <div id="btnActionMenu" class="fixed-action-btn" style="bottom: 45px; right: 24px;">
                <a class="btn-floating btn-large red waves-effect waves-light">
                    <i class="material-icons">&#xE3C9;</i>
                </a>
                <ul>
                    <li>
                        <span class="mobile-fab-tip">Aperturar men&uacute;</span>
                        <a href="#" data-action="open-menu" class="btn-floating red tooltipped" data-position="left" data-tooltip="Aperturar men&uacute;">
                            <i class="material-icons">&#xE255;</i>
                        </a>
                    </li>
                    <li>
                        <span class="mobile-fab-tip">Buscar art&iacute;culos</span>
                        <a href="#" data-action="search-articles" class="btn-floating green tooltipped" data-position="left" data-tooltip="Buscar art&iacute;culos">
                            <i class="material-icons">&#xE8B6;</i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div id="pnlListado" class="page demo-layout-waterfall mdl-layout mdl-js-layout mdl-layout--fixed-header hide">
            <header class="mdl-layout__header mdl-layout__header--waterfall">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">
                        <a class="waves-effect waves-light indigo no-shadow white-text padding10 dropbutton-material" id="btnMoreSites"><i class="material-icons right">&#xE5C5;</i><span class="text">Articulos</span></a>
                    </span>
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
            <ul id="mnuSites" class="dropdown dropdown-sites">
            </ul>
            <div class="control-inner-app mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D2;</i>
                </a>
            </div>
            <main class="mdl-layout__content">
                <div class="page-content">
                    <section id="gvCategoria" class="list-checkbox gridview" data-selected="none" data-multiselect="false" data-actionbar="articulos-actionbar" style="display: none;">
                        <ul class="mini-collection gridview-content no-margin">
                        </ul>
                    </section>
                    <section id="gvArticulo" class="gridview pos-rel" data-selected="none" data-multiselect="false" data-actionbar="articulos-actionbar">
                        <div class="mdl-grid gridview-content">
                        </div>
                    </section>
                    <section id="gvPacks" class="gridview" data-selected="none" data-multiselect="false" data-actionbar="articulos-actionbar" style="display: none;">
                        <div class="gridview-content pos-rel">
                        </div>
                    </section>
                </div>
            </main>
        </div>
        <div id="pnlRegArticulo" class="page generic-panel gp-no-footer mdl-layout mdl-layout--fixed-header hide">
            <input type="hidden" id="hdIdArticulo" name="hdIdArticulo" value="0" />
            <input type="hidden" id="hdFoto" name="hdFoto" value="no-set" />
            <header class="gp-header mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Articulo</span>
                    <div class="mdl-layout-spacer"></div>
                    <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnAplicarArticulo">
                        <i class="material-icons">&#xE5CA;</i>
                    </button>
                </div>
            </header>
            <div id="btnBackToArticles" title="<?php $translate->__('Regresar'); ?>" class="mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5C4;</i>
                </a>
            </div>
            <main class="gp-body no-overflow">
                <div class="flex-grid all-height">
                    <div class="row all-height pos-rel no-margin">
                        <div class="cell colspan4 all-height header-on-phone">
                            <div id="pnlFormArticulo" class="generic-panel gp-no-footer">
                                <header class="gp-header no-overflow">
                                    <?php include 'common/component-image.php'; ?>
                                </header>
                                <main class="gp-body">
                                    <div class="scrollbarra">
                                        <div class="grid white padding20">
                                            <div class="row">
                                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label full-size">
                                                    <input class="mdl-textfield__input" type="text" id="txtCodigo" name="txtCodigo">
                                                    <label class="mdl-textfield__label" for="txtCodigo"><?php $translate->__('C&oacute;digo'); ?></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label full-size">
                                                    <input class="mdl-textfield__input" type="text" id="txtNombreArticulo" name="txtNombreArticulo">
                                                    <label class="mdl-textfield__label" for="txtNombreArticulo"><?php $translate->__('Nombre de art&iacute;culo'); ?></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mdl-textfield mdl-js-textfield full-size">
                                                    <textarea class="mdl-textfield__input" type="text" rows= "3" id="txtDescripcion" name="txtDescripcion"></textarea>
                                                    <label class="mdl-textfield__label" for="txtDescripcion"></label>
                                                </div>
                                            </div>
                                            <div class="row margin-bottom-20">
                                                <div class="input-field full-size">
                                                    <label class="active" for="ddlCategoriaReg"><?php $translate->__('Categor&iacute;a'); ?></label>
                                                    <select id="ddlCategoriaReg" name="ddlCategoriaReg" style="width: 100%;">
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
                                                </div>
                                            </div>
                                            <div class="row margin-bottom-20">
                                                <div class="input-field full-size">
                                                    <label class="active" for="ddlAreaDespacho"><?php $translate->__('&Aacute;rea de despacho'); ?></label>
                                                    <select id="ddlAreaDespacho" name="ddlAreaDespacho" style="width: 100%;">
                                                        <?php
                                                        if ($countRowArea > 0):
                                                            for ($counterArea=0; $counterArea < $countRowArea; $counterArea++):
                                                        ?>
                                                        <option value="<?php echo $rowArea[$counterArea]['tp_idarea']; ?>"><?php echo $rowArea[$counterArea]['tp_nombre']; ?></option>
                                                        <?php
                                                            endfor;
                                                        endif;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <h5 class="no-padding no-margin"><?php $translate->__('Tiene receta'); ?></h5>
                                                <!-- <div class="switch">
                                                    <label>
                                                    <input type="checkbox" id="chkTieneReceta" name="chkTieneReceta" />
                                                    <span class="lever"></span>
                                                    </label>
                                                </div>
                                                <span id="helperReceta" class="mdl-switch__label">NO</span> -->
                                                <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="chkTieneReceta">
                                                  <input type="checkbox" id="chkTieneReceta" name="chkTieneReceta" class="mdl-switch__input">
                                                  <span id="helperReceta" class="mdl-switch__label">NO</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </main>
                            </div>
                        </div>
                        <div class="cell colspan8 all-height body-on-phone no-footer">
                            <div id="pnlReceta" class="generic-panel mdl-layout mdl-layout--fixed-header">
                                <header class="gp-header mdl-layout__header blue">
                                    <div id="hrowMain" class="mdl-layout__header-row">
                                        <span class="mdl-layout-title">
                                            <a class="waves-effect waves-light no-shadow white-text padding10 dropbutton-material" id="btnChooseReceta" data-tiporeceta="01"><i class="material-icons right">&#xE5C5;</i><span class="text" >Receta para men&uacute;</span></a>
                                        </span>
                                        <div class="mdl-layout-spacer"></div>
                                        <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" id="btnSearchInsumo" data-position="bottom" data-tooltip="Buscar insumos">
                                            <i class="material-icons">&#xE8B6;</i>
                                        </button>
                                    </div>
                                    <div id="hrowSearchInsumo" class="mdl-layout__header-row hide">
                                        <div id="pnlInsumo" class="pos-rel input textarea clearfix custom stackoverflow" style="width: 100%;"></div>
                                        <button id="btnAddInsumo" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect place-top-right mdl-button--icon margin20 grey-text text-darken-4 tooltipped" data-position="bottom" data-tooltip="Agregar insumos">
                                            <i class="material-icons">&#xE03B;</i>
                                        </button>
                                    </div>
                                </header>
                                <ul id="mnuTipoReceta" class="dropdown dropdown-sites">
                                    <li><a href="#" data-tiporeceta="01" class="waves-effect">Receta para men&uacute;</a></li>
                                    <li><a href="#" data-tiporeceta="00" class="waves-effect">Receta para carta</a></li>
                                </ul>
                                <div id="btnHideSearchInsumo" class="mdl-layout__drawer-button hide">
                                    <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon grey-text text-darken-4">
                                        <i class="material-icons">&#xE5C4;</i>
                                    </a>
                                </div>
                                <main class="gp-body">
                                    <div class="scrollbarra">
                                        <div id="tableReceta" class="pos-rel padding20" data-selected="none" data-multiselect="false" data-actionbar="articulos-actionbar">
                                            <div class="table-responsive-vertical shadow-z-1">
                                                <table class="table table-bordered table-hover mdl-shadow--2dp">
                                                    <thead>
                                                        <tr>
                                                            <th><?php $translate->__('Insumo'); ?></th>
                                                            <th><?php $translate->__('Unidad de medida'); ?></th>
                                                            <th><?php $translate->__('Cantidad'); ?></th>
                                                            <th><?php $translate->__('Nro. de porciones'); ?></th>
                                                            <th><?php $translate->__('Promedio por porci&oacute;n'); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </main>
                                <footer class="gp-footer white mdl-shadow--4dp">
                                    <div id="pnlTimePrepMenu" class="mdl-grid">
                                        <div class="mdl-cell mdl-cell--8-col align-right">
                                            <h4><?php $translate->__('Tiempo de preparaci&oacute;n:'); ?></h4>
                                        </div>
                                        <div class="mdl-cell mdl-cell--4-col">
                                            <div class="input-field no-margin full-size">
                                                <input id="txtTiempoPreparacionMenu" name="txtTiempoPreparacionMenu" type="text" class="no-margin align-right" placeholder="<?php $translate->__('Ejemplo: 00:30'); ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div id="pnlTimePrepCarta" class="mdl-grid hide">
                                        <div class="mdl-cell mdl-cell--8-col align-right">
                                            <h4><?php $translate->__('Tiempo de preparaci&oacute;n:'); ?></h4>
                                        </div>
                                        <div class="mdl-cell mdl-cell--4-col">
                                            <div class="input-field no-margin full-size">
                                                <input id="txtTiempoPreparacionCarta" name="txtTiempoPreparacionCarta" type="text" class="no-margin align-right" placeholder="<?php $translate->__('Ejemplo: 00:30'); ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </footer>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <?php
        $title_empty_default = 'Registro vac&iacute;o :(';
        $description_empty_default = '';
        include 'common/component-empty.php';
        ?>
        <a id="btnNuevo" class="btn-floating btn-large waves-effect waves-light red" style="bottom: 45px; right: 24px; position: absolute; z-index: 900;">
            <i class="large material-icons">add</i>
        </a>
    </div>
    <div id="articulos-actionbar" class="actionbar fixed-top mdl-layout">
        <header class="mdl-layout__header">
            <div class="mdl-layout__header-row">
                <div class="pos-rel full-size m-search">
                    <input type="text" name="txtSearch" id="txtSearch" data-input="search" placeholder="Ingrese un criterio de b&uacute;squeda" value="" autocomplete="off">
                    <button type="button" class="helper-button margin5 height-centered mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon"><i class="material-icons">&#xE5CD;</i></button>
                    <div class="clearfix"></div>
                </div>
                <div class="mdl-layout-spacer"></div>
                <button id="btnProgram" type="button" data-action="program" class="show-in-select mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE878;</i>
                </button>
                <button id="btnGoToPacks" type="button" data-action="add-list" class="show-in-select mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE890;</i>
                </button>
                <button type="button" data-action="delete" class="show-in-select mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE872;</i>
                </button>
                <button type="button" class="btnOpciones show-in-select mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D4;</i>
                </button>
                <button id="btnSearchPacks" type="button" class="oculto show-in-select mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE8B6;</i>
                </button>
                <button id="btnAsignarGrupoProducto" type="button" data-action="confirm" class="oculto show-in-select mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5CA;</i>
                </button>
            </div>
        </header>
        <div class="mdl-layout__drawer-button">
            <a class="back-button mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                <i class="material-icons">&#xE5C4;</i>
            </a>
        </div>
    </div>
    <div id="modalRegCategoria" class="modal-example-content modal-half">
        <div class="modal-example-header">
            <div class="left">
                <a href="#" title="<?php $translate->__('Ocultar'); ?>" class="close-modal-example fg-dark padding5 circle waves-effect waves-light left"><i class="material-icons md-18">close</i></a>
                <h4 class="no-margin fg-dark left">
                     Registro de categoria
                </h4>
            </div>
        </div>
        <div class="modal-example-body">
            <input type="hidden" id="hdIdCategoria" name="hdIdCategoria" value="0" />
            <div class="padding20">
                <div class="row">
                    <div class="input-field full-size">
                      <input id="txtNombreCategoria" name="txtNombreCategoria" type="text" class="validate">
                      <label class="active" for="txtNombreCategoria">Nombre de categor&iacute;a</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnAplicarCategoria" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">
                Aplicar
            </button>
        </div>
    </div>
    <div id="modalRegPack" class="modal-example-content expand-phone margin-expand20">
        <div class="modal-example-header">
            <div class="left">
                <a href="#" title="<?php $translate->__('Ocultar'); ?>" class="close-modal-example fg-dark padding5 circle waves-effect waves-light left"><i class="material-icons md-18">close</i></a>
                <h4 class="no-margin fg-dark left">
                     Registro de pack
                </h4>
            </div>
        </div>
        <div class="modal-example-body">
            <input type="hidden" id="hdIdPack" name="hdIdPack" value="0" />
            <div class="padding20">
                <div class="row">
                    <div class="input-field full-size">
                        <input id="txtNombreGrupo" name="txtNombreGrupo" type="text" placeholder="Ingrese nombre del pack" />
                        <label for="txtNombreGrupo"><?php $translate->__('Descripci&oacute;n'); ?></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s8 no-padding-left">
                        <div class="input-field full-size with-select">
                            <label class="active" for="ddlMoneda"><?php $translate->__('Moneda de precio pack'); ?></label>
                            <select name="ddlMoneda" id="ddlMoneda" style="width: 100%;">
                                <?php
                                if ($countRowMoneda > 0):
                                    for ($counterMoneda=0; $counterMoneda < $countRowMoneda; ++$counterMoneda):
                                ?>
                                <option data-simbolo="<?php echo $rowMoneda[$counterMoneda]['tm_simbolo']; ?>" data-tipocambio="<?php echo $rowMoneda[$counterMoneda]['td_importe']; ?>" value="<?php echo $rowMoneda[$counterMoneda]['tm_idmoneda']; ?>">
                                    <?php echo $rowMoneda[$counterMoneda]['tm_nombre'].' ('.$rowMoneda[$counterMoneda]['tm_simbolo'].')'; ?>
                                </option>
                                <?php
                                    endfor;
                                endif;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col s4 no-padding-right">
                        <div class="input-field full-size">
                            <input id="txtPrecioVigente" name="txtPrecioVigente" type="text" class="align-right" placeholder="Ingrese precio del pack" value="0.00" />
                            <label for="txtPrecioVigente"><?php $translate->__('Precio de pack'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="gpSeccion" class="generic-panel gp-no-footer mini-details">
                        <div class="gp-header">
                            <div class="pos-rel full-size">
                                <div class="place-top-left width70 all-height align-center">
                                    <input type="checkbox" id="chkAllSeccion" class="filled-in" />
                                    <label for="chkAllSeccion"></label>
                                </div>
                                <h5 class="padding-left70 full-size"><?php $translate->__('Secciones'); ?></h5>
                            </div>
                        </div>
                        <div class="gp-body">
                            <div class="scrollbarra">
                                <table id="tableSeccion">
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnAplicarGrupo" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">
                Aplicar
            </button>
        </div>
    </div>
</form>