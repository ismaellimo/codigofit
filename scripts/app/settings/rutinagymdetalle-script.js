$(function () {
    $('#gvDatos').on('click', '.mdl-button', function(event) {
        event.preventDefault();
        
        var accion = this.getAttribute('data-action');
        var _row = getParentsUntil(this, '#gvDatos', '.dato');
        
        if (accion == 'edit'){
            var iditem = _row[0].getAttribute('data-id');
            GetDataById(iditem);
        }
        else {
            MessageBox({
                content: '¿Desea eliminar el tipo de ambiente?',
                width: '320px',
                height: '130px',
                buttons: [
                    {
                        primary: true,
                        content: 'Eliminar',
                        onClickButton: function (event) {
                            EliminarItem(_row[0], 'single');
                        }
                    }
                ],
                cancelButton: true
            });
         };
    });

    $('#btnNuevo').on('click', function(event) {
        event.preventDefault();
        GetDataById('0');
    });

    $('#btnGuardar').on('click', function(event) {
        event.preventDefault();
        GuardarDatos();
    });

    $('#btnLimpiar').on('click', function(event) {
        event.preventDefault();
        LimpiarForm();
    });

    $('#txtNombre').on('keydown', function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER){
              $('#chkGrupal').focus();
            return false;
        };
    });

    MostrarDatos();
});

function LimpiarForm () {
    $('#hdIdPrimary').val('0');
    $('#txtCaloriasMinima').val('0');
    $('#txtCaloriasMaxima').val('0');
    $('#txtNombre').val('').focus();
}

function MostrarDatos () {
    $.ajax({
        url: 'services/Rutinagymdetalle/Rutinagymdetalle-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            criterio: ''
        },
        success: function (data) {
            var i = 0;
            var countdata = data.length;
            var strhtml = '';


            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<li class="mdl-list__item dato pos-rel" data-id="' + data[i].tm_idRutinagymdetalle + '">';
                    
                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + data[i].tm_idRutinagymdetalle + '" />';

                    strhtml += '<span class="mdl-list__item-primary-content">' + data[i].tm_nombre + '</span>';
                    strhtml += '<div class="grouped-buttons place-bottom-right padding5 margin5"><a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="edit" data-delay="50" data-position="bottom" data-tooltip="Editar"><i class="material-icons">&#xE254;</i></a><a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="delete" data-delay="50" data-position="bottom" data-tooltip="Eliminar"><i class="material-icons">&#xE872;</i></a></div>';
                    strhtml += '</li>';
                    ++i;
                }
            }
            else
                strhtml = '<h2>No se encontraron resultados.</h2>';

            $('#gvDatos').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function GuardarDatos () {
    var data = new FormData();
    var input_data = $('#modalRegistro :input').serializeArray();

    data.append('btnGuardar', 'btnGuardar');

    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        type: "POST",
        url: 'services/Rutinagymdetalle/Rutinagymdetalle-post.php',
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        dataType: 'json',
        success: function(data){
            createSnackbar(data.titulomsje);
            
            if (data.rpta != '0'){
                closeCustomModal('#modalRegistro');
                MostrarDatos();
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function GetDataById (idData) {
    var selectorModal = '#pnlForm';

    precargaExp(selectorModal, true);


    LimpiarForm();


    openModalCallBack(selectorModal, function () {

        if (idItem == '0') {
            ListarRutinagym_Combo('0');
            ListarZonacorporal_Combo('0');
            ListarEquipo_Combo('0');
            $('#ddlTipoEquipo').focus();

            precargaExp(selectorModal, false);
            }
        else {
            $.ajax({
                type: "GET",
                url: 'services/Rutinagymdetalle/Rutinagymdetalle-getdetails.php',
                cache: false,
                dataType: 'json',
                data: 'id=' + idItem,
                success: function (data) {
                    if (data.length > 0){
                        var foto_original = data[0].tm_foto;
                        var foto_edicion = foto_original.replace("_o", "_s255");

                        $('#hdIdPrimary').val(data[0].tm_idRutinagymdetalle);
                        $("#ddlTipoRutinagymdetalle").val(data[0].ta_tipo_Rutinagymdetalle);
                        $('#txtCantidad').val(data[0].tm_Cantidad);
                        
                        if (foto_original != 'no-set')
                            setFoto(foto_edicion);
                        else
                            foto_edicion = 'images/user-nosetimg-233.jpg';

                        imgFoto.setAttribute('data-src', foto_edicion);
                        hdFoto.value = foto_original;

                        ListarRutinagym_Combo(data[0].tm_idrutinagym);
                        ListarZonacorporal_Combo(data[0].tm_idzonacorporal);
                        ListarEquipo_Combo(data[0].tm_idequipo);
                        
                        $('#ddlTipoRutinagymdetalle').val(data[0].tm_idrutinagym).focus();
                        
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

// function addValidForm () {
//     $('#txtNombre').rules('add', {
//         required: true,
//         maxlength: 150
//     });
// }

// function GuardarDatos () {
//     $('#form1').submit();
// }
function EliminarItem (item, mode) {
    var data = new FormData();
    var id = item.getAttribute('data-id');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdPrimary', id);

    $.ajax({
        type: "POST",
        url: 'services/Rutinagymdetalle/Rutinagymdetalle-post.php',
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        data: data,
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

                    if ($('#gvDatos .dato').length == 0)
                        $('#gvDatos .gridview').html('<h2>No se encontraron registros</h2>');
                });
                
                if (mode == 'multiple'){
                    ++indexList;
                    
                    if (indexList <= elemsSelected.length - 1)
                        EliminarItem(elemsSelected[indexList], mode);
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
        error: function (error) {
            console.log(error);
        }
    });
}

     
function ListarRutinagym_Combo (idrutinagym_default) {
    $.ajax({
        type: 'GET',
        url: 'services/Rutinagym/Rutinagym-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val()
        },
        success: function(data){
            var strhtml = '';
            var countdata = data.length;
            var i = 0;

            if (countdata > 0) {
                while (i < countdata){
                    var _selected = idrutinagym_default == data[i].tm_idrutinagym ? ' selected' : '';
                    strhtml += '<option' + _selected + ' value="' + data[i].tm_idrutinagym + '">' + data[i].tm_nombre + '</option>';
                    ++i;
                };
            };

            $('#ddlRutinagym').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function ListarZonacorporal_Combo (idzonacorporal_default) {
    $.ajax({
        type: 'GET',
        url: 'services/zonacorporal/zonacorporal-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val()
        },
        success: function(data){
            var strhtml = '';
            var countdata = data.length;
            var i = 0;

            if (countdata > 0) {
                while (i < countdata){
                    var _selected = idzonacorporal_default == data[i].tm_idzonacorporal ? ' selected' : '';
                    strhtml += '<option' + _selected + ' value="' + data[i].tm_idzonacorporal + '">' + data[i].tm_nombre + '</option>';
                    ++i;
                };
            };

            $('#ddlZonacorporal').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function ListarEquipo_Combo (idEquipo_default) {
    $.ajax({
        type: 'GET',
        url: 'services/Equipo/Equipo-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val()
        },
        success: function(data){
            var strhtml = '';
            var countdata = data.length;
            var i = 0;

            if (countdata > 0) {
                while (i < countdata){
                    var _selected = idEquipo_default == data[i].tm_idEquipo ? ' selected' : '';
                    strhtml += '<option' + _selected + ' value="' + data[i].tm_idEquipo + '">' + data[i].tm_nombre + '</option>';
                    ++i;
                };
            };

            $('#ddlEquipo').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}