<div id="wrap-content">
  <div id="breadcrumb">
<!--    <a href="#" class="breadcrumbHome">Homepage</a><span class="seperator"> &nbsp; </span><a href="#">Computers</a><span class="seperator"> &nbsp; </span><a href="#">Laptops</a><span class="seperator"> &nbsp; </span><span>Dell</span>-->
  </div>
  <div id="main-content">
    <div id="left-column">
      <?php echo $izquierda;?>
    </div> 
    <div id="right-column">
      <div id="content">
        <div class="wrap-featured-products">
            <div class="wrap-title-black">
                <h1 class="nice-title">Actualización de Datos</h1>
            </div>
            <div class="contenido">
              
                <div class="sub_contenido">
                    <?php 
                    if(isset($resultado) && $resultado=='success'){
                       echo '<div class="succesmsg">Actualización Exitosa</div>';
                    }
                    if(isset($resultado) && $resultado=='error-bd'){
                       echo '<div class="errormsg">Ocurrió un error al actualizar su información.</div>';
                    } 
                    if(isset($resultado) && $resultado=='error-ruc'){
                       echo '<div class="errormsg">El RUC ingresado es Incorrecto.</div>';
                    }                     
                    ?>
                    <div id="formulario" class="clearfix">
                        <form action="mis-datos/actualizacion/grabar" method="post" onSubmit="return valida_actualizacion()">
                            <table width="100%" border="0">
                                <tr>
                                    <td width="45%" class="etiqueta">Nombre o Razón Social*:</td>
                                    <td width="10%"></td>
                                    <td width="45%" class="etiqueta">Ruc *:</td>
                                </tr>
                                <tr>
                                    <td><?php echo $cliente->razon_social;?></td>
                                    <td></td>
                                    <td><?php echo $cliente->ruc;?></td>
                                </tr>                                
                                <tr>
                                    <td class="etiqueta">Nombre *:</td>
                                    <td></td>
                                    <td class="etiqueta">Cargo *:</td>
                                </tr>
                                <input type="hidden" name="razon_social" id="razon_social" size="50" class="campo" value="<?php echo $cliente->razon_social;?>"/>
                                <input type="hidden" name="ruc" id="ruc" size="50" class="campo" value="<?php echo $cliente->ruc;?>" />
                                <tr>
                                    <td><input type="text" name="nombre" id="nombre" size="50" class="campo" value="<?php echo $cliente->nombre;?>" /></td>
                                    <td></td>
                                    <td><input type="text" name="cargo" id="cargo" size="50" class="campo" value="<?php echo $cliente->cargo;?>" /></td>
                                </tr>                                
                                <tr>
                                    <td class="etiqueta">Domicilio *:</td>
                                    <td></td>
                                    <td class="etiqueta">Distrito *:</td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="domicilio" id="domicilio" size="50" class="campo" value="<?php echo $cliente->domicilio;?>" /></td>
                                    <td></td>
									<td><input type="text" name="distrito" id="distrito" size="50" class="campo" value="<?php echo $cliente->distrito;?>" /></td>
                                </tr> 
                                <tr>
                                    <td class="etiqueta"> Ciudad *:</td>
                                    <td></td>
                                    <td class="etiqueta"> Provincia *:</td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="ciudad" id="ciudad" size="50" class="campo" value="<?php echo $cliente->ciudad;?>" /></td>
                                    <td></td>
                                    <td><input type="text" name="provincia" id="provincia" size="50" class="campo" value="<?php echo $cliente->provincia;?>" /></td>                             </tr>
                                <tr>
                                    <td class="etiqueta">Departamento *:</td>
                                    <td></td>
                                    <td class="etiqueta">País *:</td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="departamento" id="departamento" size="50" class="campo" value="<?php echo $cliente->departamento;?>" /></td>
                                    <td></td>
                                    <td>
                                        <select name="pais" id="pais" class="campo">
                                            <option value="0">:: Seleccione ::</option>
                                            <?php 
                                            foreach ($paises as $value) {
                                                $PAI_ISO2=$value->PAI_ISO2;
                                                $nombre=$value->nombre;   
                                                if($cliente->pais==$PAI_ISO2){
                                                    echo '<option value="'.$PAI_ISO2.'" selected>'.$nombre.'</option>';                                                    
                                                }else{
                                                    echo '<option value="'.$PAI_ISO2.'">'.$nombre.'</option>';                                                    
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>                                    
                                </tr> 
                                <tr>
                                    <td class="etiqueta">T&eacute;lefono *:</td>
                                    <td></td>
                                    <td class="etiqueta">T&eacute;lefono2 :</td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="telefono" id="telefono" size="50" class="campo" value="<?php echo $cliente->telefono;?>"/></td>
                                    <td></td>
                                    <td><input type="text" name="telefono2" id="telefono2" size="50" class="campo" value="<?php echo $cliente->telefono2;?>"/></td>
                                </tr>                                
                                <tr>
                                    <td class="etiqueta">Facebook Empresarial (de Preferencia) :</td>
                                    <td></td>
                                    <td class="etiqueta">Tipo de Cliente *:</td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="fax" id="fax" size="50" class="campo" value="<?php echo $cliente->fax;?>"/></td>
                                    <td></td>
                                    <td>
                                    <select name="tipo_cliente" class="campo">
                                    <option value="0">:: Seleccione ::</option>
                                    <option value="Cliente Final" <?php if($cliente->tipo_cliente=='Cliente Final'){echo 'selected';}?>>Cliente Final</option>
                                    <option value="Publicistas" <?php if($cliente->tipo_cliente=='Publicistas'){echo 'selected';}?>>Publicistas</option>
                                    <option value="Distribuidor" <?php if($cliente->tipo_cliente=='Distribuidor'){echo 'selected';}?>>Distribuidor</option>
                                    </select>                                        
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td class="etiqueta">Código Postal *:</td>
                                    <td></td>
                                    <td class="etiqueta">Web (de Preferencia)</td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="zip" id="zip" size="50" class="campo" value="<?php echo $cliente->zip; ?>"/></td>
                                    <td></td>
                                    <td><input type="text" name="web" id="web" size="50" class="campo" value="<?php echo $cliente->web; ?>"/></td>
                                </tr>                             
<!--                                <tr>
                                    <td colspan="3" height="50"><h3>Informaci&oacute;n de Acceso</h3></td>
                                </tr>
                                <tr>
                                    <td class="etiqueta">Email :</td>
                                    <td></td>
                                    <td class="etiqueta">Password:</td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="email" id="email" readonly="readonly" size="50" class="campo" value="<?php echo $cliente->email;?>"/></td>
                                    <td></td>
                                    <td><input type="password" name="password" id="password" size="50" class="campo" value="<?php echo $cliente->clave;?>" /></td>
                                </tr>
                                <tr>
                                    <td class="etiqueta">Nuevo Password:</td>
                                    <td></td>
                                    <td class="etiqueta">Repetir Nuevo Password:</td>
                                </tr>
                                <tr>
                                    <td><input type="password" name="new_pass" id="new_pass" size="50" class="campo" /></td>
                                    <td></td>
                                    <td><input type="password" name="rep_new_pass" id="rep_new_pass" size="50" class="campo" /></td>
                                </tr>-->
<!--                                <tr>
                                    <td class="etiqueta">Ingresar el codigo de la imagen *:</td>
                                    <td></td>
                                    <td class="etiqueta"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="codigo" id="codigo" size="20" class="campo" /><?php //echo $image;?></td>
                                    <td></td>
                                    <td></td>
                                </tr>                                 -->
                                <tr>
                                    <td colspan="3" align="center" height="60">
                                        <input type="submit" name="enviar" value="Actualizar" class="boton" />
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div><!-- formulario --> 
                </div><!--sub_contenido-->
            </div>
        </div><!--wrap-featured-products-->
        
        
      </div>
    </div>
  </div>
</div>