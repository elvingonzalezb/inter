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
            <h2><i class="icon-edit"></i> Buscar Cliente</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" action="mainpanel/clientes/list_search" method="post" enctype="multipart/form-data" onsubmit="return valida_busqueda()">
                <fieldset>
                    <legend>Ingrese los datos de busqueda</legend>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Raz&oacute;n Social</label>
                        <div class="controls">
                            <input type="text" class="span5 typeahead" id="razon_social" name="razon_social" value="" >
                        </div>
                    </div>    
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Persona de Contacto</label>
                        <div class="controls">
                            <input type="text" class="span5 typeahead" id="nombre" name="nombre" value="" >
                        </div>
                    </div>                                   
                    <div class="control-group">
                        <label class="control-label" for="typeahead">RUC</label>
                        <div class="controls">
                            <input type="text" class="span3 typeahead" id="ruc" name="ruc" value="" >
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="typeahead">Tel&eacute;fono</label>
                        <div class="controls">
                            <input type="text" class="span4 typeahead" id="telefono" name="telefono" value="" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Email</label>
                        <div class="controls">
                            <input type="text" class="span5 typeahead" id="email" name="email" value="" >
                        </div>
                    </div>                  
                    <div class="form-actions">
                        <input type="submit" class="btn btn-primary" value="BUSCAR">
                    </div>
                </fieldset>
            </form>   

        </div>
    </div><!--/span-->

</div><!--/row-->