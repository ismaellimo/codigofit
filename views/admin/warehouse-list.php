<?php
require 'bussiness/almacen.php';
$objAlmacen = new clsAlmacen();

$rsAlmacen = $objAlmacen->Listar('2', $IdEmpresa, $IdCentro, 0, '');
$countAlmacen = count($rsAlmacen);
?>
<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPageActual" name="hdPageActual" value="1" />
    <input type="hidden" id="hdPage" name="hdPage" value="1" />
    <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0" />
    <input type="hidden" id="hdFoto" name="hdFoto" value="no-set" />
    <input type="hidden" id="hdComodinBack" name="hdComodinBack" value="no-set" />
    <div class="page-region">
        <div id="pnlListado" class="inner-page">
            <h1 class="title-window">
                <a id="btnBackToKardex" href="#" title="Regresar a panel log&iacute;stico" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                <?php $translate->__('Stock en almacenes'); ?>
            </h1>
            <div class="divContent">
                <div id="pnlLogistica" class="moduloTwoPanel">
                    <div class="colTwoPanel1 column-panel">
                        <h2 class="header-panel"><?php $translate->__('Almacenes'); ?></h2>
                        <div class="body-panel">
                            <div class="scroll-panel">
                                <div id="gvAlmacen" class="tile-area numeric-tile">
                                    <?php
                                    if ($countAlmacen > 0):
                                        for ($i=0; $i < $countAlmacen; $i++):
                                            $selected = ($i == 0) ? ' selected' : '';
                                    ?>
                                    <div data-id="<?php echo $rsAlmacen[$i]['tm_idalmacen']; ?>" class="tile double bg-lime<?php echo $selected; ?>">
                                        <div class="tile-content">
                                            <div class="padding10 ntp">
                                                <h4 class="fg-dark"><?php echo $rsAlmacen[$i]['tm_nombre']; ?></h4>
                                                <p class="fg-dark"><?php echo $rsAlmacen[$i]['tm_direccion']; ?></p>
                                            </div>
                                        </div>
                                        <div class="tile-status bg-dark">
                                            <div class="badge bg-darkCyan">
                                                <?php echo $rsAlmacen[$i]['CountInsumo']; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        endfor;
                                    endif;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="colTwoPanel2 column-panel">
                        <h2 class="header-panel"><?php $translate->__('Insumos'); ?></h2>
                        <div class="body-panel">
                            <div class="scroll-panel">
                                <div id="gvInsumos" class="tile-area">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="appbar">
        <button id="btnAdminAlmacen" name="btnAdminAlmacen" type="button" class="metro_button float-left">
            <span class="content">
                <img src="images/trash.png" alt="<?php $translate->__('Administrar almacenes'); ?>" />
                <span class="text"><?php $translate->__('Administrar almacenes'); ?></span>
            </span>
        </button>
        <button id="btnSelectAll" type="button" class="metro_button oculto float-left">
            <span class="content">
                <img src="images/checkall.png" alt="<?php $translate->__('Seleccionar todo'); ?>" />
                <span class="text"><?php $translate->__('Seleccionar todo'); ?></span>
            </span>
        </button>
        <button id="btnLimpiarSeleccion" type="button" class="metro_button oculto float-left">
            <span class="content">
                <img src="images/icon_uncheck.png" alt="<?php $translate->__('Limpiar selecci&oacute;n'); ?>" />
                <span class="text"><?php $translate->__('Limpiar selecci&oacute;n'); ?></span>
            </span>
        </button>
        <button id="btnCancelar" type="button" class="metro_button oculto float-right">
            <span class="content">
                <img src="images/cancel.png" alt="<?php $translate->__('Cancelar'); ?>" />
                <span class="text"><?php $translate->__('Cancelar'); ?></span>
            </span>
        </button>
        <button id="btnGuardar" name="btnGuardar" type="button" class="metro_button oculto float-right">
            <span class="content">
                <img src="images/save.png" alt="<?php $translate->__('Guardar'); ?>" />
                <span class="text"><?php $translate->__('Guardar cambios'); ?></span>
            </span>
        </button>
        <div class="clear"></div>
    </div>
