<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#fcae07">
	<title>CODIGOFIT</title>
    <link rel="icon" sizes="192x192" type="image/png" href="images/favicon.png" />
    <link rel="stylesheet" href="styles/materialize.min.css"/>
    <link rel="stylesheet" href="styles/material.min.css"/>
    <link rel="stylesheet" href="styles/common.min.css"/>
    <link rel="stylesheet" href="styles/styles.min.css"/>
    <link rel="stylesheet" href="styles/login.min.css"/>
</head>
<body>
    <form id="pnlPreliminar" name="pnlPreliminar" method="post" autocomplete="off" action="registro.php" class="panel-login bg-opacity-7 centered">
        <div class="generic-panel">
        	<div class="gp-header">
                <h3 class="white-text align-center padding10">Recupere su contrasela</h3>
            </div>
            <div class="gp-body">
                <div class="scrollbarra padding10">
                    <div class="row">
                        <p class="padding10 white-text align-center">
                            <strong>¿Olvid&oacute; su clave? Ingrese el correo electr&oacute;nico con el cual se registr&oacute; para poder enviarle un link con el cual puede generar una nueva clave.</strong>
                        </p>
                    </div>
                	<div class="row pos-rel no-margin padding-left20 padding-right20">
                		<div class="input-field">
                            <input type="email" class="white-text" name="email" id="email">
                            <label class="white-text" for="email">Correo electr&oacute;nico</label>
                        </div>
                	</div>
				</div>
			</div>
			<div class="gp-footer padding10">
                <button id="btnRecuperarClave" type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored green mdl-js-ripple-effect center-block margin10">Recuperar clave</button>
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
</body>
</html>