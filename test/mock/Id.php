<?php


namespace GoldenraspberryTest\Permissions\Acl\Mock;


trait Id {

    protected $id = 0;

    public function setId($id){
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

}