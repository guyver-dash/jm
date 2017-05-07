<?php namespace App\Repo\User;

use App\Repo\BaseRepository;
use App\Repo\BaseInterface;
use App\User;

class AdminRepository extends BaseRepository implements UserInterface{

	public function __construct(){

		$this->modelName = new User();
	}

	
}