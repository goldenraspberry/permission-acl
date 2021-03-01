<?php


namespace GoldenraspberryTest\Permissions\Acl\Mock;


use Goldenraspberry\Permissions\Acl\Policy\PolicyInterface;

trait Register {

    protected $data = [];

    private $_nextId = 1;

    protected function registerData($data) {
        if ($data->getId() == 0){
            $thisId = $this->_nextId;
            $this->_nextId ++;
            $data->setId($thisId);
        }
        $this->data[$data->getId()] = $data;
    }

    protected function unregisterData($data) {
        unset($this->data[$data->getId()]);
    }

    protected function findData($id){
        return $this->data[$id] ?: null;
    }

}