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
    <!-- <input type="hidden" name="hdPageGeneral" id="hdPageGeneral" value="1" />
    <input type="hidden" name="hdPageCategoria" id="hdPageCategoria" value="1" />
    <input type="hidden" name="hdPageArticulo" id="hdPageArticulo" value="1" /> -->
    <input type="hidden" name="hdPageCarta_lista" id="hdPageCarta_lista" value="1" />
    <input type="hidden" name="hdPageCarta_grilla" id="hdPageCarta_grilla" value="1" />
    <input type="hidden" name="hdPageGrupo_lista" id="hdPageGrupo_lista" value="1" />
    <input type="hidden" name="hdPageGrupo_grilla" id="hdPageGrupo_grilla" value="1" />
    <input type="hidden" name="hdPageDetalle" id="hdPageDetalle" value="1" />
    <input type="hidden" id="hdFecha" name="hdFecha" value="<?php echo date('Y-m-d'); ?>" />
    <input type="hidden" id="hdTipoCarta" name="hdTipoCarta" value="01" />
    <input type="hidden" id="hdAsignacionMenu" name="hdAsignacionMenu" value="false" />
    <input type="hidden" id="hdModeMenuView" name="hdModeMenuView" value="VIEW-LIST-MENU" />
    <input type="hidden" id="hdModeMenuEdit" name="hdModeMenuEdit" value="EDIT" />
    <input type="hidden" id="hdEstadoApertura" name="hdEstadoApertura" value="00" />
    <input type="hidden" id="hdIdCategoria" name="hdIdCategoria" value="00" />
    <input type="hidden" name="hdIdEmpresa" id="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
    <input type="hidden" name="hdIdCentro" id="hdIdCentro" value="<?php echo $IdCentro; ?>" />
    <div class="page-region">
        <div id="pnlMenuCarta" class="page generic-panel gp-no-footer mdl-layout mdl-layout--fixed-header">
            <header class="gp-header mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">
                        <a class="indigo no-shadow white-text padding10 dropbutton-material" id="btnShowCalendar"><i class="material-icons right">&#xE5C5;</i>
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
            <!-- <ul id="mnuOpcionesMenu" class="mnuOpciones dropdown">
                <li><a href="#" data-action="select-all">Seleccionar todo</a></li>
                <li><a href="#" data-action="unselect-all" class="hide">Quitar selecci&oacute;n</a></li>
                <li><a href="#" data-action="close" class="close-inner-window waves-effect">Cerrar</a></li>
            </ul> -->
            <div class="control-inner-app mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D2;</i>
                </a>
            </div>
            <main class="gp-body pos-rel no-overflow">
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
                                                <th></th>
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
                <div id="pnlShowCalendar" class="place-top-left mdl-shadow--2dp grey lighten-5">
                    <?php include('common/component-calendar.php'); ?>
                </div>
                <div id="pnlSubMenu" class="control-center menu-carta">
                    <ul id="optIndividual" class="list-options no-margin no-border">
                        <li><a class="waves-effect pos-rel padding20 grey-text text-darken-4 row no-margin" data-idmodel="0" data-type="menu" href="#"><div class="col s12 v-align-middle">INDIVIDUALES</div></a></li>
                    </ul>
                    <ul id="optSubMenu" class="list-options no-margin no-border">
                    </ul>
                </div>
            </main>
            <ul id="btnActionMenu" class="mfb-component--br no-margin mfb-slidein-spring" data-mfb-toggle="hover">
                <li class="mfb-component__wrap">
                    <a href="#" class="mfb-component__button--main mdl-js-ripple-effect">
                        <!-- <i class="mfb-component__main-icon--resting ion-plus-round"></i>
                        <i class="mfb-component__main-icon--active ion-close-round"></i> -->
                        <i class="mfb-component__main-icon--active material-icons">&#xE5CD;</i>
                        <i class="mfb-component__main-icon--resting material-icons">&#xE145;</i>
                        <span class="mdl-ripple"></span>
                    </a>
                    <ul class="mfb-component__list">
                        <!-- <li>
                            <a href="#" data-action="save-changes" data-mfb-label="Guardar cambios" class="blue mfb-component__button--child mdl-js-ripple-effect">
                                <i class="mfb-component__child-icon material-icons">&#xE161;</i>
                                <span class="mdl-ripple"></span>
                            </a>
                        </li> -->
                        <li>
                            <a href="#" data-action="open-menu" data-mfb-label="Aperturar men&uacute;" class="indigo mfb-component__button--child mdl-js-ripple-effect">
                                <i class="mfb-component__child-icon material-icons">&#xE255;</i>
                                <span class="mdl-ripple"></span>
                            </a>
                        </li>
                        <li>
                            <a href="#" data-action="search-articles" data-mfb-label="Buscar art&iacute;culos" class="blue mfb-component__button--child mdl-js-ripple-effect">
                                <i class="mfb-component__child-icon material-icons">&#xE8B6;</i>
                                <span class="mdl-ripple"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div id="pnlListado" class="page demo-layout-waterfall mdl-layout mdl-js-layout mdl-layout--fixed-header hide">
            <header class="mdl-layout__header mdl-layout__header--waterfall">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">
                        <a class="no-shadow white-text padding10 dropbutton-material" id="btnMoreSites"><i class="material-icons right">&#xE5C5;</i><span class="text">Articulos</span></a>
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
                    <section id="gvCategoria" class="list-checkbox gridview hide" data-selected="none" data-multiselect="false" data-actionbar="articulos-actionbar">
                        <ul class="gridview-content mini-collection no-margin">
                        </ul>
                    </section>
                    <section id="gvArticulo" class="gridview pos-rel" data-selected="none" data-multiselect="false" data-actionbar="articulos-actionbar">
                        <div class="mdl-grid gridview-content">
                        </div>
                        <div class="table-responsive-vertical shadow-z-1 hide">
                            <table class="table table-bordered table-hover mdl-shadow--2dp">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th><?php $translate->__('Articulo'); ?></th>
                                        <th><?php $translate->__('Stock'); ?></th>
                                        <th><?php $translate->__('Precio'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </section>
                    <section id="gvPacks" class="gridview hide" data-selected="none" data-multiselect="false" data-actionbar="articulos-actionbar">
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
                                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label full-size">
                                                    <textarea class="mdl-textfield__input" type="text" rows= "3" id="txtDescripcion" name="txtDescripcion"></textarea>
                                                    <label class="mdl-textfield__label" for="txtDescripcion"><?php $translate->__('Descripci&oacute;n'); ?></label>
                                                </div>
                                            </div>
                                            <div class="row margin-bottom-20">
                                                <div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label full-size">
                                                    <select id="ddlCategoriaReg" name="ddlCategoriaReg" class="mdl-selectfield__select full-size">
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
                                                    <label for="ddlCategoriaReg" class="mdl-selectfield__label"><?php $translate->__('Categor&iacute;a'); ?></label>
                                                    <span class="mdl-selectfield__error">Input is not a empty!</span>
                                                </div>
                                            </div>
                                            <div class="row margin-bottom-20">
                                                <div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label full-size">
                                                    <select id="ddlAreaDespacho" name="ddlAreaDespacho" class="mdl-selectfield__select full-size">
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
                                                    <label for="ddlAreaDespacho" class="mdl-selectfield__label"><?php $translate->__('&Aacute;rea de despacho'); ?></label>
                                                    <span class="mdl-selectfield__error">Input is not a empty!</span>
                                                </div>
                                            </div>
                                            <div class="row margin-top10">
                                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label full-size">
                                                    <input class="mdl-textfield__input" type="text" id="txtPrecioArticulo" name="txtPrecioArticulo">
                                                    <label class="mdl-textfield__label" for="txtPrecioArticulo"><?php $translate->__('Precio'); ?></label>
                                                </div>
                                            </div>
                                            <div class="row margin-top10">
                                                <div class="mdl-grid mdl-grid--no-spacing no-margin full-size">
                                                    <div class="mdl-cell mdl-cell--6-col">
                                                        <h5 class="no-padding no-margin"><?php $translate->__('Tiene receta'); ?></h5>
                                                    </div>
                                                    <div class="mdl-cell mdl-cell--6-col">
                                                        <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="chkTieneReceta">
                                                            <input type="checkbox" id="chkTieneReceta" name="chkTieneReceta" class="mdl-switch__input">
                                                            <span id="helperReceta" class="mdl-switch__label">NO</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row margin-top10">
                                                <div class="mdl-grid mdl-grid--no-spacing no-margin full-size">
                                                    <div class="mdl-cell mdl-cell--6-col">
                                                        <h5 class="no-padding no-margin"><?php $translate->__('Es añadido/extra'); ?></h5>
                                                    </div>
                                                    <div class="mdl-cell mdl-cell--6-col">
                                                        <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="chkEsAgregado">
                                                            <input type="checkbox" id="chkEsAgregado" name="chkEsAgregado" class="mdl-switch__input">
                                                            <span id="helperAgregado" class="mdl-switch__label">NO</span>
                                                        </label>
                                                    </div>
                                                </div>
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
                                            <a class="no-shadow white-text padding10 dropbutton-material" id="btnChooseReceta" data-tiporeceta="01"><i class="material-icons right">&#xE5C5;</i><span class="text">Receta para men&uacute;</span></a>
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
                                    <li><a href="#" data-tiporeceta="01">Receta para men&uacute;</a></li>
                                    <li><a href="#" data-tiporeceta="00">Receta para carta</a></li>
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
                                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label full-size">
                                                <input class="mdl-textfield__input" type="text" id="txtTiempoPreparacionMenu" name="txtTiempoPreparacionMenu">
                                                <label class="mdl-textfield__label" for="txtTiempoPreparacionMenu"><?php $translate->__('Ejemplo: 00:30'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="pnlTimePrepCarta" class="mdl-grid hide">
                                        <div class="mdl-cell mdl-cell--8-col align-right">
                                            <h4><?php $translate->__('Tiempo de preparaci&oacute;n:'); ?></h4>
                                        </div>
                                        <div class="mdl-cell mdl-cell--4-col">
                                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label full-size">
                                                <input class="mdl-textfield__input" type="text" id="txtTiempoPreparacionCarta" name="txtTiempoPreparacionCarta">
                                                <label class="mdl-textfield__label" for="txtTiempoPreparacionCarta"><?php $translate->__('Ejemplo: 00:30'); ?></label>
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
        <a id="btnNuevo" class="mdl-button mdl-js-button mdl-button--fab animate mdl-js-ripple-effect mdl-button--colored ocultar" style="bottom: 45px; right: 24px; position: absolute; z-index: 900;">
            <i class="material-icons">&#xE145;</i>
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
                <button id="btnGoToPacks" type="button" data-action="add-list" class="show-in-select hide mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE890;</i>
                </button>
                <button id="btnCategoriaEdit" type="button" class="hide show-in-select mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5CA;</i>
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
                <button id="btnAsignarGrupoProducto" type="button" data-action="confirm" class="hide show-in-select mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5CA;</i>
                </button>
            </div>
        </header>
        <div class="mdl-layout__drawer-button">
            <a id="btnRecursosBack" class="back-button mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                <i class="material-icons">&#xE5C4;</i>
            </a>
        </div>
    </div>
    <div id="modalRegPack" class="modal-example-content expand-phone margin-expand20">
        <div class="modal-example-header">
            <h3 class="left">
                 Registro de pack
            </h3>
        </div>
        <div class="modal-example-body">
            <input type="hidden" id="hdIdPack" name="hdIdPack" value="0" />
            <div class="padding20">
                <div class="row">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label full-size">
                        <input class="mdl-textfield__input" type="text" id="txtNombreGrupo" name="txtNombreGrupo">
                        <label class="mdl-textfield__label" for="txtNombreGrupo"><?php $translate->__('Ingrese nombre del pack'); ?></label>
                    </div>
                </div>
                <div class="row mdl-grid mdl-grid--no-spacing">
                    <div class="mdl-cell mdl-cell--6-col">
                        <div class="input-field full-size with-select margin-right10">
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
                    <div class="mdl-cell mdl-cell--6-col">
                        <div class="mdl-textfield mdl-js-textfield margin-left10 mdl-textfield--floating-label full-size">
                            <input class="mdl-textfield__input" type="text" id="txtPrecioVigente" name="txtPrecioVigente" class="align-right" value="0.00">
                            <label class="mdl-textfield__label" for="txtPrecioVigente"><?php $translate->__('Ingrese precio'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="gpSeccion" class="mini-details">
                        <div class="scrollbarra">
                            <table id="tableSeccion" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
                                <thead>
                                    <tr>
                                        <th><label class="mdl-input-js mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect check-filled" for="chkAllSeccion"><input name="chkAllSeccion" type="checkbox" id="chkAllSeccion" class="mdl-checkbox__input"><span class="mdl-checkbox__label"></span></label></td></th>
                                        <th class="mdl-data-table__cell--non-numeric">Secciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnAplicarGrupo" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">
                Aplicar
            </button>
            <button id="btnCerrarModalGrupo" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">
                Cerrar
            </button>
        </div>
    </div>
</form>