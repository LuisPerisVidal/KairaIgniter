<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index(){
		$this->load->view('welcome_message');
	}

	public function prueba(){
		$this->load->model("Abonos", "abonos");

		$this->abonos->add([
			"ID_proveedor" 	=> "idpro",
			"casado" 		=> "1",
			"apellido" 		=> "apellido",
			"precio"		=> "precio",
			"inventado"		=> "something",
			"domiango"		=> "vale"]);


	}
}
