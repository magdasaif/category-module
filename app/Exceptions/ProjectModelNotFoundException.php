<?php
namespace Modules\Category\Exceptions;


use Exception;

class ProjectModelNotFoundException extends Exception{
    protected $model;

    public function __construct($model){
        $this->model = $model;
        parent::__construct($model." not found");
    }

    public function getModel(){
        return $this->model;
    }
}