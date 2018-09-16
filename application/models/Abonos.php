<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Abonos extends KA_Model {

	public $data = [
		"table" => "abono",

		/* Por ahora lo ponemos aunque no se use, así en versiones posteriores se puede usar */
		"primary" => "ID",

		"add" => [
			"columns" => [
				"fecha",
				"ID_cliente" => "int",
				"estado",
				"ID_moneda" => "int",
				"ID_forma_de_pago" => "int",
				"vencimiento",
				"texto_libre",
				"fecha_original_rectificada",
				"ID_factura" => "int"
			],
			"optionals" => [
				"ID_campana" => "int",
				"domingo"
			]
 		],

		"edit" => [
			"columns" => [
				"fecha",
				"ID_cliente" => "int",
				"estado",
				"ID_moneda" => "int",
				"ID_forma_de_pago" => "int",
				"vencimiento",
				"texto_libre",
				"fecha_original_rectificada",
				"ID_factura" => "int"
			],
			"optionals" => [
				"ID_campana" => "int",
				"domingo"
			],
			"where" => [
				/* Lo hacemos con columns para que una nueva versión sea más potente */
				"columns" => [
					'ID' => "int"
				]
			],
			/*"permission" => [
				"table" => "usuario",
				"column" => "ID"
			]*/
		],

		"delete" => [
			"where" => [
				"columns" => [
					'ID' => "int"
				]
			],


		],

		"get" => [
			"table" => "abono_view",
			"select" => "
				abono_view.*,
				cliente.nombre as string_cliente,
				moneda.name as string_moneda,
				forma_de_pago.nombre as string_forma_de_pago,
				campana.nombre as string_campana",
			"table" => "abono_view",
			"join" => [
				"cliente" => [
					"on" => "abono_view.ID_cliente = cliente.ID",
					"type" => "left", /* optional */
					 /* "alias" => "abono1" optional: Por si existen varias relaciones a la misma tabla */
				],
				"moneda" => [
					"on" => "abono_view.ID_moneda = moneda.ID",
					"type" => "left", /* optional */
					 /* "alias" => "abono1" optional: Por si existen varias relaciones a la misma tabla */
				],
				"forma_de_pago" => [
					"on" => "abono_view.ID_forma_de_pago = forma_de_pago.ID",
					"type" => "left", /* optional */
					 /* "alias" => "abono1" optional: Por si existen varias relaciones a la misma tabla */
				],
				"campana" => [
					"on" => "abono_view.ID_campana = campana.ID",
					"type" => "left", /* optional */
					 /* "alias" => "abono1" optional: Por si existen varias relaciones a la misma tabla */
				],
				
			],
			/* Totamente opcional */
			"where" => [
				/* Lo hacemos con columns para que una nueva versión sea más potente */
				"columns" => [
					'abono_view.ID' => "int"
				]

				/* Optionals */

			]

		],


		"get_list" => [
			"table" => "abono_view",
			"select" => "
				abono_view.*,
				cliente.nombre as string_cliente,
				moneda.name as string_moneda,
				forma_de_pago.nombre as string_forma_de_pago,
				campana.nombre as string_campana",
			"table" => "abono_view",
			"join" => [
				"cliente" => [
					"on" => "abono_view.ID_cliente = cliente.ID",
					"type" => "left", /* optional */
					 /* "alias" => "abono1" optional: Por si existen varias relaciones a la misma tabla */
				],
				"moneda" => [
					"on" => "abono_view.ID_moneda = moneda.ID",
					"type" => "left", /* optional */
					 /* "alias" => "abono1" optional: Por si existen varias relaciones a la misma tabla */
				],
				"forma_de_pago" => [
					"on" => "abono_view.ID_forma_de_pago = forma_de_pago.ID",
					"type" => "left", /* optional */
					 /* "alias" => "abono1" optional: Por si existen varias relaciones a la misma tabla */
				],
				"campana" => [
					"on" => "abono_view.ID_campana = campana.ID",
					"type" => "left", /* optional */
					 /* "alias" => "abono1" optional: Por si existen varias relaciones a la misma tabla */
				],
				
			],
			/* Totamente opcional */
			"where" => [
				/* Lo hacemos con columns para que una nueva versión sea más potente */
				"columns" => [
					'abono_view.ID_cliente' => "int"
				],
				"optionals" => [
					'abono_view.fecha'
				]

				/* Optionals */

			]

		],



	];



}
