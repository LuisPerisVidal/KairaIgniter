<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index(){
		$this->load->view('welcome_message');
	}

	public function prueba(){
		$this->load->model("Abonos", "abonos");

		/*$this->abonos->add([
			"fecha" => "2015-12-12",
			"ID_cliente" => "1",
			"estado" => "pendiente",
			"ID_moneda" => "1",
			"ID_forma_de_pago" => "1",
			"vencimiento" =>  "2015-12-12",
			"ID_campana" => "1",
			"texto_libre" => "Texto libre",
			"fecha_original_rectificada" => "2015-12-12",
			"ID_factura" => "1"]);*/

		$a = $this->abonos->edit([
			"ID" => 10,
			"fecha" => "2015-12-12",
			"ID_cliente" => "1",
			"estado" => "pendiente",
			"ID_moneda" => "1",
			"ID_forma_de_pago" => "1",
			"vencimiento" =>  "2225-12-12",
			"ID_campana" => "1",
			"texto_libre" => "asibre",
			"fecha_original_rectificada" => "2015-12-12",
			"ID_factura" => "1"]);

		/*$tmp = $this->abonos->get_list([
			"abono_view.ID_cliente"	=>	1,
			"abono_view.fecha" => "0011-11-11"]);
		*/

		/*$tmp = $this->abonos->get([
			"abono_view.ID"	=>	2,
			"abono_view.fecha" => "0011-11-11"]);*/

		/*$this->abonos->delete(["ID"=>6, "zoco"=>"23"]);*/
		

		var_dump($a);
	

	}
}
