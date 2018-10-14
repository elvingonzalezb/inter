<div>
    <ul class="breadcrumb">
<!--        <li><a href="mainpanel/informativa/edit/inicio">Inicio</a> <span class="divider">/</span></li>                -->
<!--        <li><a href="mainpanel/informativa/edit/acerca-nosotros">Acerca de Nosotros</a> <span class="divider">/</span></li>        
        <li><a href="mainpanel/informativa/edit/como-comprar">Como comprar</a> <span class="divider">/</span></li>        -->
        <li><a href="mainpanel/informativa/edit/inicio">Inicio</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/informativa/edit/productos">Productos</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/informativa/edit/novedades">Novedades</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/informativa/edit/ofertas">Ofertas</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/informativa/edit/registro">Registro</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/informativa/edit/inciar_sesion">Inicio Sesi&oacute;n</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/informativa/edit/contactenos">Contactenos</a> <span class="divider">/</span></li>        
<!--        <li><a href="mainpanel/informativa/edit/olvido_clave">Recordar Contraseña</a> <span class="divider">/</span></li>        
        <li><a href="mainpanel/informativa/edit/newsletter">Newsletter</a>-->
        <li><a href="mainpanel/informativa/edit/condiciones_uso">Condiciones de Uso</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/informativa/edit/politicas_privacidad">Pol&iacute;ticas Privacidad</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/informativa/edit/modal_inicio">Modal Inicio</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/informativa/edit/pedidos_directos">Modal Pedidos Directos</a> </li>
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Edici&oacute;n de Contenidos</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" action="mainpanel/informativa/actualizar" method="post">
                <fieldset>
                    <legend>Modifique los datos deseados</legend>
                    <?php
                        if(isset($resultado) && ($resultado=="success"))
                        {
                            echo '<div class="alert alert-success">';
                            echo '<button type="button" class="close" data-dismiss="alert">×</button>';
                            echo '<strong>RESULTADO:</strong> Los datos se actualizaron correctamente';
                            echo '</div>';
                        }
                    ?>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Título</label>
                        <div class="controls">
                            <input type="text" class="span6 typeahead" id="titulo" name="titulo" value="<?php echo $titulo_seccion; ?>" >
                        </div>
                    </div>        
                    <div class="control-group">
                        <label class="control-label" for="textarea2">Texto</label>
                        <div class="controls">
                            <textarea id="texto" name="texto" rows="3"><?php echo $texto_seccion; ?></textarea>
                            <script type="text/javascript">
							/*
                                window.onload = function()
                                {
                                    var oFCKeditor = new FCKeditor( 'texto' ) ;
                                    oFCKeditor.BasePath = "<?php echo base_url();?>assets/fckeditor/";
                                    oFCKeditor.Width  = '700' ;
                                    oFCKeditor.Height = '350' ;
                                    oFCKeditor.ReplaceTextarea();
                                }
								*/
								<?php
									switch($seccion)
									{
										case "modal_inicio":
										case "pedidos_directos":
								?>
										CKEDITOR.replace( 'texto', { width:600 } );
								<?php
										break;
										
										default:
								?>
										CKEDITOR.replace( 'texto' );
								<?php	
										break;	
									}
								?>
                            </script>
                        </div>
                    </div>
                    <div class="form-actions">
                        <input type="hidden" name="seccion" id="seccion" value="<?php echo $seccion;?>">
                        <input type="submit" class="btn btn-primary" value="GRABAR">
                    </div>
                </fieldset>
            </form>   

        </div>
    </div><!--/span-->

</div><!--/row-->