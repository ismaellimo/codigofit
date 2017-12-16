$(function () {
    BuscarDatos('1');

    cargarDatePicker('#txtFechaNacimiento', function (dateText, inst) {
    });

    $('#btnSearch').on('click', function(event) {
        event.preventDefault();

        datagrid.showAppBar(true, 'search');
        $('#txtSearch').focus();
    });

    $('.back-button').on('click', function () {
        $('#btnUnSelectAll').trigger('click');
    });

    $('#generic-actionbar').on('click touchend', 'button', function(event) {
        event.preventDefault();

        var accion = this.getAttribute('data-action');
        
        if (accion == 'delete'){
            MessageBox({
                content: '¿Desea eliminar todo lo seleccionado?',
                width: '320px',
                height: '130px',
                buttons: [
                    {
                        primary: true,
                        content: 'Eliminar',
                        onClickButton: function (event) {
                            Eliminarcliente();
                        }
                    }
                ],
                cancelButton: true
            });
        };
    });

    $('#gvDatos').on('click touchend', '.dropdown a', function(event) {
        event.preventDefault();

        var accion = this.getAttribute('data-action');
        // var parent = this.parentNode.parentNode.parentNode.parentNode;
        var parent = getParentsUntil(this, '#gvDatos', '.dato');
        var idmodel = parent[0].getAttribute('data-idmodel');
        
        if (accion == 'edit')
            GoToEdit(idmodel);
        else if ((accion == 'asistenciacliente') || (accion == 'clasescliente') || (accion == 'evaluacioncliente') || (accion == 'rutinacliente' || accion == 'dietacliente'))
            GoToDetalleCliente(accion);
        else if (accion == 'delete'){
            MessageBox({
                content: '¿Desea eliminar este elemento?',
                width: '320px',
                height: '130px',
                buttons: [
                    {
                        primary: true,
                        content: 'Eliminar',
                        onClickButton: function (event) {
                            EliminarItemcliente(parent[0], 'single');
                        }
                    }
                ],
                cancelButton: true
            });
        };
    });

    $('#tabDetalleCliente .mdl-tabs__tab-bar').on('click', '.mdl-tabs__tab span', function(event) {
        var accion = this.parentNode.getAttribute('href');
        if (accion !== null)
            navigateInFrame(accion + ' .mdl-tabs__panel-content', '?pag=admin&subpag=' + accion.substr(1) + '&op=list');
    });

    $('#btnNuevo').on('click', function (event) {
        event.preventDefault();
        GoToEdit('0');
    });

    $('#btnGuardar').on('click', function (event) {
        event.preventDefault();
        GuardarDatos();
    });

    $('#form1').validate({
        lang: 'es',
        errorElement : 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement)
                $(placement).append(error);
            else
                error.insertAfter(element);
        }
    });
});

var indexList = 0;
var elemsSelected;
var progress = 0;
var progressError = false;
var datagrid = new DataList('#gvDatos', {
    onSearch: function () {
        BuscarDatos(datagrid.currentPage());
    }
});

function LimpiarForm () {
    $('#hdIdPrimary').val('');
    $('#txtnroDNI').val('');
    $('#rbSexo__Masculino')[0].checked = true;
    $('#txtFechaNacimiento').val('');
    $('#txtApellidos').val('');
    $('#txtNombres').val('');
    $('#txtTelefono').val('');
    $('#txtCelular').val('');    
    $('#txtEmail').val('');
    $('#txtFacebook').val('');
}

function removeValidFormRegister () {
    $('#txtnroDNI').rules('remove');
    $('#txtFechaNacimiento').rules('remove');
    $('#txtNombres').rules('remove');
    $('#txtApellidos').rules('remove');
    $('#txtCelular').rules('remove');
    $('#txtEmail').rules('remove');
}

function addValidFormRegister () {
    $('#txtnroDNI').rules('add', {
        required: true
    });

    $('#txtFechaNacimiento').rules('add', {
        required: true
    });

    $('#txtNombres').rules('add', {
        required: true
    });

    $('#txtApellidos').rules('add', {
        required: true
    });

    $('#txtCelular').rules('add', {
        required: true
    });

    $('#txtEmail').rules('add', {
        required: true,
        email: true
    });
}