</form>
<?php
include('common/libraries-js.php');
include('common/validate-js.php');
include('common/bootstrap-js.php');
?>
<script>
    $(document).ready(function() {
        $('#btnBackToKardex').on('click', function(event) {
            event.preventDefault();
            $('#pnlAdminAlmacen', parent.document).fadeOut(400, function() {
                
            });
        });

        $('#btnKardex').on('click', function(event) {
            event.preventDefault();
            mostrarPanel('#pnlKardex', '?pag=procesos&subpag=kardex&op=list');
        });

        $('#gvAlmacen').on('click', '.tile', function(event) {
            event.preventDefault();
            $(this).siblings('.selected').removeClass('selected');
            $(this).addClass('selected');
            listarInsumosAlmacen();
        }).find('.tile:first').trigger('click');

        $('#btnBackToRegister').on('click', function(event) {
            event.preventDefault();
            
        });
        $('#btnBuscarItems').on('click', function(event) {
            var idPanelOut = '';
            event.preventDefault();
            $(this).addClass('oculto');
            $('#btnGuardar, #btnCancelar').addClass('oculto');
            $('#btnSelectAll').removeClass('oculto');
            
            if ($('#pnlRegistroCompra').is(':visible')){
                idPanelOut = '#pnlRegistroCompra';
            }
            else {
                idPanelOut = '#pnlRegistroGuia';
            }
            $(idPanelOut).fadeOut(400, function() {
                $('#pnlBusquedaItems').fadeIn(400, function() {
                    
                });
            });
        });
        $('#btnSelectAll').on('click', function(event) {
            event.preventDefault();
            $(this).addClass('oculto');
            $('#btnLimpiarSeleccion, #btnAddItems').removeClass('oculto');
        });
        $('#btnLimpiarSeleccion').on('click', function(event) {
            event.preventDefault();
            $(this).addClass('oculto');
            $('#btnAddItems').addClass('oculto');
            $('#btnSelectAll').removeClass('oculto');
        });
        $('#btnAddItems').on('click', function(event) {
            event.preventDefault();
            
        });
    });
    function searchItems (pagina) {
        var tipobusqueda = '00';
        var urlservice = '';
        var datasearch = '';
        var selector = '';
        var criterio = '';
        tipobusqueda = $('#pnlBusquedaItems .title-window a.link-title-window.active').attr('data-tipomenu');
        criterio = $('#txtSearchItems').val();
        if (tipobusqueda == '00') {
            urlservice = 'services/insumos-search.php';
            datasearch = 'tipobusqueda=SEARCH&criterio=' + criterio;
        }
        else if (tipobusqueda == '01'){
            urlservice = 'services/products-search.php';
            datasearch = 'tipobusqueda=01&criterio=' + criterio + '&lastId' + pagina;
        }
        $.ajax({
            url: urlservice,
            type: 'GET',
            dataType: 'json',
            data: {param1: 'value1'},
            success: function (data) {
                var count = data.length;
                var i = 0;
                if (count > 0){
                }
            }
        });
    }
    function mostrarAlmacenInsumos () {
        var panelOut = '';
        if ($('#pnlOrdenesCompra').is(':visible'))
            panelOut = '#pnlOrdenesCompra';
        else
            panelOut = '#pnlGuiaRemision';
        $('#btnNewOrdenCompra, #btnNewGuiaRemision').addClass('oculto');
        $(panelOut).fadeOut(400, function() {
            $('#pnlListado').fadeIn(400, function() {
                
            });
        });
    }

    function listarInsumosAlmacen () {
        idalmacen = $('#gvAlmacen .tile.selected').attr('data-id');
        precargaExp('#pnlLogistica .colTwoPanel2 .body-panel', true);
        if (idalmacen != null) {
            $.ajax({
                url: 'services/insumos/insumos-search.php',
                type: 'GET',
                cache: false,
                dataType: 'json',
                data: {
                    tipobusqueda:'3', 
                    idalmacen: idalmacen
                },
                success: function (data) {
                    var count = data.length;
                    var i = 0;
                    var strhtml = '';
                    if (count > 0) {
                        while(i < count){
                            strhtml += '<div class="tile double ribbed-lime">';
                            strhtml += '<div class="tile-content">';
                            strhtml += '<p class="fg-darker margin10"><strong>' + data[i].tm_nombre + '</strong></p>';
                            strhtml += '</div>';
                            strhtml += '<div class="tile-status bg-dark">';
                            strhtml += '<h3 class=" margin10 white-text text-right">' + data[i].td_stock + ' ' + data[i].UM + '</h3>';
                            strhtml += '</div>';
                            strhtml += '</div>';
                            ++i;
                        }
                        $('#gvInsumos').html(strhtml);
                    }
                    else
                        $('#gvInsumos').html('<h2><?php $translate->__('No se encontraron resultados.'); ?></h2>');
                    precargaExp('#pnlLogistica .colTwoPanel2 .body-panel', false);
                }
            });
        }
    }
</script>