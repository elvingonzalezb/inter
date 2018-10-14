<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'inicio';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['busqueda'] = "frontend/busqueda";
$route['busqueda/buscar/([0-9]+)'] = "frontend/busqueda/buscar";

$route['acerca-nosotros'] = "frontend/acerca";
$route['como-comprar'] = "frontend/como_comprar";
$route['condiciones-uso'] = "frontend/condiciones";
$route['politicas-privacidad'] = "frontend/politicas";
$route['ofertas/([0-9]+)'] = "frontend/ofertas";
$route['novedades/([0-9]+)'] = "frontend/novedades";
$route['productos/([0-9]+)'] = "frontend/producto";

$route['detalle-producto/([0-9]+)/([0-9]+)/(.*)'] = "frontend/producto/detalle";
$route['detalle-producto/([0-9]+)/(.*)'] = "frontend/producto/detalle";

$route['subcategoria/([0-9]+)/(.*)/([0-9]+)'] = "frontend/productoxsubcat/index/";
$route['categoria/([0-9]+)/(.*)/([0-9]+)'] = "frontend/productoxcat/index/";

$route['producto/([0-9]+)/([a-z_-]+)'] = "frontend/producto/index/$1/$2";
$route['ubiquenos'] = "frontend/ubiquenos";
$route['contactenos'] = "frontend/contactenos";
$route['contactenos/enviar-mensaje'] = "frontend/contactenos/enviar_mensaje";
$route['contactenos/(.*)'] = "frontend/contactenos";
$route['registrese'] = "frontend/registrese";
$route['registrese/grabar'] = "frontend/registrese/grabar";
$route['registrese/(.*)'] = "frontend/registrese";
$route['ingresar'] = "frontend/ingresar";
$route['ingresar/logueo'] = "frontend/ingresar/logueo";
$route['ingresar/logout'] = "frontend/ingresar/logout";
$route['ingresar/(.*)'] = "frontend/ingresar";
$route['exportar/excel'] = "frontend/exportar/excel";

$route['pedido/agregarProximamente'] = "frontend/pedido/agregarProximamente";
$route['pedido/agregar'] = "frontend/pedido/agregar";

$route['pedido/(.*)'] = "frontend/pedido";
$route['mis-datos/actualizacion'] = "frontend/mis_datos/form_actualizacion";
$route['mis-datos/actualizacion/grabar'] = "frontend/mis_datos/grabar";
$route['mis-datos/actualizacion/(.*)'] = "frontend/mis_datos/form_actualizacion";
$route['recordar-contrasena'] = "frontend/recordar_contrasena";
$route['recordar-contrasena/buscar'] = "frontend/recordar_contrasena/buscar";
$route['recordar-contrasena/(.*)'] = "frontend/recordar_contrasena";
$route['modal/(.*)'] = "frontend/modal";
$route['inventario'] = "frontend/inventario";

$route['reservas/listado/([0-9]+)'] = "frontend/reservas/listado";
$route['reservas/detalle/([0-9]+)'] = "frontend/reservas/detalle";
$route['reservas/comprar/([0-9]+)'] = "frontend/reservas/comprar";
$route['reservas/doCompra'] = "frontend/reservas/doCompra";
$route['reservas/anular/([0-9]+)'] = "frontend/reservas/anular";
$route['reservas/doAnulacion'] = "frontend/reservas/doAnulacion";
$route['reservas/impresion/([0-9]+)'] = "frontend/reservas/impresion";

$route['reservas/compraMultiple'] = "frontend/reservas/compraMultiple";
$route['reservas/doCompraMultiple'] = "frontend/reservas/doCompraMultiple";
$route['reservas/actualizaReserva'] = "frontend/reservas/actualizaReserva";

$route['reservas/cargos/([0-9]+)'] = "frontend/reservas/cargos";
$route['reservas/saveCargos'] = "frontend/reservas/saveCargos";

$route['reservas/modificar/([0-9]+)'] = "frontend/reservas/modificar";
$route['reservas/modificar/([0-9]+)/(.*)'] = "frontend/reservas/modificar/$1/$2";

$route['vendedores/(.*)/(.*)'] = "frontend/vendedores/$1/$2";
$route['vendedores/(.*)'] = "frontend/vendedores/$1";


$route['proximosIngresos/([0-9]+)'] = "frontend/proximos_ingresos/listado/$1";
$route['proximos-ingresos/(.*)/(.*)'] = "frontend/proximos_ingresos/xfecha/$1/$2";
$route['proximos-ingresos'] = "frontend/proximos_ingresos";

$route['compras/listado/([0-9]+)'] = "frontend/compras/listado";
$route['compras/detalle/([0-9]+)'] = "frontend/compras/detalle";
$route['compras/impresion/([0-9]+)'] = "frontend/compras/impresion";

// ADMINISTRACION
$route['mainpanel'] = "mainpanel/login";
$route['mainpanel/validar'] = "mainpanel/login/validar";
$route['mainpanel/inicio'] = "mainpanel/inicio/index";
//$route['mainpanel/informativa'] = "mainpanel/informativa/index";
$route['mainpanel/logout'] = "mainpanel/login/logout";
$route['mainpanel/error/([a-z_-]+)'] = "mainpanel/login/index/$1";