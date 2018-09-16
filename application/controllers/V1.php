<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class V1 extends KA_API_Controller {

	public $data = [
		// Reference
		"abonos" => [
			"model" => "Abonos", /* Podemos meterle alias */
			"folder" => "abonos", /* Si no se pone se coge el string de "modelo" */
			"methods" => [
				"get"		=> ["exec" => "file"],	/* abonos/get.php */
				"get_list",
				"edit",	
				"delete"
			]
		]
	];

	public function index(){
		$this->load->view('welcome_message');
	}

	

}
