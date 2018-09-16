
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CI_Apilib {

	private $error = false;
	private $data = [];
	private $status = true;


	public function data($data, $name=false){
		if($name==false){
			$this->data = $data;
		}else{
			$this->data[$name] = $data;
		}

		return true;
	}

	public function error($msg, $code=0){
		$this->error['text'] = $msg;
//		$this->data['status'] = false;
		return true;
	}

	public function generate($view=false){

		if($this->error == false){
			$this->status = true;
		}else{
			$this->status = false;
		}

		$re['data'] = $this->data;
		$re['status'] = $this->status;

		if($this->error != false){
			$re['error'] = $this->error;
		}

		$re = json_encode($re);

		// Restablece valores
		$this->error = false;
		$this->data = [];

		// Return
		if($view){
			echo $re;
		}else{
			return $re;
		}

	}

}