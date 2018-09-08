<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class KA_Model extends CI_Model{


	public function get($id){

	}


	public function get_list(){



	}

	public function add($data){

		$columns = $this->data["add"]["columns"];

		$array_prepare = $this->every_necessary($columns, $data);

		if($array_prepare != false){

			if( isset($this->data["add"]["optionals"]) ){

				$optionals = $this->every_necessary($this->data["add"]["optionals"], $data, true);

				$array_prepare = array_merge($array_prepare, $optionals);

			}

/*			$this->db->insert($this->data["table"], $datos);
		
			if ( $this->db->affected_rows() == 1 ) {
				return $this->db->insert_id();
			}
*/
		}

		return false;

	}


	public function edit($data){

		// Igual que Add
		// Pero puede no existir column


	}


	public function delete($id){

	}

	/**
	 * @see Comprueba las columnas existes con las recebidas y parsea todo
	 * @param	$columns	Columnas de la DDBB
	 * @param	$data		Datos mandados por el usuario
	 * @param	$optionals	Si es optional, devuelve "las coincidencias", sino, si sólo una no existe, devuelve false
	*/
	public function every_necessary($columns, $data, $optionals=false){

		$error = false;
		$array = [];
		$tmp = "";


		foreach ($columns as $key => $value) {

			// Si la columan NO es INT entonces es que se valida (int, float...)
			if(is_int($key)){
				$tmp_col = $value;

				if( isset($data[$tmp_col])){
					// Añadir a $arras después de limpiar
					$array[$tmp_col] = $data[$tmp_col];
				}else{
					$error = true;
				}
	
			}else{
				$tmp_col = $key;

				// limpia la columna
				if( isset($data[$tmp_col])){
					$array[$tmp_col] = $this->clean_value($data[$tmp_col], $value);

				}else{
					$error = true;
				}

			}

		}

		if($optionals){
			return $array;
		}else{
			if($error){
				return false;
			}else{
				return $array;
			}
		}

	}

	/* Limpia las columnas, si así se han programado */
	public function clean_value($key, $filter){

		switch ($filter) {
			case 'int':
				return (int) $key;
				break;
			
			case 'float':
				return (float) $key;
				break;
			
			case 'boolean':
				return (boolean) $key;
				break;
			
			default:
				return $key;
				break;
		}



	}



}