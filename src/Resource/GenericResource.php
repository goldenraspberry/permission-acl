<?php


namespace Goldenraspberry\Permissions\Acl\Resource;


class GenericResource implements ResourceInterface {

    /**
     * unique id of resource
     * @var string
     */
    protected $id;

    public function __construct($id) {
        $this->id = (string)$id;
    }

    public function getId() {
        return $this->id;
    }

    public function __toString() {
        return $this->getId();
    }

}