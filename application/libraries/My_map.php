<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_Map {
	
	public function My_Map()
	{
		require_once("maps/simpleGMapAPI.php");
		require_once("maps/simpleGMapGeocoder.php");
	}
	
}
?>