<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/inicio">Inicio</a> <span class="divider">/</span></li>
    </ul>
</div>
<div class="row-fluid">
    <div class="box span12">
        <div class="box-header well">
            <h2><i class="icon-info-sign"></i> Bienvenido</h2>
            <div class="box-icon">
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <p><b>Bienvenido a nuestra Area de Administraci&oacute;n WEB Se&ntilde;or: <?php echo $this->session->userdata('nombre_admin'); ?></b></p>
            <p>Desde aqui puede cambiar realizar algunos cambios en el contenido del Portal.</p>
            <p>Utilice el menú que aparece en el lado izquierdo para navegar entre las opciones de administración. </p>
            <p>Para cambiar su información de acceso de Administrador <a href="mainpanel/usuarios/edit">HAGA CLICK AQUI </a> </p>
            <div class="clearfix"></div>
        </div>
    </div>
</div>