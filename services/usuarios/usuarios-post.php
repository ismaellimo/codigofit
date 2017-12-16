<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
    $user_error = 'Access denied - direct call is not allowed...';
    trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

if ($_POST){
    require '../../common/sesion.class.php';
    require '../../common/class.translation.php';
    require '../../adata/Db.class.php';
    require '../../bussiness/usuarios.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    $idperfil = $sesion->get("idperfil");
    $IdEmpresa = $sesion->get("idempresa");

    $idusuario_plataforma = $sesion->get("idusuario_plataforma");

    $objData = new clsUsuario();

    $lang = isset($_POST['lang']) ? $_POST['lang'] : 'es';

    $translate = new Translator($lang);

    $rpta = '0';
    $titulomsje = '';
    $contenidomensaje = '';

    $hdIdUsuario = isset($_POST['hdIdUsuario']) ? $_POST['hdIdUsuario'] : '0';
    $hdPregunta = isset($_POST['hdPregunta']) ? $_POST['hdPregunta'] : '1';

    if (isset($_POST['btnGuardar'])){
        $IdCentro = isset($_POST['ddlCentro']) ? $_POST['ddlCentro'] : '0';
        $ddlTipoPersona = isset($_POST['ddlTipoPersona']) ? $_POST['ddlTipoPersona'] : '0';
        $ddlPerfil = isset($_POST['ddlPerfil']) ? $_POST['ddlPerfil'] : '0';
        $hdIdPersona = isset($_POST['hdIdPersona']) ? $_POST['hdIdPersona'] : '0';
        $txtNombre = isset($_POST['txtNombre']) ? $_POST['txtNombre'] : '';
        $txtClave = isset($_POST['txtClave']) ? $_POST['txtClave'] : '';
        $txtNombres = isset($_POST['txtNombres']) ? $_POST['txtNombres'] : '';
        $txtApellidos = isset($_POST['txtApellidos']) ? $_POST['txtApellidos'] : '';
        $txtNumeroDoc = isset($_POST['txtNumeroDoc']) ? $_POST['txtNumeroDoc'] : '';
        $txtEmail = isset($_POST['txtEmail']) ? $_POST['txtEmail'] : '';
        $txtTelefono = isset($_POST['txtTelefono']) ? $_POST['txtTelefono'] : '';
        $hdFoto = isset($_POST['hdFoto']) ? $_POST['hdFoto'] : 'no-set';

        $objData->Registrar($hdIdUsuario, $IdEmpresa, $IdCentro, $ddlPerfil, $hdIdPersona, $ddlTipoPersona, '', $txtNombre, $txtNombres, $txtApellidos, $txtClave, 0, $txtNumeroDoc, '', 0, '', $txtEmail, $txtTelefono, $hdFoto, $idusuario, $rpta, $titulomsje, $contenidomensaje);
    }
    // elseif (isset($_POST['btnImportarDataPreliminar'])) {
    //     $txtCurrentPassword = isset($_POST['txtCurrentPassword']) ? $_POST['txtCurrentPassword'] : '';
    //     $txtNewPassword = isset($_POST['txtNewPassword']) ? $_POST['txtNewPassword'] : '';
    //     $txtConfirmNewPassword = isset($_POST['txtConfirmNewPassword']) ? $_POST['txtConfirmNewPassword'] : '';

    //     $objData->Usuario_ImportData($idusuario_plataforma, $IdEmpresa, $IdCentro, $hdPregunta, $idusuario, $rpta, $titulomsje, $contenidomensaje);
    // }
    elseif (isset($_POST['btnEliminarUsuario']))
        $objData->EliminarStepByStep($hdIdUsuario, $idusuario, $rpta, $titulomsje, $contenidomensaje);
    elseif (isset($_POST['btnImportarDataPreliminar'])){
        $IdCentro = $sesion->get("idcentro");
        $objData->Usuario_ImportData($idusuario_plataforma, $IdEmpresa, $IdCentro, $hdPregunta, $idusuario, $rpta, $titulomsje, $contenidomensaje);
    }

    $jsondata = array('rpta' => $rpta, 'titulomsje' => $translate->__s($titulomsje), 'contenidomensaje' => $translate->__s($contenidomensaje));
    echo json_encode($jsondata);
}
?>