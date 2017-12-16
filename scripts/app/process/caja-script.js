$(function () {

    $('#hdFechaHoraApertura').val(moment().format('DD/MM/YYYY hh:mm:ss'));
    $('#lblFechaHoraApertura').val(moment().format('DD/MM/YYYY hh:mm:ss'));

    var operators = ['+', '-', 'x', '÷'];
    var operations = ['clientes', 'atencion', 'ventas', 'compras', 'menu', 'ver-caja', 'operar-caja', 'imprimir', 'cobrar'];
    var decimalAdded = false;

    $('#gvArticuloMenu').on('click', 'a', function(event) {
        event.preventDefault();
        if (this.getAttribute('data-action') == 'delete')
            eliminarArticulo(this);
    });

    $('#txtImporteApertura').on('focus', function(event) {
        event.preventDefault();
        this.select();
    });

    ComprobarApertura();

    $('#ddlPaisCliente').on('change', function(event) {
        event.preventDefault();
        ListarUbicacion('#ddlRegionCliente', this.value, '0');
    }).trigger('change');

    $('#chkClienteDefault').on('change', function(event) {
        event.preventDefault();
        
        var flag = this.checked;

        habilitarOptionCliente(!flag);

        if (flag == false) {
            $('#rbObtenerCliente').prop('checked', true);

            habilitarControl('#txtSearchCliente', true);
            habilitarClienteNatural(false);
            habilitarClienteJuridico(false);
            habilitarControl('#ddlTipoDocCliente,#txtNroDocCliente,#txtDireccionCliente,#txtTelefonoCliente,#txtEmailCliente', false);

            // if ($('#rbObtenerCliente')[0].checked) {

            //     habilitarControl('#txtSearchCliente', true);
            //     habilitarClienteNatural(false);
            //     habilitarClienteJuridico(false);
            //     habilitarControl('#ddlTipoDocCliente,#txtNroDocCliente,#txtDireccionCliente,#txtTelefonoCliente,#txtEmailCliente', false);
            // }
            // else {
            //     habilitarControl('#txtSearchCliente', false);

            //     if ($('#hdTipoCliente').val() == 'NA') {
            //         habilitarClienteNatural(true);
            //         habilitarClienteJuridico(false);
            //     }
            //     else {
            //         habilitarClienteNatural(false);
            //         habilitarClienteJuridico(true);
            //     };
                
            //     habilitarControl('#ddlTipoDocCliente,#txtNroDocCliente,#txtDireccionCliente,#txtTelefonoCliente,#txtEmailCliente', true);
            // };
        }
        else {
            habilitarControl('#txtSearchCliente', false);
            habilitarClienteNatural(false);
            habilitarClienteJuridico(false);
            habilitarControl('#ddlTipoDocCliente,#txtNroDocCliente,#txtDireccionCliente,#txtTelefonoCliente,#txtEmailCliente', false);
        };
    });

    $('input:radio[name="rbRegCliente"]').on('change', function(event) {
        habilitarModuloCliente(this.value);
    });

    $("#txtSearchCliente").easyAutocomplete({
        url: function (phrase) {
            var _url = 'services/clientes/clientes-autocomplete.php';
            
            _url += '?idempresa=' + $('#hdIdEmpresa').val();
            _url += '&idcentro=' + $('#hdIdCentro').val();
            _url += '&tipobusqueda=3';
            _url += '&criterio=' + phrase;

            return _url;
        },
        getValue: function (element) {
            return element.tm_numerodoc.toLowerCase() +  ' - ' + element.Descripcion;
        },
        list: {
            onSelectItemEvent: function () {
                var value = $("#txtSearchCliente").getSelectedItemData().tm_idtipocliente;

                $("#hdIdCliente").val(value).trigger("change");
            }
        },
        template: {
            type: "custom",
            method: function (value, item) {
                return item.tm_numerodoc.toLowerCase() +  ' - ' + item.Descripcion;
            }
        },
        theme: "square"
    });

    $('#btnChooseTipoItem').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();

        $('#mnuTipoItem').addClass('is-visible');
    });

    $('#mnuTipoItem').on('click', 'a', function (event) {
        var tipoitem = this.getAttribute('data-tipoitem');

        if (tipoitem == '00'){
            $('#pnlSearchArticulo, #gvInsumo').removeClass('hide');
            $('#pnlSearchServicio, #gvServicio').addClass('hide');
        }
        else {
            $('#pnlSearchArticulo, #gvInsumo').addClass('hide');
            $('#pnlSearchServicio, #gvServicio').removeClass('hide');


        };

        $('#btnChooseTipoItem').find('.text').text(this.innerHTML).end().attr('data-tipoitem', tipoitem);
        $('#mnuTipoItem').removeClass('is-visible');
    });

    $('#ddlTurnoApertura').on('change', function(event) {
        event.preventDefault();
        ListarPersonalPorTurno($(this).val());
    });

    $('.calc').on('click', 'button', function(event) {
        event.preventDefault();
        var input = document.getElementsByClassName('screen')[0];
        var inputVal = input.value;
        var btnVal = this.getAttribute('data-value');
        var btnAction = this.getAttribute('data-action');

        if (operations.indexOf(btnVal) > -1){
            if (btnVal == 'ver-caja') {
                $('.lblFechaHoy').text(GetToday());

                openModalCallBack('#pnlCajaActual', function () {
                });
            }
            else if (btnVal == 'operar-caja'){
                if (btnAction == 'abrir') {
                    $('#ddlMonedaApertura')[0].selectedIndex = 0;
                    $('#txtImporteApertura').val('0.00');

                    openModalCallBack('#pnlAperturaCaja', function () {
                        ListarPersonalPorTurno($('#ddlTurnoApertura').val());
                    });
                }
                else
                    openCustomModal('#pnlCierreCaja');
            }
            else if (btnVal == 'cobrar')
                GestionarCobranza();
            else if (btnVal == 'menu') {
                openModalCallBack('#pnlProductos', function () {

                    ListarInsumos('1');
                    ListarServicios('1');
                });
            }
            else {
                var module_id = config[btnVal].id;
                
                var _btnOpcionMenu = $('.mdl-card[data-id="' + module_id + '"]', window.top.document);

                _btnOpcionMenu.attr('data-idcajareferer', $('#hdIdAperturaCaja').val()).trigger('click');
            };
        }
        else {
            if(btnVal == 'C') {
                input.value = '';
                decimalAdded = false;
            }
            else if(btnVal == '=') {
                var equation = inputVal;
                var lastChar = equation[equation.length - 1];
                
                equation = equation.replace(/x/g, '*').replace(/÷/g, '/');

                if(operators.indexOf(lastChar) > -1 || lastChar == '.')
                    equation = equation.replace(/.$/, '');

                if(equation)
                    input.value = eval(equation);

                decimalAdded = false;
            }
            else if(operators.indexOf(btnVal) > -1) {
                var lastChar = inputVal[inputVal.length - 1];
                
                if(inputVal != '' && operators.indexOf(lastChar) == -1) 
                    input.value += btnVal;
                else if(inputVal == '' && btnVal == '-') 
                    input.value += btnVal;

                if(operators.indexOf(lastChar) > -1 && inputVal.length > 1)
                    input.value = inputVal.replace(/.$/, btnVal);

                decimalAdded =false;
            }
            else if(btnVal == '.') {
                if(!decimalAdded) {
                    input.value += btnVal;
                    decimalAdded = true;
                };
            }
            else {
                var moneda = this.getAttribute('data-idmoneda');

                if (moneda != null)
                    input.value = btnVal;
                else
                    input.value += btnVal;
            };

            calcularCambio(input.value);
        };
    });

    $('#gvServicio tbody').on('scroll', function(event){
        gvServicio.listenerScroll(this, event);
    });

    $('#gvInsumo tbody').on('scroll', function(event){
        gvInsumo.listenerScroll(this, event);
    });

    $('#gvServicio tbody').on('click', 'input:checkbox', function(event) {
        if (this.checked) {

            habilitarControl('#btnAddItemsVenta', true);
        }
        else {

            if ($('#gvServicio input:checked').length == 0)
                habilitarControl('#btnAddItemsVenta', false);
        };
    });

    $('#gvInsumo tbody').on('click', 'input:checkbox', function(event) {
        var _row = getParentsUntil(this, '#gvInsumo', 'tr');
        
        var _selectPresentacion = _row[0].getElementsByClassName('select-presentacion')[0];
        var _inputCantidad = _row[0].getElementsByClassName('cantidad')[0];
        var _inputPrecio = _row[0].getElementsByClassName('precio')[0];
        var _inputSubtotal = _row[0].getElementsByClassName('subtotal')[0].getElementsByTagName('input')[0];
        var _labelSubtotal = _row[0].getElementsByTagName('h4')[0];

        if (this.checked) {
            _selectPresentacion.removeAttribute('disabled');
            _inputCantidad.removeAttribute('disabled');
            _inputPrecio.removeAttribute('disabled');
            _labelSubtotal.classList.remove('grey-text');
            _inputCantidad.focus();

            habilitarControl('#btnAddItemsVenta', true);
        }
        else {
            _selectPresentacion.setAttribute('disabled', '');
            _inputCantidad.setAttribute('disabled', '');
            _inputCantidad.value = '';
            _inputPrecio.value = '';
            _inputSubtotal.value = '';
            _inputPrecio.setAttribute('disabled', '');
            _labelSubtotal.classList.add('grey-text');
            _labelSubtotal.innerHTML = '0.00';

            if ($('#gvInsumo input:checked').length == 0)
                habilitarControl('#btnAddItemsVenta', false);
        };
    });

    $('#gvInsumo tbody').on('keyup', 'input[type="number"]', function(event) {
        var _input = event.target;
        var precio = 0;
        var cantidad = 0;
        var _row = getParentsUntil(_input, '#gvInsumo', 'tr');
        
        _row = _row[0];

        if (_input.classList.contains('cantidad')) {
            cantidad = _input.value;
            precio = _row.getElementsByClassName('precio')[0].value;
        }
        else {
            cantidad = _row.getElementsByClassName('cantidad')[0].value;
            precio = _input.value;
        };

        var subtotal = cantidad * precio;

        var field_subtotal = _row.getElementsByClassName('subtotal')[0];
        field_subtotal.getElementsByTagName('input')[0].value = subtotal.toFixed(2);
        field_subtotal.getElementsByTagName('h4')[0].innerHTML = subtotal.toFixed(2);
    });

    // $('#tabAddItemsCompra').on('click', '.mdl-tabs__tab', function(event) {
    //     var _tab = this;
    //     var accion = _tab.hash.substring(1);
    //     var flag = false;

    //     if (accion == 'rogers-panel') {
    //         flag = true;
    //         $('.mdl-textfield--expandable').addClass('hide');
    //     }
    //     else {
    //         $('.mdl-textfield--expandable').removeClass('hide');
    //         flag = false;

    //         ListarInsumos('1');
    //     };

    //     habilitarControl('#btnAddItemsVenta', flag);
    // });

    $('#btnAddItemsVenta').on('click', function(event) {
        event.preventDefault();

        // alert($('#btnChooseTipoItem').attr('data-tipoitem'));

        if ($('#btnChooseTipoItem').attr('data-tipoitem') == '00')
            AgregarItemsVenta();
        else
            AgregarServicio();
    });

    $('#btnInfoOrden').on('click', function(event) {
        event.preventDefault();
        if ($(this).hasClass('active')) {
            $(this).removeClass('active').attr('data-tooltip', 'M&aacute;s informaci&oacute;n').html('<i class="left material-icons">&#xE88E;</i> M&aacute;s informaci&oacute;n');

            $('#pnlInfoOrden').fadeOut(300, function () {
                $('#pnlDetalleOrden').fadeIn(300, function () {
                    
                });
            });
        }
        else {
            $(this).addClass('active').attr('data-tooltip', 'Volver al detalle de orden').html('<i class="left material-icons">&#xE5C4;</i> Volver al detalle de orden');

            $('#pnlDetalleOrde.end()n').fadeOut(300, function () {
                $('#pnlInfoOrden').fadeIn(300, function () {
                    
                });
            });
        };
    });

    $('#btnCobrar').on('click', function(event) {
        event.preventDefault();

        var _mediopago = $('#hdMedioPago').val();

        if (_mediopago == '2') {
            if ($('#rbObtenerCliente')[0].checked) {

                if ($('#hdIdCliente').val() == '0') {
                    MessageBox({
                        title: 'TAMBOAPP dice',
                        content: 'Cuando se trata de compra al cr&eacute;dito, se debe seleccionar alg&uacute;n cliente para continuar',
                        width: '320px',
                        height: '260px',
                        cancelButton: true
                    });

                    return false;
                };
            }
            else {
                if (!$('#form1').valid()) {
                    MessageBox({
                        title: 'TAMBOAPP dice',
                        content: 'Cuando se trata de compra al cr&eacute;dito, se debe ingresar la informaci&oacute;n de cliente para continuar',
                        width: '320px',
                        height: '260px',
                        cancelButton: true
                    });
                    
                    return false;
                };
            };
        };

        GuardarCobranza();
    });

    $('#btnImprimir').on('click', function(event) {
        event.preventDefault();
        window.print();
    });

    $('#chkPagoTarjeta').on('change', function(event) {
        var monto_tarjeta = 0;
        
        if (this.checked) {
            var monto_pago = Number($('#lblTotalPago .monto').text());
            var monto_cobro = Number($('#lblTotalCobro .monto').text());
            monto_tarjeta = (monto_pago > 0 ? (monto_cobro - monto_pago) : monto_cobro);
        };

        $('#txtImporteTarjeta').val(monto_tarjeta.toFixed(2));
    });

    $('#datetimepickerFHA').datetimepicker({
        inline: true,
        locale: 'es',
        format: 'DD/MM/YYYY hh:mm A'
    });

    $('#btnCloseFechaHoraApertura').on('click', function(event) {
        event.preventDefault();
        toggleOptions_v2('#pnlFechaHora', 'left');
    });

    $('#btnMostrarFechaHoraApertura').on('click', function(event) {
        event.preventDefault();
        toggleOptions_v2('#pnlFechaHora', 'left');
    });

    $('#btnEstablecerFechaHoraApertura').on('click', function(event) {
        event.preventDefault();
        
        var _fechahoraApertura = $('#datetimepickerFHA').data('date');

        $('#lblFechaHoraApertura').text(_fechahoraApertura);
        $('#hdFechaHoraApertura').val(_fechahoraApertura);
        
        toggleOptions_v2('#pnlFechaHora', 'left');
    });

    $('#btnRegistrarApertura').on('click', function(event) {
        event.preventDefault();
        RegistrarAperturaCaja();
    });

    $('#btnRegistrarMovCaja').on('click', function(event) {
        event.preventDefault();
        RegistrarMovCaja();
    });

    $('#btnCerrarCaja').on('click', function(event) {
        event.preventDefault();

        MessageBox({
            content: '¿Desea cerrar caja?',
            width: '320px',
            height: '130px',
            buttons: [
                {
                    primary: true,
                    content: 'Cerrar caja',
                    onClickButton: function (event) {
                        CerrarCaja();
                    }
                }
            ],
            cancelButton: true
        });
    });

    $('#pnlCajaActual .btn-group').on('click', 'button', function(event) {
        event.preventDefault();

        var tipomov = this.getAttribute('data-tipomov');

        $(this).siblings('.btn-primary').removeClass('btn-primary');
        $(this).addClass('btn-primary');

        AperturaByDefault();
    });

    $('#btnAddMovimiento').on('click', function(event) {
        event.preventDefault();
        openCustomModal('#pnlRegMovimientoCaja');
    });

    $("#txtSearchPersonal").easyAutocomplete({
        url: function (phrase) {
            return "services/organigrama/organigrama-search.php?criterio=" + phrase + "&tipobusqueda=1&idempresa=" + $('#hdIdEmpresa').val() + "&idcentro=" + $('#hdIdCentro').val();
        },
        getValue: function (element) {
            return element.tm_nrodni.toLowerCase() +  ' - ' + element.tm_apellidopaterno + ' ' + element.tm_apellidomaterno;
        },
        list: {
            onSelectItemEvent: function () {
                var value = $("#txtSearchPersonal").getSelectedItemData().tm_idpersonal;

                $("#hdIdPersona").val(value).trigger("change");
            }
        },
        template: {
            type: "custom",
            method: function (value, item) {
                return item.tm_nrodni.toLowerCase() +  ' - ' + item.tm_apellidopaterno + ' ' + item.tm_apellidomaterno;
            }
        },
        theme: "square"
    });
});