function GoToEdit (idItem) {
    var selectorModal = '#pnlForm';

    document.getElementById('hdIdPrimary').value = '0';
    document.getElementById('hdFoto').value = 'no-set';

    precargaExp(selectorModal, true);

    resetFoto('new');
    LimpiarForm();
    // resetForm(selectorModal);

    removeValidFormRegister();
    addValidFormRegister();

    openModalCallBack(selectorModal, function () {

        if (idItem == '0')
            precargaExp(selectorModal, false);
        else {
            $.ajax({
                type: "GET",
                url: 'services/clientes/cliente-getdetails.php',
                cache: false,
                dataType: 'json',
                data: 'id=' + idItem,
                success: function (data) {
                    if (data.length > 0){
                        var foto_original = data[0].tm_foto;
                        var foto_edicion = foto_original.replace("_o", "_s255");

                        $('#hdIdPrimary').val(data[0].tm_idcliente);
                        $('#txtNombres').val(data[0].tm_nombres);
                        $('#txtApellidos').val(data[0].tm_apellidos);
                        $('#txtnroDNI').val(data[0].tm_nrodni);
                        $('#txtFechaNacimiento').val(ConvertMySQLDate(data[0].tm_fechanac));
                        // $('#txtSexo').val(data[0].tm_sexo);

                        $('#rbSexo__Masculino')[0].checked = data[0].tm_sexo == '1' ? true : false;
                        $('#rbSexo__Femenino')[0].checked = data[0].tm_sexo == '1' ? false : true;

                        $('#txtTelefono').val(data[0].tm_telefono);
                        $('#txtCelular').val(data[0].tm_celular);
                        $('#txtEmail').val(data[0].tm_email);
                        $('#txtFacebook').val(data[0].tm_facebook);

                        if (foto_original != 'no-set')
                            setFoto(foto_edicion);
                        else
                            foto_edicion = 'images/user-nosetimg-233.jpg';

                        imgFoto.setAttribute('data-src', foto_edicion);
                        $('#hdFoto').val(foto_original);

                        $('#txtnroDNI').val(data[0].tm_nrodni).focus();
                        
                        Materialize.updateTextFields();
                    };
                    
                    precargaExp(selectorModal, false);
                },
                error: function (data) {
                    console.log(data);
                }
            });
        };
    });
}

