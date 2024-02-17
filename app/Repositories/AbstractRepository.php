<?php
namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;
abstract class AbstractRepository{
	public Model $model;
	public function __construct(){}
	public function getAll(){
        return $this->model->all();
	}
    public function findById(string $id){
        return $this->model->find($id)?->first();
	}

}