var filaArticulo = 0;

var messagesValid = {
    txtNroDocCliente: {
        required: "El número de documento es obligatorio"
        // remote: "Este n&uacute;mero de documento ya existe"
    }
};

var gvInsumo = new DataList('#gvInsumo', {
    onSearch: function () {
        ListarInsumos(gvInsumo.currentPage());
    }
});

var gvServicio = new DataList('#gvServicio', {
    onSearch: function () {
        ListarServicios(gvServicio.currentPage());
    }
});

function addValidCliente () {
    $('#txtNroDocCliente').rules('add', {
        required: true
    });

    $('#txtEmailCliente').rules('add', {
        required: true,
        email: true
    });
}

function addValidCliente_Natural () {
    $('#txtApePaternoCliente').rules('add', {
        required: true
    });

    $('#txtApeMaternoCliente').rules('add', {
        required: true
    });

    $('#txtNombresCliente').rules('add', {
        required: true
    });
}

function addValidCliente_Juridica () {
    $('#txtRazonSocialCliente').rules('add', {
        required: true
    });
}

function habilitarModuloCliente (manejador) {
    if (manejador == 'GET') {
        habilitarControl('#txtSearchCliente', true);

        habilitarClienteNatural(false);
        habilitarClienteJuridico(false);

        habilitarControl('#ddlTipoDocCliente,#txtNroDocCliente,#txtDireccionCliente,#txtTelefonoCliente,#txtEmailCliente', false);
    }
    else {
        habilitarControl('#txtSearchCliente', false);

        if ($('#hdTipoCliente').val() == 'NA') {
            habilitarClienteNatural(true);
            habilitarClienteJuridico(false);
        }
        else {
            habilitarClienteNatural(false);
            habilitarClienteJuridico(true);
        };

        habilitarControl('#ddlTipoDocCliente,#txtNroDocCliente,#txtDireccionCliente,#txtTelefonoCliente,#txtEmailCliente', true);
    };
}

