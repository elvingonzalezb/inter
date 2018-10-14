<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_SendGrid {
	
	public function My_SendGrid()
	{
		require("sendgrid-php/sendgrid-php.php");
	}
	
}
?>