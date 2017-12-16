$(function () {
	$('#btnNuevo').on('click', function(event) {
		event.preventDefault();
		GoToEdit('0');
	});

	$('#btnNuevoDetalle').on('click', function(event) {
		event.preventDefault();
		openModalCallBack('#pnlRegisterItemDetalle', function () {

    	});
	});

	$('#btnAgregar').on('click', function(event) {
		event.preventDefault();
		var item  = {
			'td_idmedida': '0',

		};
		addItemDetalleEvaluacion(item);
	});
});

var filaItem = 0;

function GoToEdit (idItem) {
    var selectorModal = '#pnlForm';

    document.getElementById('hdIdPrimary').value = '0';

    // precargaExp(selectorModal, true);

    // resetFoto('new');
    // LimpiarForm();
    // resetForm(selectorModal);

    // removeValidFormRegister();
    // addValidFormRegister();

    openModalCallBack(selectorModal, function () {

    });
}

function addItemDetalleEvaluacion (item) {
	var strhtml = '';
	var iditem = item.td_idmedida;
	var medida = item.td_medida;
	var observaciones = item.td_observaciones;

	strhtml += '<input name="itemdetalle[' + filaItem + '][iddetalle]" type="hidden" id="iddetalle' + filaItem + '" value="' + iditem + '" />';
	strhtml += '<input name="itemdetalle[' + filaItem + '][idzonacorporal]" type="hidden" id="idzonacorporal' + filaItem + '" value="' + item.tm_idzonacorporal + '" />';
	strhtml += '<input name="itemdetalle[' + filaItem + '][medida]" type="hidden" id="medida' + filaItem + '" value="' + item.medida + '" />';
	strhtml += '<input name="itemdetalle[' + filaItem + '][observaciones]" type="hidden" id="observaciones' + filaItem + '" value="' + observaciones + '" />';

	strhtml += '<li class="collection-item avatar no-border dato" data-idmodel="' + iditem + '">';

    strhtml += '<span class="title descripcion">' + item.zonacorporal + '</span>';
    strhtml += '<p>Medida: ' + medida + '</span><br>';
    strhtml += '<p>Observaciones: ' + observaciones + '</p>';
    strhtml += '<div class="grouped-buttons place-top-right padding5">';
    strhtml += '<a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="delete" data-delay="50" data-position="bottom" data-tooltip="M&aacute;s"><i class="material-icons">&#xE872;</i></a>';
    strhtml += '</div>';
    strhtml += '<div class="divider"></div>';
    strhtml += '</li>';

    ++filaItem;

    return strhtml;
}