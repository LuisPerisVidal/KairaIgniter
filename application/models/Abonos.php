<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Abonos extends KA_Model {

	public $data = [
		"table" => "abonos",
		"primary" => "ID",

		"add" => [
			"columns" => [
				"ID_proveedor" => "int",
				"casado" => "float",
				"apellido",
				"precio" => "float"],
			"optionals" => [
				"something",
				"domingo"
			]
 		],

		"edit" => [
			"columns" => [
				"ID_proveedor" => "int",
				"casado" => "float",
				"apellido",
				"precio" => "float"],
			"optionals" => [
				"something",
				"domingo"
			],
			"where" => [
				"columns" => [],
				"optionals" => []
			]
		],

		"get" => [
			"table" => "",
			"select" => "aa",
			"columns" => [

			],
			"join" => [
				"abono_linea" => "s"

			]
		]

	];



}
