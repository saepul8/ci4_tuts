<?php namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{


	public function __construct(){

		parent:: __construct();

		$db = \Config\Database::connect();

		$this->builder = $db->table('users');

	}


	function get_user_data($username){
		$this->builder->select('userName, userPassword');
		$this->builder->where('userName',$username);
		return $this->builder->get();
	}

	//--------------------------------------------------------------------

}
