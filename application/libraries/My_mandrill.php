<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_Mandrill {
	
	public function My_Mandrill()
	{
		require_once('mandrill/Mandrill.php');
	}
	
}
?>