function ListarAperturas () {
    $.ajax({
        type: 'GET',
        url: 'services/ventas/aperturacaja-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '3',
            fecha: GetToday()
        },
        success: function (data) {
            var i = 0;
            var countdata = data.length;
            var strhtml = '';

            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<tr>';
                    strhtml += '<td>' + (i + 1) + '</td>';
                    strhtml += '<td>' + data[i].tm_apellidopaterno + ' ' + data[i].tm_apellidomaterno + ' ' + data[i].tm_nombres + '</td>';
                    strhtml += '<td>' + data[i].NombreMoneda + '</td>';
                    strhtml += '<td>' + data[i].tm_monto_inicial + '</td>';
                    strhtml += '<td>' + data[i].tm_monto_final + '</td>';
                    strhtml += '<td>' + data[i].Turno + '</td>';
                    strhtml += '<td>' + data[i].Estado + '</td>';
                    strhtml += '</tr>';
                    ++i;
                };
            };
            $('#tableAperturaDia tbody').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function RegistrarAperturaCaja () {
    var data = new FormData();
    var input_data = $('#pnlAperturaCaja :input').serializeArray();

    data.append('btnRegistrarApertura', 'btnRegistrarApertura');

    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        type: 'POST',
        url: 'services/ventas/caja-post.php',
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        data: data,
        success: function(data){
            createSnackbar(data.titulomsje);

            if (data.rpta != '0'){
                closeCustomModal('#pnlAperturaCaja');
                AperturaByDefault();
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function RegistrarMovCaja () {
    var data = new FormData();
    var input_data = $('#pnlRegMovimientoCaja :input').serializeArray();

    data.append('btnRegistrarMovCaja', 'btnRegistrarMovCaja');
    data.append('hdIdAperturaCaja', $('#hdIdAperturaCaja').val());
    data.append('hdIdPersona', $('#hdIdPersona').val());
    data.append('hdIdMoneda', $('#hdIdMoneda').val());
    data.append('hdTipoDataPersona', $('#hdTipoDataPersona').val());

    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        type: 'POST',
        url: 'services/ventas/caja-post.php',
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        data: data,
        success: function(data){
            createSnackbar(data.titulomsje);

            if (data.rpta != '0'){
                $('#pnlCajaActual .btn-group button.btn-primary').removeClass('btn-primary');
                $('#pnlCajaActual .btn-group button[data-tipomov="' + $('#ddlTipoMovimiento').val() + '"]').addClass('btn-primary');

                closeCustomModal('#pnlRegMovimientoCaja');
                AperturaByDefault();
            };
        }
    });
}

function CerrarCaja () {
    var data = new FormData();
    var input_data = $('#pnlCierreCaja :input').serializeArray();
    
    data.append('btnCerrarCaja', 'btnCerrarCaja');
    data.append('hdIdAperturaCaja', $('#hdIdAperturaCaja').val());

    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        url: 'services/ventas/caja-post.php',
        type: 'POST',
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        data: data,
        success: function(data){
            createSnackbar(data.titulomsje);

            if (data.rpta != '0'){
                closeCustomModal('#pnlCierreCaja');
                $('#pnlCajaActual .btn-group button').removeClass('btn-primary').first().trigger('click');
                
                AperturaByDefault();
                habilitarCaja(false);
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function habilitarOptionCliente (flag) {
    habilitarControl('input:radio[name="rbRegCliente"]', flag);
}

function habilitarClienteNatural (flag) {
    habilitarControl('.rowClienteNatural input:text', flag);
}

function habilitarClienteJuridico (flag) {
    habilitarControl('.rowClienteJuridico input:text', flag);
}

function LimpiarCobranza () {
    $('#ddlNombreTarjeta')[0].selectedIndex = 0;
    $('#txtNumeroTarjeta').val('');
    $('#txtImporteTarjeta').val('');
    $('#hdIdCliente').val('0');
    $('#ddlTipoDocCliente')[0].selectedIndex = 0;
    $('#txtNroDocCliente').val('');
    $('#txtApePaternoCliente').val('');
    $('#txtApeMaternoCliente').val('');
    $('#txtNombresCliente').val('');
    $('#txtRazonSocialCliente').val('');
    $('#txtDireccionCliente').val('');
    $('#txtTelefonoCliente').val('');
    $('#txtEmailCliente').val('');

    habilitarControl('#btnCobrar', true);
    habilitarControl('#btnImprimir', false);
}

function MostrarPanelCobranza () {
    LimpiarCobranza();

    if (Number($('#lblTotalPago .monto').text()) == 0) {
        var total_cobro = $('#lblTotalCobro .monto').text();
        
        $('#lblTotalPago .monto').text(total_cobro);
        $('#lblEfectivoPago').text(total_cobro);
    };

    openModalCallBack('#pnlCobranza', function () {
        habilitarOptionCliente(!$('#chkClienteDefault')[0].checked);
    });

    // openModalCallBack('#modalImpresion', function () {
    //     $('#ifrImpresionComprobante').attr('src', 'media/pdf/modelo-factura.pdf');
    // });
}

function MostrarTipoDocCliente (codigotributable) {
    $.ajax({
        url: 'services/documentos/documentos-tributables.php',
        type: 'GET',
        dataType: 'json',
        data: {codigotributable: codigotributable},
        success: function (data) {
            var strhtml = '';
            var i = 0;
            var countdata = data.length;

            if (countdata > 0) {
                while(i < countdata){
                    strhtml += '<option value="' + data[i].tm_iddocident + '">' + data[i].tm_descripcion + '</option>';
                    ++i;
                };
            }
            else
                strhtml = '<option value="0">No hay tipos de documento para este tipo de cliente.</option>';

            $('#ddlTipoDocCliente').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function GestionarCobranza () {
    $.ajax({
        url: 'services/tipocomprobante/tipocomprobante-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipo: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            criterio: ''
        },
        success: function (data) {
            var i = 0;
            var countdata = data.length;
            var strhtml = '';

            if (countdata > 0) {
                while (i < countdata) {
                    var _checked = (i == 0 ? ' checked' : '');

                    strhtml += '<p><input class="with-gap" name="rbTipoComprobante" data-impuesto="' + data[i].tm_porcjimpuesto + '" type="radio" id="rbTipoComprobante' + data[i].tm_idtipocomprobante + '" value="' + data[i].tm_idtipocomprobante + '"' + _checked + ' /><label for="rbTipoComprobante' + data[i].tm_idtipocomprobante + '">' + data[i].tm_nombre + '</label></p>';
                    ++i;
                };

                strhtml += '<h5>Medio de pago</h5>';

                strhtml += '<p><input class="with-gap" name="rbMedioPago" type="radio" id="rbMedioPago1" value="1" checked /><label for="rbMedioPago1">MEDIOS DE PAGO</label></p>';

                strhtml += '<p><input class="with-gap" name="rbMedioPago" type="radio" id="rbMedioPago2" value="2" /><label for="rbMedioPago2">CR&Eacute;DITO PERSONAL</label></p>';

                strhtml = '<div class="scrollbarra">' + strhtml + '</div>';

                MessageBox({
                    title: 'Seleccione tipo de comprobante',
                    content: strhtml,
                    width: '320px',
                    height: '390px',
                    buttons: [
                        {
                            primary: true,
                            content: 'Continuar',
                            onClickButton: function (event) {
                                var _rbTipoComprobante = $('input[name="rbTipoComprobante"]:checked').val();
                                var _valorImpuesto = $('input[name="rbTipoComprobante"]:checked').attr('data-impuesto');
                                
                                $('#hdTipoComprobante').val(_rbTipoComprobante);

                                var _rbMedioPago = $('input[name="rbMedioPago"]:checked').val();
                                $('#hdMedioPago').val(_rbMedioPago);

                                // alert(_rbMedioPago);

                                if (_rbMedioPago == '2'){
                                    $('#chkClienteDefault').prop('checked', false);

                                    $('#rbObtenerCliente').prop('checked', true);

                                    habilitarControl('#txtSearchCliente', true);
                                    habilitarClienteNatural(false);
                                    habilitarClienteJuridico(false);
                                    habilitarControl('#ddlTipoDocCliente, #txtNroDocCliente, #txtDireccionCliente, #txtTelefonoCliente, #txtEmailCliente', false);

                                    addValidCliente();

                                    $('#tabcob_2 span').trigger('click');
                                    $('#tabcob_1').addClass('hide');
                                }
                                else {

                                    $('#rbObtenerCliente').prop('checked', true);

                                    habilitarControl('#txtSearchCliente', false);
                                    habilitarClienteNatural(false);
                                    habilitarClienteJuridico(false);
                                    habilitarControl('#ddlTipoDocCliente,#txtNroDocCliente,#txtDireccionCliente,#txtTelefonoCliente,#txtEmailCliente', false);
                                    
                                    $('#chkClienteDefault').prop('checked', true);

                                    $('#tabcob_1 span').trigger('click');
                                    $('#tabcob_1').removeClass('hide');
                                };
                                
                                if (_rbTipoComprobante == '2') {
                                    $('#hdTipoCliente').val('JU');
                                    
                                    $('.rowClienteNatural').addClass('hide');
                                    $('.rowClienteJuridico').removeClass('hide');

                                    calcultarTotalFinal(_valorImpuesto);
                                    MostrarTipoDocCliente('6');

                                    if (_rbMedioPago == '2')
                                        addValidCliente_Juridica();
                                }
                                else {
                                    $('#hdTipoCliente').val('NA');

                                    $('.rowClienteNatural').removeClass('hide');
                                    $('.rowClienteJuridico').addClass('hide');

                                    calcultarTotalFinal(_valorImpuesto);
                                    MostrarTipoDocCliente('1');

                                    if (_rbMedioPago == '2')
                                        addValidCliente_Natural();
                                };

                                MostrarPanelCobranza();
                            }
                        }
                    ],
                    cancelButton: true
                });
            };
        },
        error: function (error) {
            console.log(error);
        }
    });

    $('#lblEfectivoPago .monto').text($('#lblTotalPago .monto').text());
    $('#lblEfectivoCambio .monto').text($('#lblTotalCambio .monto').text());
}

function GuardarCobranza () {
    var data = new FormData();
    var input_caja = $('#pnlCaja :input').serializeArray();
    var input_cobranza = $('#pnlCobranza :input').serializeArray();

    data.append('btnCobrar', 'btnCobrar');
    
    Array.prototype.forEach.call(input_caja, function(fields){
        data.append(fields.name, fields.value);
    });

    Array.prototype.forEach.call(input_cobranza, function(fields){
        data.append(fields.name, fields.value);
    });

    data.append('hdIdOrden', $('#hdIdOrden').val());
    data.append('hdIdAperturaCaja', $('#hdIdAperturaCaja').val());
    data.append('hdTotalSinImpuesto', $('#lblTotalSinImpuesto .monto').text());
    data.append('hdImpuesto', $('#lblImpuesto .monto').text());
    data.append('hdTotalConImpuesto', $('#lblTotalConImpuesto .monto').text());

    $.ajax({
        url: 'services/ventas/caja-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            createSnackbar(respuesta.titulomsje);

            if (respuesta.rpta != '0'){
                $('#titleOrden').text('Orden #:');
                $('#gvArticuloMenu tbody').html('');
                $('#lblTotalCobro .monto').text('0.00');
                $('#lblTotalCambio .monto').text('0.00');
                $('#lblTotalPago .monto').text('0.00');

                var datosVenta = respuesta.datosVenta;

                habilitarControl('#btnCobrar', false);
                habilitarControl('#btnImprimir', true);

                var groups = _.groupBy(datosVenta, function(value){
                    return value.CodigoVenta + '#' + value.Cliente + '#' + value.SimboloMoneda + '#' + value.TipoComprobante;
                });
                
                var data = _.map(groups, function(group){
                    return {
                        CodigoVenta: group[0].CodigoVenta,
                        Cliente: group[0].Cliente,
                        SimboloMoneda: group[0].SimboloMoneda,
                        TipoComprobante: group[0].TipoComprobante,
                        tm_base_imponible: group[0].tm_base_imponible,
                        tm_impuesto: group[0].tm_impuesto,
                        tm_total: group[0].tm_total,
                        list_articulos: group
                    }
                });

                var countdata = data.length;
                var strhtml = '';

                if (countdata > 0){
                    var simbolo_moneda = data[0].SimboloMoneda;
                    $('#lblTipoComprobante_print').text(data[0].TipoComprobante);
                    $('#lblCodigoVenta_print').text(data[0].CodigoVenta);
                    $('#lblFechaHora_print').text(moment().format('DD/MM/YYYY hh:mm:ss'));
                    $('#lblNombreCliente_print').text(data[0].Cliente);
                    $('#lblTotal_print').text(simbolo_moneda + Number(data[0].tm_base_imponible).toFixed(2));
                    $('#lblImpuestos_print').text(simbolo_moneda + Number(data[0].tm_impuesto).toFixed(2));
                    $('#lblTotalImp_print').text(simbolo_moneda + Number(data[0].tm_total).toFixed(2));

                    var articulos = data[0].list_articulos;
                    var count_articulos = 0;
                    
                    if (articulos.length == 1){
                        if (articulos[0].nombreArticulo.trim().length == 0)
                            count_articulos = 0;
                        else
                            count_articulos = 1;
                    }
                    else
                        count_articulos = articulos.length;

                    var j = 0;
                    
                    if (count_articulos > 0){
                        while (j < count_articulos){
                            strhtml += '<tr>';
                            strhtml += '<td>' + articulos[j].nombreArticulo + '</td>';
                            strhtml += '<td>' + articulos[j].td_cantidad + '</td>';
                            strhtml += '<td>' + simbolo_moneda + Number(articulos[j].td_precio).toFixed(2) + '</td>';
                            strhtml += '<td>' + simbolo_moneda + Number(articulos[j].td_subtotal).toFixed(2) + '</td>';
                            strhtml += '</tr>';
                            ++j;
                        };
                    };

                };

                $('.performance-facts__table tbody').html(strhtml);
                $('#hdIdOrden').val('0');
                clearValidationsRules('#pnlCobranza');
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function calcularCambio (total_pago) {
    var _pago = 0;
    var total_cambio = 0;
    var total_orden = Number($('#lblTotalCobro .monto').text());
    
    // console.log(isNaN(total_pago));
    
    if (!isNaN(total_pago)){
        if (total_pago.length > 0)
            _pago = Number(total_pago);
        
        if (_pago > 0)
            total_cambio = _pago - total_orden;
    };
    
    $('#lblTotalPago .monto').text(_pago.toFixed(2));
    $('#lblTotalCambio .monto').text(total_cambio.toFixed(2));
}

function ListarPersonalPorTurno (turno) {
    var selector = '#gvPersonalTurno .collection';

    $.ajax({
        type: 'GET',
        url: 'services/organigrama/organigrama-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '3',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            turno: turno
        },
        success: function(data){
            var i = 0;
            var countdata = data.length;
            var strhtml = '';

            if (countdata > 0){
                while(i < countdata){
                    var iditem = data[i].tm_idpersonal;
                    var foto = data[i].tm_foto;

                    strhtml += '<li class="collection-item avatar no-border dato" data-idmodel="' + iditem + '">';
                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                    strhtml += '<i class="icon-select material-icons circle white-text">done</i><div class="layer-select"></div>';

                    if (foto == 'no-set')
                        strhtml += '<i class="material-icons circle">&#xE853;</i>';
                    else
                        strhtml += '<img src="' + foto + '" alt="" class="circle">';

                    strhtml += '<span class="title descripcion">' + data[i].tm_apellidopaterno + ' ' + data[i].tm_apellidomaterno + ' ' + data[i].tm_nombres + '</span>';
                    strhtml += '<p><span class="docidentidad">RUC: ' + data[i].tm_nrodni + '</span> -  ' + data[i].tm_email + '</p>';
                    strhtml += '<div class="divider"></div>';
                    strhtml += '</li>';
                    
                    ++i;
                };

                $(selector).html(strhtml);
            }
            else
                $(selector).html('<h2>No se encontraron resultados.</h2>');
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function createItem__Articulo (tm_idproducto, ta_tipomenudia, td_idatencion_articulo, nombreProducto, cantidad, precio, subtotal) {
    var strhtml = '';

    strhtml += '<tr data-iditem="' +  td_idatencion_articulo + '" class="dato">';

    strhtml += '<td class="hide">';

    strhtml += '<input name="mc_articulo[' + filaArticulo + '][iddetalle]" type="hidden" id="iddetalle' + filaArticulo + '" value="' + td_idatencion_articulo + '" /><input name="mc_articulo[' + filaArticulo + '][tipomenudia]" type="hidden" id="tipomenudia' + filaArticulo + '" value="' + ta_tipomenudia + '" /><input name="mc_articulo[' + filaArticulo + '][idproducto]" type="hidden" id="idproducto' + filaArticulo + '" value="' + tm_idproducto + '" /></td>';

    strhtml += '<td data-title="Articulo" class="v-align-middle nombre-articulo">' + nombreProducto;

    strhtml += '</td>';
    
    strhtml += '<td data-title="Cantidad" class="text-right">';

    strhtml += '<input type="hidden" name="mc_articulo[' + filaArticulo + '][cantidad]" id="cantidad' + filaArticulo + '" value="' + cantidad + '">' + cantidad;

    strhtml += '</td>';
    strhtml += '<td data-title="Precio" class="text-right">';

    strhtml += '<input type="hidden" name="mc_articulo[' + filaArticulo + '][precio]" id="precio' + filaArticulo + '" value="' + precio + '">' + precio;
    
    strhtml += '</td>';

    strhtml += '<td data-title="Subtotal" class="text-right">';

    strhtml += '<input type="hidden" name="mc_articulo[' + filaArticulo + '][subtotal]" id="subtotal' + filaArticulo + '" value="' + subtotal.toFixed(2) + '" class="subtotal">' + subtotal.toFixed(2);

    strhtml += '</td>';
    
    strhtml += '<td><a class="padding5 mdl-button mdl-button--icon tooltipped center-block" href="#" data-action="delete" data-placement="left" data-toggle="tooltip" title="Eliminar"><i class="material-icons">&#xE872;</i></a></td>';
    
    strhtml += '</tr>';

    ++filaArticulo;
    
    return strhtml;
}

function buildMenu (data) {
    var countdata = data.length;
    var total_orden = 0;
    var strhtml = '';

    if (countdata > 0){
        if (data[0].nombreProducto.length > 0) {
            var i = 0;

            while(i < countdata){
                var cantidad = data[i].td_cantidad;
                var precio = Number(data[i].td_precio).toFixed(2);
                var subtotal = Number(data[i].td_subtotal);
                
                strhtml += createItem__Articulo(data[i].tm_idproducto, data[i].ta_tipomenudia, data[i].td_idatencion_articulo, data[i].nombreProducto, cantidad, precio, subtotal);

                total_orden += subtotal;

                ++i;
            };
        };
    };
    
    $('#gvArticuloMenu tbody').html(strhtml);
    $('#lblTotalCobro .monto').text(total_orden.toFixed(2));

    $('.tooltipped').tooltip({delay: 50});
}

function recalcularTotal () {
    var data = $('#gvArticuloMenu tbody tr');
    var countdata = data.length;
    var total_orden = 0;
    var i = 0;

    if (countdata > 0){
        while(i < countdata){
            var subtotal = Number(data[i].getElementsByClassName('subtotal')[0].value);
            total_orden += subtotal;
            ++i;
        };
    };

    $('#lblTotalCobro .monto').text(total_orden.toFixed(2));
}

function calcultarTotalFinal (valor_impuesto) {

    var total_orden = Number($('#lblTotalCobro .monto').text());
    var impuestos = total_orden * (Number(valor_impuesto) / 100);
    var total_sin_impuesto = total_orden - impuestos;

    $('#lblTotalSinImpuesto .monto').text(total_sin_impuesto.toFixed(2));
    $('#lblImpuesto .monto').text(impuestos.toFixed(2));
    $('#lblTotalConImpuesto .monto').text(total_orden.toFixed(2));
}

function getOrden (idorden) {
    $.ajax({
        url: 'services/atencion/atencion-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: 'ONE-ATENCION',
            idatencion: idorden
        },
        success: function (result) {
            var groups = _.groupBy(result, function(value){
                return value.tm_idatencion + '#' + value.tm_nroatencion + '#' + value.tm_fechahora;
            });
            
            var data = _.map(groups, function(group){
                return {
                    tm_idatencion: group[0].tm_idatencion,
                    tm_nroatencion: group[0].tm_nroatencion,
                    tm_fechahora: group[0].tm_fechahora,
                    list_articulos: group
                }
            });

            var countdata = data.length;

            if (countdata > 0){
                $('#hdIdOrden').val(data[0].tm_idatencion);
                $('#titleOrden').text('Orden #: ' + data[0].tm_nroatencion);

                buildMenu(data[0].list_articulos);
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function LimpiarCaja () {
    $('#hdIdAperturaCaja').val('0');
    $('#hdIdMoneda').val('0');
    $('#lblFechaRegistroCaja').text('');
    $('#lblTurnoCaja').text('');
    $('#lblMonedaInicial').text('');
    $('#lblImporteInicial').text('0.00');
    $('#lblMonedaActual').text('');
    $('#lblImporteActual').text('0.00');
    $('#lblMonedaTotalCaja').text('');
    $('#lblImporteTotalCaja').text('0.00');
    $('#tableRegistroCaja .ibody tbody').html('');
}

function ListarMovimientoCaja (idregistrocaja) {
    var tipomov = $('#pnlCajaActual .btn-group button.btn-primary').attr('data-tipomov');

    precargaExp('#tableRegistroCaja', true);

    $.ajax({
        type: 'GET',
        url: 'services/ventas/detalleapertura-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idregistrocaja: idregistrocaja,
            tipomov: tipomov
        },
        success: function(data){
            var i = 0;
            var countdata = data.length;
            var strhtml = '';
            // var totalcaja = 0;

            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<tr>';
                    strhtml += '<td>' + (i + 1)+ '</td>';
                    strhtml += '<td>' + data[i].Concepto + '</td>';
                    strhtml += '<td>' + data[i].FechaReg.split(' ')[1] + '</td>';
                    strhtml += '<td>' + data[i].Moneda + '</td>';
                    strhtml += '<td>' + data[i].tm_monto_mn + '</td>';
                    strhtml += '<td>' + data[i].tm_observacion + '</td>';
                    strhtml += '</tr>';

                    // totalcaja = totalcaja + Number(data[i].tm_monto_mn);
                    ++i;
                };
            };

            $('#tableRegistroCaja tbody').html(strhtml);
            // $('#lblImporteTotalCaja').text(totalcaja.toFixed(2));

            precargaExp('#tableRegistroCaja', false);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function habilitarCaja (flag) {
    var content_btncaja = '';
    var action_btncaja = '';
    var tooltip_btncaja = '';
    
    if (flag){
        content_btncaja = '<span class="fa fa-lock md-36"></span>';
        action_btncaja = 'cerrar';
        tooltip_btncaja = 'Cerrar caja';
    }
    else {
        content_btncaja = '<span class="fa fa-unlock md-36"></span>';
        action_btncaja = 'abrir';
        tooltip_btncaja = 'Abrir caja';
    };

    $('.calc button[data-value="operar-caja"]').html(content_btncaja).attr({ 'data-action': action_btncaja, 'title' : tooltip_btncaja, 'data-original-title' : tooltip_btncaja });
    habilitarControl('.calc button[data-value!="operar-caja"]', flag);
}

function ComprobarApertura () {
    $.ajax({
        url: 'services/ventas/aperturacaja-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '2',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            fecha: GetToday()
        },
        success: function (data) {        
            var countdata = data.length;
            var flag = (countdata > 0 ? true : false);
            
            habilitarCaja(flag);
            AperturaByDefault();
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function AperturaByDefault () {
    $.ajax({
        type: 'GET',
        url: 'services/ventas/aperturacaja-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val()
        },
        success: function (data) {
            var i = 0;
            var countdata = data.length;
            
            LimpiarCaja();
            
            if (countdata > 0){
                $('#hdIdAperturaCaja').val(data[0].tm_idregistro_caja);
                $('#hdIdMoneda').val(data[0].tm_idmoneda);
                $('#lblFechaRegistroCaja').text(ConvertMySQLDate(data[0].tm_fecharegistro));
                $('#lblTurnoCaja').text(data[0].Turno);
                
                $('#lblMonedaIngreso').text(data[0].SimboloMoneda);
                $('#lblImporteIngreso').text(Number(data[0].tm_monto_ingreso).toFixed(2));

                $('#lblMonedaSalida').text(data[0].SimboloMoneda);
                $('#lblImporteSalida').text(Number(data[0].tm_monto_salida).toFixed(2));

                $('#lblMonedaInicial').text(data[0].SimboloMoneda);
                $('#lblImporteInicial').text(Number(data[0].tm_monto_inicial).toFixed(2));
                
                $('#lblMonedaActual').text(data[0].SimboloMoneda);
                $('#lblImporteActual').text(Number(data[0].tm_monto_actual).toFixed(2));
                
                // $('#lblMonedaTotalCaja').text(data[0].SimboloMoneda);

                // $('#btnAperturaCaja').addClass('oculto');
                // $('#btnRegistrarMovimiento, #btnCierreCaja').removeClass('oculto');

                ListarMovimientoCaja(data[0].tm_idregistro_caja);

                habilitarCaja(true);
            };
            // else {
                // $('#btnAperturaCaja').removeClass('oculto');
                // $('#btnRegistrarMovimiento, #btnCierreCaja').addClass('oculto');
            // };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function ListarInsumos (pagina){
    $.ajax({
        url: 'services/insumos/insumos-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: 'INSUMO-PRESENTACION',
            tipo: '2',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            idcategoria: $('#hdIdCategoria').val(),
            idsubcategoria: '0',
            criterio:  $('#txtSearchProd').val(),
            pagina: pagina
        },
        success: function (result) {
            var i = 0;
            var strhtml = '';
            var selector = '#gvInsumo tbody';
            
            var groups = _.groupBy(result, function(value){
                return value.idarticulo + '#' + value.nombre + '#' + value.tipoinsumo;
            });
            
            var data = _.map(groups, function(group){
                return {
                    idarticulo: group[0].idarticulo,
                    nombre: group[0].nombre,
                    precio: group[0].precio,
                    tipoinsumo: group[0].tipoinsumo,
                    list_presentacion: group
                }
            });

            var countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    var j = 0;
                    var presentacion = data[i].list_presentacion;
                    var count_presentacion = 0;

                    if (presentacion.length > 0) {
                        if (presentacion[0].Presentacion.length == 0)
                            count_presentacion = 0;
                        else
                            count_presentacion = presentacion.length;
                    };
                    // var count_presentacion = presentacion.length;

                    strhtml += '<tr>';
                    strhtml += '<td>';

                    if (count_presentacion > 0){
                        strhtml += '<input type="checkbox" class="filled-in" id="chkInsumo' + i + '" value="' + data[i].idarticulo + '" name="itemsventa[' + i + '][idproducto]" /><label for="chkInsumo' + i + '"></label>';                        
                    };

                    strhtml += '</td>';

                    strhtml += '<td data-title="Insumo/Articulo" class="descripcion">' + data[i].nombre + '</td>';

                    strhtml += '<td data-title="Presentacion"><select name="itemsventa[' + i + '][idpresentacion]" disabled class="select-presentacion browser-default">';

                    if (count_presentacion > 0){
                        while (j < count_presentacion){
                            if (typeof presentacion[j] !== 'undefined')
                                strhtml +=  '<option value="' + presentacion[j].idpresentacion + '" data-idunidadmedida="' + presentacion[j].idunidadmedida + '" data-medidapre="' + presentacion[j].medida_presentacion + '">' + presentacion[j].Presentacion + (presentacion[j].Presentacion.length == 0 ? '' : ' - ') + presentacion[j].UM + '</option>';
                            ++j;
                        };
                    }
                    else
                        strhtml +=  '<option value="0" data-idunidadmedida="0">No hay presentaciones</option>';

                    strhtml += '</select></td>';
                    
                    strhtml += '<td data-title="Cantidad">';
                    strhtml += '<div class="mdl-input-js mdl-textfield mdl-js-textfield full-size no-padding"><input disabled class="mdl-textfield__input align-right cantidad" type="number" step="any" id="cantidad' + i + '" name="itemsventa[' + i + '][cantidad]" value=""><label class="mdl-textfield__label" for="cantidad' + i + '"></label></div>';

                    strhtml += '</td>';

                    strhtml += '<td data-title="Precio">';
                    
                    strhtml += '<div class="mdl-input-js mdl-textfield mdl-js-textfield full-size no-padding"><input disabled class="mdl-textfield__input align-right precio" type="number" step="any" id="precio' + i + '" name="itemsventa[' + i + '][precio]" value="' + data[i].precio + '"><label class="mdl-textfield__label" for="precio' + i + '"></label></div>';
                    
                    strhtml += '</td>';

                    strhtml += '<td data-title="SubTotal" class="subtotal">';
                    
                    strhtml += '<input type="hidden" id="subtotal' + i + '" name="itemsventa[' + i + '][subtotal]" value="0"><h4 class="grey-text text-right">0.00</h4>';
                    
                    strhtml += '</td>';
                    strhtml += '</tr>';

                    ++i;
                };

                gvInsumo.currentPage(gvInsumo.currentPage() + 1);

                if (pagina == '1')
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);

                //$(selector).enableCellNavigation();
                // registerScriptMDL(selector + ' .mdl-input-js');
            }
            else {
                if (pagina == '1')
                    $(selector).html('');

                habilitarControl('#btnAddItemsVenta', false);
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function ListarServicios (pagina) {
    $.ajax({
        url: 'services/servicio/servicio-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '3',
            tipo: '2',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            criterio:  $('#txtSearchServ').val(),
            pagina: pagina
        },
        success: function (data) {
            var i = 0;
            var strhtml = '';
            var selector = '#gvServicio tbody';

            var countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<tr>';
                    strhtml += '<td>';
                    
                    strhtml += '<input type="checkbox" class="filled-in" id="chkServicio' + i + '" value="' + data[i].tm_idservicio + '" name="itemsservicio[' + i + '][idproducto]" /><label for="chkServicio' + i + '"></label>';                        

                    strhtml += '</td>';

                    strhtml += '<td data-title="Servicio" class="descripcion">' + data[i].tm_nombre;
                    
                    strhtml += '<input type="hidden" id="serv_descripcion' + i + '" name="itemsservicio[' + i + '][descripcion]" value="' + data[i].tm_nombre + '">';

                    strhtml += '</td>';
                    strhtml += '<td data-title="Precio">';
                    
                    strhtml += '<div class="mdl-input-js mdl-textfield mdl-js-textfield full-size no-padding"><input disabled class="mdl-textfield__input align-right precio" type="number" step="any" id="serv_precio' + i + '" name="itemsservicio[' + i + '][precio]" value="' + Number(data[i].tm_precio).toFixed(2) + '"><label class="mdl-textfield__label" for="serv_precio' + i + '"></label></div>';
                    strhtml += '<input type="hidden" id="serv_subtotal' + i + '" name="itemsservicio[' + i + '][subtotal]" value="' + Number(data[i].tm_precio).toFixed(2) + '">';
                    strhtml += '</td>';

                    strhtml += '</tr>';

                    ++i;
                };

                gvServicio.currentPage(gvServicio.currentPage() + 1);

                if (pagina == '1')
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);

                //$(selector).enableCellNavigation();
                // registerScriptMDL(selector + ' .mdl-input-js');
            }
            else {
                if (pagina == '1')
                    $(selector).html('');

                habilitarControl('#btnAddItemsVenta', false);
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}
function LimpiarPreSeleccion_articulo () {
    // if ($('#starks-panel').hasClass('is-active')){
    $('#gvInsumo input:checkbox').prop('checked', false);
    $('#gvInsumo .precio').val('');
    $('#gvInsumo .cantidad').val('');
    $('#gvInsumo .subtotal input:hidden').val('');
    $('#gvInsumo .subtotal h4').text('0.00').addClass('grey-text');
    // }
    // else {
    //     $('#descripcion_custom0').val('');
    //     $('#cantidad_custom0').val('');
    //     $('#precio_custom0').val('');
    //     $('#subtotal_custom0').val('');
    // };

    habilitarControl('#btnAddItemsVenta', false);
}

function LimpiarPreSeleccion_servicio () {
    // if ($('#starks-panel').hasClass('is-active')){
    $('#gvServicio input:checkbox').prop('checked', false);
    $('#gvServicio .precio').val('');
    // $('#gvServicio .cantidad').val('');
    // $('#gvServicio .subtotal input:hidden').val('');
    $('#gvServicio .subtotal h4').text('0.00').addClass('grey-text');
    // }
    // else {
    //     $('#descripcion_custom0').val('');
    //     $('#cantidad_custom0').val('');
    //     $('#precio_custom0').val('');
    //     $('#subtotal_custom0').val('');
    // };

    habilitarControl('#btnAddItemsVenta', false);
}

function AgregarItemsVenta () {
    var data = new FormData();
    var input = $('#gvInsumo :input').serializeArray();

    data.append('btnAddItemsVenta', 'btnAddItemsVenta');
    data.append('hdIdOrden', $('#hdIdOrden').val());

    Array.prototype.forEach.call(input, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        url: 'services/ventas/caja-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            createSnackbar(data.titulomsje);
            
            if (data.rpta != '0') {
                getOrden(data.rpta);
                LimpiarPreSeleccion_articulo();
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function AgregarServicio () {
    var data = new FormData();
    var input = $('#gvServicio :input').serializeArray();

    data.append('btnAddServicioVenta', 'btnAddServicioVenta');
    data.append('hdIdOrden', $('#hdIdOrden').val());

    Array.prototype.forEach.call(input, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        url: 'services/ventas/caja-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            createSnackbar(data.titulomsje);
            
            if (data.rpta != '0') {
                getOrden(data.rpta);
                LimpiarPreSeleccion_servicio();
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function eliminarArticulo (_this) {
    var _row = getParentsUntil(_this, '#gvArticuloMenu', '.dato');
    var idarticulo_orden = _row[0].getAttribute('data-iditem');

    MessageBox({
        content: '¿Desea quitar este item?',
        width: '320px',
        height: '130px',
        buttons: [
            {
                primary: true,
                content: 'Quitar item',
                onClickButton: function (event) {
                    var data = new FormData();

                    data.append('btnRemoveArticles', 'btnRemoveArticles');
                    data.append('hdIdArticuloOrden', idarticulo_orden);

                    $.ajax({
                        url: 'services/atencion/atencion-post.php',
                        type: 'POST',
                        dataType: 'json',
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function  (data) {
                            if (data.rpta != '0') {
                                $(_row[0]).remove();
                                recalcularTotal();
                            };
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }
            }
        ],
        cancelButton: true
    });
}

function clearValidationsRules (idmodal) {
    if (idmodal == '#pnlCobranza') {
        $('#txtNroDocCliente').rules('remove');
        $('#txtEmailCliente').rules('remove');
        
        if ($('#hdTipoComprobante').val() == '2') {
            $('#txtRazonSocialCliente').rules('remove');
        }
        else {
            $('#txtApePaternoCliente').rules('remove');
            $('#txtApeMaternoCliente').rules('remove');
            $('#txtNombresCliente').rules('remove');
        };
    };
}