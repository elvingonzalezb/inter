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
              <h1 class="nice-title"><?php echo $contenido->titulo;?></h1>
            </div>
            <div class="contenido">
                <div class="sub_contenido">
                    <?php echo $contenido->texto; ?>
                </div>
              
                <div class="sub_contenido">
                    <?php 
                    if($this->session->userdata('msg_registro')){
                       $msg=$this->session->userdata('msg_registro');
                       $this->session->unset_userdata('msg_registro');
                       echo '<div class="succesmsg">'.$msg.'</div>';
                    }
                    
                    if($this->session->userdata("errorRegistro")){
                       echo '<div class="errormsg">'.$this->session->userdata("errorRegistro").'</div>';
                       $this->session->unset_userdata('errorRegistro');
                    }                    

                    // estos son los datos que ya se habia enviado se los guarda en un arrat dentro de una session
                    if($this->session->userdata('arreglo')){
                        $dat=$this->session->userdata('arreglo');
                    }
                    
                    ?>
                    <div id="formulario" class="clearfix">
                        <form action="registrese/grabar" method="post" onSubmit="return valida_registro()">
                            <table width="100%" border="0">
                                <tr>
                                    <td colspan="3"><h3>Informaci&oacute;n Personal</h3></td>
                                </tr>
                                <tr>
                                    <td width="45%" class="etiqueta">Raz&oacute;n Social*:</td>
                                    <td width="10%"></td>
                                    <td width="45%" class="etiqueta">Ruc :</td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="razon_social" id="razon_social" size="50" class="campo" value="<?php if(isset($dat)){echo $dat['razon_social'];}?>"/></td>
                                    <td></td>
                                    <td><input type="text" name="ruc" id="ruc" size="50" class="campo" value="<?php if(isset($dat)){echo $dat['ruc'];}?>" /></td>
                                </tr>                                
                                <tr>
                                    <td class="etiqueta">Persona de Contacto *:</td>
                                    <td></td>
                                    <td class="etiqueta">Cargo *:</td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="nombre" id="nombre" size="50" class="campo" value="<?php if(isset($dat)){echo $dat['nombre'];}?>" /></td>
                                    <td></td>
                                    <td><input type="text" name="cargo" id="cargo" size="50" class="campo" value="<?php if(isset($dat)){echo $dat['cargo'];}?>" /></td>
                                </tr>                                
                                <tr>
                                    <td class="etiqueta">Domicilio :</td>
                                    <td></td>
                                    <td class="etiqueta">Distrito :</td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="domicilio" id="domicilio" size="50" class="campo" value="<?php if(isset($dat)){echo $dat['domicilio'];}?>" /></td>
                                    <td></td>
									<td><input type="text" name="distrito" id="distrito" size="50" class="campo" value="<?php if(isset($dat)){echo $dat['distrito'];}?>"/></td>
                                    
                                </tr> 
                                <tr>
                                    <td class="etiqueta"> Ciudad:</td>
                                    <td></td>
                                    <td class="etiqueta">Provincia :</td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="ciudad" id="ciudad" size="50" class="campo" value="<?php if(isset($dat)){echo $dat['ciudad'];}?>" /></td>
                                    <td></td>
                                    <td><input type="text" name="provincia" id="provincia" size="50" class="campo" value="<?php if(isset($dat)){echo $dat['provincia'];}?>" /></td>                                    
                                </tr>
                                <tr>
                                    <td class="etiqueta">Departamento :</td>
                                    <td></td>
                                    <td class="etiqueta">Pais *:</td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="departamento" id="departamento" size="50" class="campo" value="<?php if(isset($dat)){echo $dat['departamento'];}?>" /></td>
                                    <td></td>
                                    <td>
                                        <select name="pais" id="pais" class="campo">
                                            <option value="0">:: Seleccione ::</option>
                                            <?php 
                                            foreach ($paises as $value) {
                                                $PAI_ISO2=$value->PAI_ISO2;
                                                $nombre=$value->nombre;   
                                                if(isset($dat['pais'])==$PAI_ISO2){
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
                                    <td><input type="text" name="telefono" id="telefono" size="50" class="campo" value="<?php if(isset($dat)){echo $dat['telefono'];}?>"/></td>
                                    <td></td>
                                    <td><input type="text" name="telefono2" id="telefono2" size="50" class="campo" value="<?php if(isset($dat)){echo $dat['telefono2'];}?>"/></td>
                                </tr>                                
                                <tr>
                                    <td class="etiqueta">Facebook Empresarial (de Preferencia) :</td>
                                    <td></td>
                                    <td class="etiqueta">Tipo de Cliente *:</td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="fax" id="fax" size="50" class="campo" value="<?php if(isset($dat)){echo $dat['fax'];}?>"/></td>
                                    <td></td>
                                    <td>
                                    <select name="tipo_cliente" class="campo">
                                    <option value="0">:: Seleccione ::</option>
                                    <option value="Cliente Final" <?php if(isset($dat) && $dat['tipo_cliente']=='Cliente Final'){echo 'selected';}?>>Cliente Final</option>
                                    <option value="Publicistas" <?php if(isset($dat) && $dat['tipo_cliente']=='Publicistas'){echo 'selected';}?>>Publicistas</option>
                                    <option value="Distribuidor" <?php if(isset($dat) && $dat['tipo_cliente']=='Distribuidor'){echo 'selected';}?>>Distribuidor</option>
                                    </select>                                        
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td class="etiqueta">C&oacute;digo Postal *:</td>
                                    <td></td>
                                    <td class="etiqueta">Web (de Preferencia)</td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="zip" id="zip" size="50" class="campo" value="<?php if(isset($dat)){echo $dat['zip'];}?>"/></td>
                                    <td></td>
                                    <td><input type="text" name="web" id="web" size="50" class="campo" value="<?php if(isset($dat)){echo $dat['web'];}?>"/></td>
                                </tr>                                    
                                <tr>
                                    <td colspan="3" height="50"><h3>Informaci&oacute;n de Acceso</h3></td>
                                </tr>
                                <tr>
                                    <td class="etiqueta">Email *:</td>
                                    <td></td>
                                    <td class="etiqueta">Password*:</td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="email" id="email" size="50" class="campo" value="<?php if(isset($dat)){echo $dat['email'];}?>"/></td>
                                    <td></td>
                                    <td><input type="password" name="password" id="password" size="50" class="campo" value="<?php if(isset($dat)){echo $dat['clave'];}?>" /></td>
                                </tr>
                                <tr>
                                    <td class="etiqueta">Repetir el Email *:</td>
                                    <td></td>
                                    <td class="etiqueta">Repetir el Password*:</td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="email_rep" id="email_rep" size="50" class="campo" /></td>
                                    <td></td>
                                    <td><input type="password" name="password_rep" id="password_rep" size="50" class="campo" /></td>
                                </tr>
                                <tr>
                                    <td class="etiqueta">Ingresar el codigo de la imagen *:</td>
                                    <td></td>
                                    <td class="etiqueta"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="codigo" id="codigo" size="20" class="campo" /><?php echo $cap_img; ?></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="center" height="60">
                                        <input type="submit" name="enviar" value="Registrarse" class="boton" />
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