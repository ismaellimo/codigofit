<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#3F51B5">
	<title>CODIGOFIT - Sistema de Gestión y Asesoría para tu Gimnasio</title>
    <link rel="icon" sizes="192x192" type="image/png" href="images/favicon.png" />
    <link rel="stylesheet" href="styles/materialize.min.css"/>
    <link rel="stylesheet" href="styles/material.min.css"/>
    <link rel="stylesheet" href="styles/common.min.css"/>
    <link rel="stylesheet" href="styles/styles.min.css"/>
    <link rel="stylesheet" href="styles/login.min.css"/>
</head>
<body>
    <form id="pnlLogin" name="pnlLogin" method="POST" enctype="multipart/form-data" autocomplete="off" action="services/usuarios/login.php" class="panel-login bg-opacity-7 centered">
        <input style="display:none" type="text" name="fakeusernameremembered" class="fake-autofill-fields no-opacity" />
        <input style="display:none" type="password" name="fakepasswordremembered" class="fake-autofill-fields no-opacity" />
        <div class="grid expand-phone padding30">
            <div class="row">
                <div class="logo pos-rel">
                    <img src="images/logo-main.png" class="centered mdl-shadow--4dp " width="300px" height="100px" alt="Logo">
                </div>
            </div>
            <div class="row">
                <h3 class="white-text align-center">Sistema de Gestión y Asesoría para tu Gimnasio</h3>
            </div>
            <div class="row pos-rel no-margin padding-left20 padding-right20">
                <div class="input-field">
                    <input type="text" class="white-text" name="login" id="login">
                    <label class="white-text" for="login">Usuario</label>
                </div>
            </div>
            <div class="row pos-rel no-margin padding-left20 padding-right20">
                
                    <div class="input-field">
                        <input type="password" class="white-text" name="password" id="password">
                        <label class="white-text" for="password">Contrase&ntilde;a</label>
                    </div>
                    <button id="btnShowPass" type="button" class="mdl-button mdl-js-button mdl-button--icon white-text place-top-right margin-right20">
                        <i class="material-icons">&#xE417;</i>
                    </button>
            </div>
            <div class="row align-center no-margin">
                <button id="btnLogin" name="btnLogin" type="submit" lang="es" class="mdl-button mdl-js-button mdl-js-ripple-effect yellow darken-1 black-text margin10">
                    Iniciar sesión
                </button>
                <button id="btnGoToRegister" type="button" name="btnGoToRegister" lang="es" class="mdl-button mdl-js-button mdl-js-ripple-effect orange darken-1 black-text margin10">
                    Regístrate!
                </button>
            </div>
            <div class="row align-center no-margin">
                <a href="recoverypass.php" class="white-text text-underline">No recuerdo mi contraseña</a>
            </div>
        </div>
    </form>
    <form id="pnlRegister" name="pnlRegister" method="post" action="registro.php" class="panel-login bg-opacity-7 centered" style="display: none;">
        <div class="generic-panel gp-no-header">
            <div class="gp-body">
                <div class="scrollbarra padding30">
                    <div class="row">
                        <div class="mdl-grid mdl-grid--no-spacing no-margin">
                            <div class="mdl-cell mdl-cell--6-col">
                                <h5 class="no-padding no-margin white-text">¿Eres una empresa?</h5>
                                <div class="switch">
                                    <label>
                                        <input id="chkTipoPersona" name="chkTipoPersona" type="checkbox" value="1">
                                        <span class="lever"></span>
                                        <span id="helperTipoPersona" class="white-text">NO</span>
                                    </label>
                                </div>
                            </div>
                            <div class="mdl-cell mdl-cell--6-col">
                                <div class="input-field padding-left10">
                                    <input type="text" class="white-text" name="username" id="username">
                                    <label class="white-text" for="username">Usuario</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row no-margin-bottom">
                        <div class="mdl-grid mdl-grid--no-spacing">
                            <div class="mdl-cell mdl-cell--6-col pos-rel">
                                <div class="input-field padding-right10">
                                    <input type="password" class="white-text" name="clave" id="clave">
                                    <label class="white-text" for="clave">Clave</label>
                                </div>
                                <button id="btnShowPass__Clave" type="button" class="mdl-button mdl-js-button mdl-button--icon white-text place-bottom-right margin20">
                                    <i class="material-icons">&#xE417;</i>
                                </button>
                            </div>
                            <div class="mdl-cell mdl-cell--6-col pos-rel">
                                <div class="input-field padding-left10">
                                    <input type="password" class="white-text" name="confirma_clave" id="confirma_clave">
                                    <label class="white-text" for="confirma_clave">Confirmar Clave</label>
                                </div>
                                <button id="btnShowPass__Confirm" type="button" class="mdl-button mdl-js-button mdl-button--icon white-text place-bottom-right margin20">
                                    <i class="material-icons">&#xE417;</i>
                                </button>
                            </div>
                        </div>
                    </div>
                     <div class="row no-margin-bottom">
                        <div class="col-md-6">
                            <div class="input-field">
                                <input type="email" class="white-text" name="email" id="email" value="">
                                <label class="white-text" for="email">Correo electrónico</label>
                            </div>
                        </div>
                    </div>
                    <div class="row no-margin-bottom">
                        <div class="mdl-grid mdl-grid--no-spacing">
                            <div class="mdl-cell mdl-cell--6-col">
                                <div class="input-field padding-right10">
                                    <input type="text" class="white-text" name="nrodocumento" id="nrodocumento">
                                    <label class="white-text" for="nrodocumento">N&uacute;mero de documento</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="rowJuridico" class="row" style="display: none;">
                        <div class="input-field">
                            <input type="text" class="white-text" name="business_name" id="business_name">
                            <label class="white-text" for="business_name">Raz&oacute;n social</label>
                        </div>
                    </div>
                    <div id="rowNatural" class="row">
                        <div class="mdl-grid mdl-grid--no-spacing">
                            <div class="mdl-cell mdl-cell--6-col">
                                <div class="input-field padding-right10">
                                    <input type="text" class="white-text" name="firstname" id="firstname">
                                    <label class="white-text" for="firstname">Nombres</label>
                                </div>
                            </div>
                            <div class="mdl-cell mdl-cell--6-col">
                                <div class="input-field padding-left10">
                                    <input type="text" class="white-text" name="lastname" id="lastname">
                                    <label class="white-text" for="lastname">Apellidos</label>
                                </div>
                            </div>
                        </div>
                    </div>
                   <div class="row">
                        <div class="mdl-grid mdl-grid--no-spacing">
                            <div class="mdl-cell mdl-cell--6-col">
                                <div class="input-field padding-right10">
                                    <select name="ddlRegion" id="ddlRegion" class="browser-default">
                                        <?php
                                        require 'adata/Db.class.php';
                                        require 'bussiness/ubigeo.php';

                                        $objUbigeo = new clsUbigeo();
                                        $rowUbigeo = $objUbigeo->Listar('3', 0, '', '');
                                        $countUbigeo = count($rowUbigeo);

                                        if ($countUbigeo > 0):
                                          for ($i=0; $i < $countUbigeo; $i++):
                                        ?>
                                        <option value="<?php echo $rowUbigeo[$i]['tm_idubigeo']; ?>"><?php echo $rowUbigeo[$i]['tm_nombre']; ?></option>
                                        <?php
                                          endfor;
                                        endif;
                                        ?>
                                    </select>
                                    <label class="active white-text" for="ddlRegion">Region</label>
                                </div>
                            </div>
                            <div class="mdl-cell mdl-cell--6-col">
                                <div class="input-field padding-left10">
                                    <select name="ddlIdioma" id="ddlIdioma" class="browser-default">
                                        <option value="es">ESPA&Ntilde;OL</option>
                                        <option value="en">INGL&Eacute;S</option>
                                    </select>
                                    <label class="active white-text" for="ddlIdioma">Idioma</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gp-footer">
                <div class="mdl-grid mdl-grid--no-spacing">
                    <div class="mdl-cell mdl-cell--6-col mdl-cell--2-col-phone">
                        <button id="btnBackToLogin" type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored orange mdl-js-ripple-effect center-block black-text margin10">Regresar</button>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col mdl-cell--2-col-phone">
                        <button id="btnRegister" name="btnRegister" type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored yellow mdl-js-ripple-effect center-block black-text margin10">Registrarse</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="scripts/jquery/jquery-2.1.3.min.js"></script>
    <script src="plugins/jquery-ui/js/jquery-ui.min.js"></script>
    <script src="scripts/jquery/jquery.widget.min.js"></script>
    <script src="scripts/jquery/jquery.mousewheel.min.js"></script>
    <script src="plugins/jquery-validate/jquery.validate.min.js"></script>
    <script src="plugins/jquery-validate/additional-methods.min.js"></script>
    <script src="plugins/jquery-validate/localization/messages_es.min.js"></script>
    <script src="scripts/materialize.min.js"></script>
    <script src="scripts/material.min.js"></script>
    <script src="scripts/functions-jquery.js"></script>
    <script src="scripts/app/common/login.min.js"></script>
</body>
</html>