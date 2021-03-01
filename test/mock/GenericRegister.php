<?php


namespace GoldenraspberryTest\Permissions\Acl\Mock;


class GenericRegister {

    use Register;

    public function register($data){
        $this->registerData($data);
    }

    public function unregister($data){
        $this->unregisterData($data);
    }

    public function find($dataId){
        return $this->findData($dataId);
    }

}