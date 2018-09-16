<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class KA_Model extends CI_Model{


	public function get($input=null, $param_data = null){

		$pull_data = ($param_data==null) ? $this->data["get"] : $param_data;

		return $this->get_list($input, $pull_data, true);

	}


	/**
	 * @see		Método para sacar listados
	 * @param	@input		En principio será null, pero puede que el usuario mande un array para el "where"
	 * @param	@param_data	Para usar este método como capa de abstracción para meterle un array diferente
	 * @param	@row_array	Devuelve la primera fila (Genial para el get)
	*/
	public function get_list($input=null, $param_data = null, $row_array = false){

		// Si se manda el JSON por POST en la variable ka_json
		if(isset($_POST["ka_json"]) ){

			$input = json_decode($_POST["ka_json"], true);

		// Comprueba si es un JSON el $input
		}elseif( is_string($input) && is_array(json_decode($input, true)) ){

			$input = json_decode($input, true);

		}

		$pull_data = ($param_data==null) ? $this->data["get_list"] : $param_data;

		// Select
		$select = isset($pull_data["select"]) ? $pull_data["select"] : "*";

		$this->db->select($select);

		// Table: Puede que tenga otra tabla/vista	
		$table = isset($pull_data["table"]) ? $pull_data["table"] : $this->data["table"];

		$this->db->from($table);

		// Joins
		if( isset($pull_data["join"]) ){

			foreach ($pull_data["join"] as $table_join => $value) {

				$t_join = isset($value["alias"]) ? "{$table_join} as {$value["alias"]}" : $table_join;
				$type = isset($value["type"]) ? $value["type"] : "left";

				$this->db->join($t_join, $value["on"], $type);

			}

		}

		// Where
		if( $input != null && isset($pull_data["where"]) ){

			// Where required
			if( isset($pull_data["where"]["columns"] ) ){

				$where_required = $this->every_necessary($pull_data["where"]["columns"], $input);

				if($where_required == false){
					return false;
				}else{
					foreach ($where_required as $key => $value) {
						$this->db->where($key, $value);
					}
				}

			}

			// Where optionals
			if( isset($pull_data["where"]["optionals"] ) ){

				$where_optionals = $this->every_necessary($pull_data["where"]["optionals"], $input, true);

				foreach ($where_optionals as $key => $value) {
					$this->db->where($key, $value);
				}
			}

		}


		if($row_array){
			$result = $this->db->get()->row_array();
		}else{
			$result = $this->db->get()->result_array();
		}

		if( $result ) {
			return $result;
		}else {
			return false;
		}

	}

	public function add($input=null, $param_data=null){

		// Si se manda el JSON por POST en la variable ka_json
		if(isset($_POST["ka_json"]) ){

			$input = json_decode($_POST["ka_json"], true);

		// Comprueba si es un JSON el $input
		}elseif( is_string($input) && is_array(json_decode($input, true)) ){

			$input = json_decode($input, true);

		}

		// Comprobamos el origen de los datos
		$pull_data = ($param_data==null) ? $this->data["add"] : $param_data;

		// Table: Puede que tenga otra tabla/vista	
		$table = isset($pull_data["table"]) ? $pull_data["table"] : $this->data["table"];

		// Comprobamos que tengan las columnas requeridas
		$array_prepare = $this->every_necessary($pull_data["columns"], $input);

		if($array_prepare != false){

			if( isset($pull_data["optionals"]) ){

				$optionals = $this->every_necessary($pull_data["optionals"], $input, true);

				$array_prepare = array_merge($array_prepare, $optionals);

			}

			$this->db->insert($table, $array_prepare);
		
			if ( $this->db->affected_rows() == 1 ) {
				return $this->db->insert_id();
			}

		}

		return false;

	}


	public function edit($input=null, $param_data=null){

		// Si se manda el JSON por POST en la variable ka_json
		if(isset($_POST["ka_json"]) ){

			$input = json_decode($_POST["ka_json"], true);

		// Comprueba si es un JSON el $input
		}elseif( is_string($input) && is_array(json_decode($input, true)) ){

			$input = json_decode($input, true);

		}

		// Comprobamos el origen de los datos
		$pull_data = ($param_data==null) ? $this->data["edit"] : $param_data;

		// Table: Puede que tenga otra tabla/vista	
		$table = isset($pull_data["table"]) ? $pull_data["table"] : $this->data["table"];

		#SET
			// Columnas obligatorias (pueden no existir)
			if( isset($pull_data["columns"]) ){
				$array_columns = $this->every_necessary($pull_data["columns"], $input);

				// Si tiene obligatorias pero no se han mandado
				if(!$array_columns){ return false; }
			}

			// Columnas opcionales
			if( isset($pull_data["optionals"]) ){
				$array_optionals = $this->every_necessary($pull_data["optionals"], $input, true);
			}

			// Si $array_columns y $array_optionals son array se juntan
			if( is_array(@$array_columns) && is_array(@$array_optionals) && count($array_optionals)>0 ){

				$array_prepare = array_merge($array_columns, $array_optionals);

			// Si $array_columns no existe o es 0 nos quedamos con $array_columns
			}elseif (is_array(@$array_columns) && (!is_array(@$array_optionals) || count($array_optionals)==0 ) ){

				$array_prepare = $array_columns;

			// Si no existe $array_columns pero sí opcionales
			}elseif( !is_array(@$array_columns) && is_array(@$array_optionals) && count($array_optionals) ){

				$array_prepare = $array_optionals;

			}else{
				return false;
			}

		// Comprobamos que tengamos todos los where
		if( isset($pull_data["where"]["columns"]) ){

			$where = $this->every_necessary($pull_data["where"]["columns"], $input);

			// No se ha mandado todo los where obligatorios
			if( is_array($where) ){
				foreach ($where as $key => $value) {
					$this->db->where($key, $value);
				}
		
				$this->db->update($table, $array_prepare);

				if ( $this->db->affected_rows() == 1 ) {
					return true;
				}else {
					return false;
				}
		
			}

		}

		return false;

	}


	public function delete($input=null, $param_data=null){

		// Si se manda el JSON por POST en la variable ka_json
		if(isset($_POST["ka_json"]) ){

			$input = json_decode($_POST["ka_json"], true);

		// Comprueba si es un JSON el $input
		}elseif( is_string($input) && is_array(json_decode($input, true)) ){

			$input = json_decode($input, true);

		}

		$pull_data = ($param_data==null) ? $this->data["delete"] : $param_data;

		// table
		$table = isset($pull_data["table"]) ? $pull_data["table"] : $this->data["table"];

		// Columnas obligatorias (pueden no existir)
		if( isset($pull_data["where"]["columns"]) ){
			$array_where = $this->every_necessary($pull_data["where"]["columns"], $input);

			// Si tiene obligatorias pero no se han mandado
			if( !is_array($array_where) ){
				return false;
			}
		}else{
			return false;
		}

		$this->db->delete($table, $array_where);
		if ( $this->db->affected_rows() == 1 ) {
			return true;
		}else {
			return false;
		}

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