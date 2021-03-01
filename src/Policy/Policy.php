<?php


namespace Goldenraspberry\Permissions\Acl\Policy;


use Goldenraspberry\Permissions\Acl\Resource\ResourceInterface;

trait Policy {

    protected $id = 0;
    protected $priority = 0;
    protected $resource = null;
    protected $rule = 0;

    public function setId($id){
        $this->id = $id;
        return $this;
    }

    public function getId(){
        return $this->id;
    }

    public function setPriority($priority){
        $this->priority = $priority;
        return $this;
    }
    public function getPriority(){
        return $this->priority;
    }
    public function setResource(ResourceInterface $resource){
        $this->resource = $resource;
        return $this;
    }

    public function getResource(){
        return $this->resource;
    }

    public function setRule($rule){
        $this->rule = $rule;
        return $this;
    }

    public function getRule(){
        return $this->rule;
    }

}