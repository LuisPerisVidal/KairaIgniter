<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class KA_API_Controller extends CI_Controller {

	public function _remap($reference, $method=null){
		$method = $method[0];
	
		// Comprueba si el reference es válido
		if( is_array(@$this->data[$reference]) ){

			// Normaliza el array de los métodos disponibles
			$available_meth = $this->_order_array($this->data[$reference]["methods"]);

			// Comprueba si existe el método
			if( is_array(@$available_meth[$method]) ){

				// Ejecutamos el modelo
				if (is_string(@$this->data[$reference]["model"]) ){
					$this->model_name = $this->data[$reference]["model"];
					$this->load->model($this->data[$reference]["model"]);

				}elseif( is_array(@$this->data[$reference]["model"]) ){

					if( isset($this->data[$reference]["model"]["alias"] ) ){
						$this->model_name = $this->data[$reference]["model"]["alias"];
						$this->load->model($this->data[$reference]["model"]["name"], $this->data[$reference]["model"]["alias"]);
					}else{
						$this->model_name = $this->data[$reference]["model"]["name"];
						$this->load->model($this->data[$reference]["model"]["name"]);
					}


				}else{
					return false;
					// No existe
				}


				// ¿Es fichero?
				if( isset($available_meth[$method]["exec"]) ){
					// Se ejecuta el fichero

					if(file_exists( "application/controllers/{$this->data[$reference]["folder"]}/{$method}.php" )){
						// Si encuentra el fichero
						include_once("application/controllers/{$this->data[$reference]["folder"]}/{$method}.php");
					}else{
						// Si no encuentra el fichero
						return false;
					}
				}else{
					// Se ejecuta la función
					$tmp = $this->{$this->model_name}->{$method}($this->input->post());
					print_r($tmp);

				}

			}else{
				//				return false;
			}

			
		}else{
//			return false;
		}


	}

	/**
	 * @see		Función que normaliza el array data de la API
	 * @param	$param		El array a normalizar
	 * @return	array	Devuelve el array normalizado
	 */
	public function _order_array($array){

		$new_array = [];

		foreach ($array as $key => $value) {
			if( is_int($key) ){
				$new_array[$value] = [];
			}else{
				$new_array[$key] = $value;
			}
		}

		return $new_array;

	}


}

include_once('Controller_kaira.php');