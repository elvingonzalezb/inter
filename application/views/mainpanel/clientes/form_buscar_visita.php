<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/clientes/listado">Lista de Clientes</a>  <span class="divider">/</span></li>
        <li><a href="mainpanel/clientes/listado_inactivos">Clientes Inactivos</a>  <span class="divider">/</span></li>
        <li><a href="mainpanel/clientes/listado_anulados">Clientes Anulados</a> <span class="divider">/</span></li> 
        <li><a href="mainpanel/clientes/listado_borrados">Clientes Borrados</a> <span class="divider">/</span></li>       
        <li><a href="mainpanel/clientes/search_visitas">Buscar Visitas</a> <span class="divider">/</span></li>                        
        <li><a href="mainpanel/clientes/form_buscar">Buscar Clientes</a> </li>       
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Buscar Visitas</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" action="mainpanel/clientes/list_search_visitas" method="post" enctype="multipart/form-data" onsubmit="return valida_busqueda_visita()">
                <fieldset>
                    <legend>Ingrese los datos de b&uacute;squeda</legend>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Cliente</label>
                        <div class="controls">
                            <select name="id_cliente" id="id_cliente">
                                <option value="0">:: TODOS LOS CLIENTES ::</option>
                                <?php 
                                foreach ($clientes as $value) {
                                    echo '<option value="'.$value->id.'">'.$value->razon_social.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>                     
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Desde</label>
                        <div class="controls">
                            <input type="text" class="input-xlarge datepicker hasDatepicker" name="fecha_inicio" id="fecha_inicio" value="<?php echo fecha_hoy_dmY2()?>">
                            <img src="assets/frontend/cki/imagenes/calendar.gif" alt="" name="trigger" align="absmiddle" id="trigger" title="Abrir Calendario" /> 
                        </div>
                    </div>                  
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Hasta</label>
                        <div class="controls">
                            <input type="text" class="input-xlarge datepicker hasDatepicker" name="fecha_fin" id="fecha_fin" value="<?php echo fecha_hoy_dmY2()?>">
                            <img src="assets/frontend/cki/imagenes/calendar.gif" alt="" name="trigger1" align="absmiddle" id="trigger1" title="Abrir Calendario" />                             
                        </div>
                    </div>  

                    <div class="form-actions">
                        <input type="submit" class="btn btn-primary" value="BUSCAR">
                    </div>
                    
                </fieldset>
            </form>   
            <script type="text/javascript">//<![CDATA[


                //]]></script>             

        </div>
    </div><!--/span-->

</div><!--/row-->