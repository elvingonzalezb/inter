
<head>
    <link href="assets/frontend/cki/css/style.css" rel="stylesheet">
    <style>
        .clearfix:after {
        content: "."; 
        display: block; 
        height: 0; 
        clear: both; 
        visibility: hidden;
        }
        .clearfix {display: inline-table;}
        /* Hides from IE-mac \*/
        * html .clearfix {height: 1%;}
        .clearfix {display: block;}
        
        body{
            background: #F6F6F6;
        }
        #divco{
            padding:5px 2%;
            background:#EBEBEB;
            border:#D5D5D5 solid 1px;
            width: 96%;
            min-height:200px;            
        }
        .divcolor{
            width:50px;
            height:50px;
            border: #D5D5D5 1px solid;
            margin:auto;            
        }
        .contco{
            float:left;
            margin:5px;            
        }
        #divtitulopedi h2{
            color:#0080FF;
            font-size:16px;
            font-family: Arial, Tahoma;
            -webkit-margin-before: 1em;
            -webkit-margin-after: 1em;
            -webkit-margin-start: 0px;
            -webkit-margin-end: 0px;
            font-weight: bold;            
        }  
        .campo{
                -moz-border-radius: 5px; /* Firefox*/
                -ms-border-radius: 5px; /* IE 8.*/
                -webkit-border-radius: 5px; /* Safari,Chrome.*/
                border-radius: 5px; /* El estándar.*/
                border:#D6D6D6 solid 1px;
                min-height:20px;
                padding:3px;
                font-size:11px;
        }
        .boton_carrito{
                width:120px;
                height:30px;
                display:block;
                margin:0;
                padding:0;
                    
        }
        
    </style>
</head>
<div id="divtitulopedi">
    <h2><?php echo $producto->nombre;?></h2>
</div>
<div>
    <form action="pedidos/grabar" method="post" onSubmit="return valida_env_pedido()">
        <div id="divco" class="clearfix">
            <?php
            $cont=0;
            foreach ($colores as $value) {
                $cont +=1;
                $color=$value->color;
                echo '<div class="contco">';
                echo '<div id="color'.$cont.'" class="divcolor" style="background:'.$color.';"></div>';
                echo '<input type="text" id="cant'.$cont.'" size="3" class="campo">';
                echo '</div>';
            }
            ?>
        <input type="submit" class="boton_carrito" value="ENVIAR">
        <input type="hidden" id="cont" value="<?php echo $cont;?>" />
        </div>
        

    </form>
</div>

<script src="assets/frontend/cki/js/functions.js"></script>