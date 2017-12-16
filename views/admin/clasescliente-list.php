<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPageGeneral" name="hdPageGeneral" value="1" />
    <input type="hidden" id="hdIdEmpresa" name="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
    <input type="hidden" id="hdIdCentro" name="hdIdCentro" value="<?php echo $IdCentro; ?>" />
    <div class="page-region">
        <div id="pnlForm"  class="demo-layout-waterfall mdl-layout mdl-js-layout mdl-layout--fixed-header">
            <header class="mdl-layout__header mdl-layout__header--waterfall">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Clases de clientes</span>
                    <div class="mdl-layout-spacer"></div>
                    <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnViewList">
                        <i class="material-icons">&#xE5D2;</i>
                    </button>
                </div>
            </header>
            <main class="mdl-layout__content">
                <div class="page-content">
                    <div class="padding20 all-height">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-field full-size">
                                    <select id="ddlServicio" name="ddlServicio" style="width: 100%;" class="browser-default">
                                    </select>
                                    <label class="active" for="ddlServicio"><?php $translate->__('Clases disponibles'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <button id="btnRegistrarAsistencia" name="btnRegistrarAsistencia" type="button" lang="es" class="mdl-button mdl-js-button mdl-js-ripple-effect yellow darken-1 black-text center-block">
                                Separar clase
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="pnlListado" class="demo-layout-waterfall mdl-layout mdl-js-layout mdl-layout--fixed-header" style="display: none;">
            <header class="mdl-layout__header mdl-layout__header--waterfall">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Lista de rutinas disponibles</span>
                </div>
            </header>
            <div id="btnBack" class="mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5C4;</i>
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
        </div>
    </div>
    <?php include 'common/generic-actionbar.php'; ?>
</form>