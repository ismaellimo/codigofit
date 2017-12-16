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
    require '../../common/functions.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    $idperfil = $sesion->get("idperfil");

    $rpta = 0;
    $titulomsje = '';
    $contenidomensaje = '';
    $urlImagen = '';
    
    $lang = isset($_POST['lang']) ? $_POST['lang'] : 'es';

    $translate = new Translator($lang);
    
    $hdIdPrimary = isset($_POST['hdIdPrimary']) ? $_POST['hdIdPrimary'] : '0';
    
    if (isset($_POST['btnGuardar'])){

        require '../../adata/Db-OneConnect.class.php';
        require '../../bussiness/producto_oneconnect.php';

        $objProducto = new clsProducto_oneconnect();

        $IdEmpresa = isset($_POST['hdIdEmpresa']) ? $_POST['hdIdEmpresa'] : '1';
        $IdCentro = isset($_POST['hdIdCentro']) ? $_POST['hdIdCentro'] : '1';
        $txtNombreProducto = isset($_POST['txtNombreProducto']) ? $_POST['txtNombreProducto'] : '';
        $hdFoto = (isset($_POST['hdFoto'])) ? $_POST['hdFoto'] : 'no-set';
        $ddlCategoriaReg = isset($_POST['ddlCategoriaReg']) ? $_POST['ddlCategoriaReg'] : '0';
        $txtPrecioVenta = isset($_POST['txtPrecioVenta']) ? $_POST['txtPrecioVenta'] : '0';
        $txtPrecioCompra = isset($_POST['txtPrecioCompra']) ? $_POST['txtPrecioCompra'] : '0';
             
        if (empty($_FILES['archivo']['name']))
            $urlImagen = $hdFoto;
        else {
            $upload_folder  = '../../media/images/';
            $url_folder  = 'media/images/';

            if (!is_dir($upload_folder))
                mkdir($upload_folder);

            $nombre_archivo = $_FILES['archivo']['name'];
            $extension = pathinfo($nombre_archivo, PATHINFO_EXTENSION);
            $tipo_archivo = $_FILES['archivo']['type'];
            $tamano_archivo = $_FILES['archivo']['size'];
            $tmp_archivo = $_FILES['archivo']['tmp_name'];

            // $nombre_archivo = trim($nombre_archivo);
            // $nombre_archivo = str_replace(' ', '', $nombre_archivo);

            $original = $upload_folder.generateRandomString().'_o.'.$extension;

            $size42 = str_replace('_o', '_s42', $original);
            $size225 = str_replace('_o', '_s225', $original);
            $size640 = str_replace('_o', '_s640', $original);

            if (move_uploaded_file($tmp_archivo, $original)) {
                make_thumb($original, $size42, 42);
                make_thumb($original, $size225, 225);
                make_thumb($original, $size640, 640);

                $urlImagen = str_replace($upload_folder, $url_folder, $original);
            }
            else
                $urlImagen = $hdFoto;
        }

        $conexion_producto = $objProducto->_conectar();

        $objProducto->Registrar($conexion_producto, $hdIdPrimary, $IdEmpresa, $IdCentro, $txtNombreProducto, $ddlCategoriaReg, 0, $urlImagen, $txtPrecioVenta, $txtPrecioCompra,  $idusuario, $rpta, $titulomsje, $contenidomensaje);
        

        $objProducto->_desconectar($conexion_producto);
    }
    elseif (isset($_POST['btnEliminar'])) {
        require '../../adata/Db.class.php';
        require '../../bussiness/productos.php';

        $objProducto = new clsProducto();
        $rpta = $objProducto->EliminarStepByStep($hdIdPrimary, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }

    $jsondata = array("rpta" => $rpta, 'titulomsje' => $translate->__s($titulomsje), 'contenidomensaje' => $translate->__s($contenidomensaje));
    echo json_encode($jsondata);
}
?>