<?php if ($screenmode == 'cliente'): ?>
<div id="control-app" class="mdl-layout__drawer-button tooltipped hide" data-placement="right" data-toggle="tooltip" title="Opciones de la aplicaci&oacute;n">
    <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
        <i class="material-icons">&#xE5D2;</i>
    </a>
</div>
<iframe id="ifr?pag=procesos&amp;subpag=atencion&amp;op=list&screenmode=cliente" scrolling="no" marginwidth="0" marginheight="0" width="100%" height="100%" frameborder="no" src="?pag=procesos&amp;subpag=atencion&amp;op=list&screenmode=cliente"></iframe>
<?php else: ?>
<div class="demo-layout-waterfall mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <header class="mdl-layout__header mdl-layout__header--waterfall orange">
        <div class="mdl-layout__header-row">
            <span class="mdl-layout-title">CodigoFit - <?php echo $Nombreempresa; ?></span>
            <div class="mdl-layout-spacer"></div>
            <button type="button" class="btnOpciones mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnOpciones">
                <i class="material-icons">&#xE5D4;</i>
            </button>
        </div>
    </header>
    <div id="control-app" class="mdl-layout__drawer-button tooltipped" data-placement="right" data-toggle="tooltip" title="Opciones de la aplicaci&oacute;n">
        <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
            <i class="material-icons">&#xE5D2;</i>
        </a>
    </div>
    <main class="mdl-layout__content">
        <div class="page-content">
            <div id="AppMain" class="mdl-grid">
            </div>
        </div>
    </main>
    <div class="list-sites"></div>
    <div id="modalRecents" class="modalcuatro bg-opacity-8 modal-example-content expand-phone">
        <div class="modal-example-header">
            <div class="left">
                <a href="#" title="Ocultar" class="close-modal-example white-text padding5 circle left"><i class="material-icons md-32">close</i></a>
                <h3 class="no-margin white-text left">
                    Sitios recientes
                </h3>
            </div>
        </div>
        <div class="modal-example-body">
            <div class="list-activewin">
                <div class="view mdl-grid scrollbarra"></div>
            </div>
        </div>
        <div class="modal-example-footer">
            <a id="lnkShowDesktop" href="#" title="Volver a inicio" class="white-text padding5 circle right"><i class="material-icons md-32">&#xE88A;</i></a>
            <a id="lnkCloseAll" href="#" title="Cerrar todo" class="white-text padding5 circle left"><i class="material-icons md-32">clear_all</i></a>
        </div>
    </div>
</div>
<?php endif; ?>
<div id="charmOptions" class="control-center home">
    <div class="scrollbarra">
        <div class="container-user">
            <button id="btnChangeUser" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--fab button-img-user no-padding mdl-shadow--4dp" type="button"><img src="<?php echo $fotoUsuario == 'no-set' ? 'images/dish-icon.png' : $fotoUsuario; ?>" class="circle" alt="" width="80" height="80"></button>
            <div class="info-user place-bottom-left-right padding10">
                <div data-iduser="<?php echo $idusuario; ?>">
                    <h4 class="text-shadow white-text"><?php echo $login; ?></h4>
                    <h5 class="text-shadow white-text">CENTRO: <?php echo $nombre_centro; ?></h5>
                </div>
            </div>
        </div>
        <ul id="menuModulo" class="list-options">
        </ul>
        <ul id="menuBottomSettings" class="list-options">
            <li class="divider"></li>
            <?php if ($screenmode != 'cliente'): ?>
            <li><a class="grey-text text-darken-4" data-action="home" href="#"><i class="material-icons icon">&#xE88A;</i><span class="text">Inicio</span></a></li>
            <?php if ($multicentro == 1): ?>
            <li><a class="grey-text text-darken-4" data-action="center" href="#"><i class="material-icons icon">&#xEB3F;</i><span class="text">Sedes</span></a></li>
            <?php endif; ?>
            <li><a class="grey-text text-darken-4" data-action="recents" href="#"><i class="material-icons icon">&#xE889;</i><span class="text">Sitios recientes</span>
            </a></li>
            <?php endif; ?>
            <li><a class="grey-text text-darken-4" data-action="settings" href="#"><i class="material-icons icon">&#xE8B8;</i><span class="text">Configuraci&oacute;n</span></a></li>
            <li><a class="grey-text text-darken-4" data-action="help" href="#"><i class="material-icons icon">&#xE887;</i><span class="text">Ayuda</span></a></li>
            <li><a class="grey-text text-darken-4" data-action="logout" href="logout.php"><i class="material-icons icon">&#xE879;</i><span class="text">Cerrar sesi&oacute;n</span></a></li>
        </ul>
    </div>
</div>
<?php if ($screenmode != 'cliente'): ?>
<div id="modalCentros" class="modalcuatro bg-opacity-8 modal-example-content expand-phone">
    <form id="formCentros" name="formCentros" method="POST" action="services/home/home-post.php">
        <input type="hidden" name="hdIdCentro" id="hdIdCentro" value="<?php echo $IdCentro; ?>">
        <input type="hidden" name="lang" id="lang" value="<?php echo $lang; ?>">
        <div class="modal-example-header">
            <div class="left">
                <a href="#" title="Ocultar" class="close-modal-example white-text padding5 circle left"><i class="material-icons md-32">close</i></a>
                <h3 class="no-margin white-text left">
                    Sedes
                </h3>
            </div>
        </div>
        <div class="modal-example-body">
            <div id="gvCentros" class="mdl-grid scrollbarra padding20"></div>
        </div>
        <div class="modal-example-footer">
            <button id="btnSetCentro" type="submit" class="mdl-button mdl-js-button mdl-js-ripple-effect btn-primary right">
                Seleccionar sede
            </button>
        </div>
    </form>
</div>
<?php endif; ?>