function BuscarDatos (pagina) {
    var selectorgrid = '#gvDatos';
    var selector = selectorgrid + ' .gridview-content';

    precargaExp('#pnlListado', true);
    
    $.ajax({
        type: "GET",
        url: "services/cliente/cliente-search.php",
        cache: false,
        dataType: 'json',
        data: {
            criterio: $('#txtSearch').val(),
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            pagina: pagina
        },
        success: function(data){
            var countdata = data.length;
            var i = 0;
            var strhtml = '';

            if (countdata > 0){
                while(i < countdata){
                    var iditem = data[i].tm_idcliente;
                    var foto = data[i].tm_foto.replace('_o', '_s42');

                    strhtml += '<li class="collection-item avatar no-border dato" data-idmodel="' + iditem + '"  data-baselement="' + selectorgrid + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';

                    strhtml += '<i class="icon-select material-icons circle white-text">done</i><div class="layer-select"></div>';

                    if (foto == 'no-set')
                        strhtml += '<i class="material-icons circle">&#xE853;</i>';
                    else
                        strhtml += '<img src="' + foto + '" alt="" class="circle">';

                    strhtml += '<span class="title descripcion"> Nombres: ' + data[i].tm_nombres + '</span>';
                    
                    strhtml += '<p>Apellidos: ' + data[i].tm_apellidos + ' - DNI: <span class="dni">' + data[i].tm_nrodni + '</span><br>';

                    strhtml += '<p>Celular: ' + data[i].tm_celular + ' - Teléfono fijo: <span class="Fijo">' + data[i].tm_telefono + '</span><br>';

                    strhtml += '<span class="correo">Correo: ' + data[i].tm_email + '</span> - Facebook: ' + data[i].tm_facebook + '</p>';

                    strhtml += '<div class="grouped-buttons place-top-right padding5">';
                    
                    strhtml += '<a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="more" data-delay="50" data-position="bottom" data-tooltip="M&aacute;s"><i class="material-icons md-18">&#xE5D4;</i></a>';

                    strhtml += '<ul class="dropdown"><li><a href="#" data-action="edit" class="waves-effect">Editar</a></li><li><a href="#" data-action="asistenciacliente" class="waves-effect">Asistencia</a></li><li><a href="#" data-action="clasescliente" class="waves-effect">Clases</a></li><li><a href="#" data-action="evaluacioncliente" class="waves-effect">Evaluaci&oacute;n</a></li><li><a href="#" data-action="rutinacliente" class="waves-effect">Rutinas</a></li><li><a href="#" data-action="dietacliente" class="waves-effect">Dietas</a></li><li><a href="#" data-action="delete" class="waves-effect">Eliminar</a></li></ul>';

                    strhtml += '</div>';

                    strhtml += '<div class="divider"></div>';
                    
                    strhtml += '</li>';

                    ++i;
                };

                datagrid.currentPage(datagrid.currentPage() + 1);

                if (pagina == '1')
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);

                //$(selector + ' .grouped-buttons a.tooltipped').tooltip();
            }
            else {
                if (pagina == '1')
                    $(selector).html('<h2>No se encontraron resultados.</h2>');
            };
            
            precargaExp('#pnlListado', false);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function GuardarDatos () {
    var hdFoto = document.getElementById('hdFoto');
    var file = fileValue;
    var data = new FormData();

    if ($('#form1').valid()) {
         precargaExp('#pnlForm', true);

        if (hdFoto.value == 'images/user-nosetimg-233.jpg')
            hdFoto.value = 'no-set';

        data.append('btnGuardar', 'btnGuardar');
        data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
        data.append('hdIdcentro', $('#hdIdCentro').val());
        data.append('archivo', file);

        var input_data = $('#pnlForm :input').serializeArray();

        Array.prototype.forEach.call(input_data, function(fields){
            data.append(fields.name, fields.value);
        });

        $.ajax({
            type: "POST",
            url: 'services/cliente/cliente-post.php',
            contentType:false,
            processData:false,
            cache: false,
            data: data,
            dataType: 'json',
            success: function(data){
                precargaExp('#pnlForm', false);
                //showSnackbar({ message: data.titulomsje });
                createSnackbar(data.titulomsje);
                
                if (Number(data.rpta) > 0){
                    // removeValidFormRegister();
                    closeCustomModal('#pnlForm');
                    paginaGeneral = 1;
                    BuscarDatos('1');
                };
            },
            error: function (data) {
                console.log(data);
            }
        });
    };
}

function Eliminarcliente () {
    indexList = 0;
    elemsSelected = $('#gvDatos .selected');
    EliminarItemcliente(elemsSelected[0], 'multiple');
}

function EliminarItemcliente (item, mode) {
    var data = new FormData();
    var idmodel = item.getAttribute('data-idmodel');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdCliente', idmodel);

    $.ajax({
        url: 'services/cliente/cliente-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function(data){
            var titulomsje = '';
            var endqueue = false;

            if (data.rpta == '0'){
                endqueue = true;
                titulomsje = 'No se puede eliminar';
            }
            else {
                $(item).fadeOut(400, function() {
                    $(this).remove();
                });
                
                if (mode == 'multiple'){
                    ++indexList;
                    
                    if (indexList <= elemsSelected.length - 1)
                        EliminarItemcliente(elemsSelected[indexList], mode);
                    else {
                        endqueue = true;
                        titulomsje = data.titulomsje;
                    };
                }
                else if (mode == 'single') {
                    endqueue = true;
                    titulomsje = data.titulomsje;
                };
            };
            
            if (endqueue) {
                createSnackbar(titulomsje);
                if ($('.actionbar').hasClass('is-visible'))
                    $('.back-button').trigger('click');
            };
        },
        error:function (data){
            console.log(data);
        }
    });
}

function Buscar () {
    BuscarDatos('1');
}


function navigateInFrame(selector, page) {
    var idFrame = 'ifr' + page;
    var frameActive = document.getElementById(idFrame);

    if (frameActive === null){

        var _frame = document.createElement('iframe');
        _frame.setAttribute('id', idFrame);
        _frame.setAttribute('scrolling', 'no');
        _frame.setAttribute('marginwidth', '0');
        _frame.setAttribute('marginheight', '0');
        _frame.setAttribute('width', '100%');
        _frame.setAttribute('height', '100%');
        _frame.setAttribute('frameborder', 'no');
        _frame.setAttribute('src', page);

        _frame.addEventListener('load', function(event){
            // var fd = this.document || this.contentWindow;
        });

        $(selector).append(_frame);
    };
}

function GoToDetalleCliente (accion) {
    openModalCallBack('#pnlDetalleCliente', function () {
        $('#tabDetalleCliente .mdl-tabs__tab-bar .mdl-tabs__tab[href="#' + accion + '"] span').trigger('click');
    });
}