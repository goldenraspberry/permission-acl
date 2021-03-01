<?php


namespace Goldenraspberry\Permissions\Acl\Policy;


use Goldenraspberry\Permissions\Acl\Resource\ResourceInterface;

interface PolicyInterface {

    const DENY = 1;
    const ALLOW = 2;

    /**
     * @param int $id
     * @return self
     */
    public function setId($id);

    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $priority
     * @return self
     */
    public function setPriority($priority);

    /**
     * @return int
     */
    public function getPriority();

    /**
     * @param ResourceInterface $resource
     * @return self
     */
    public function setResource(ResourceInterface $resource);

    /**
     * @return ResourceInterface
     */
    public function getResource();

    /**
     * @param int $rule
     * @return self
     */
    public function setRule($rule);

    /**
     * @return int
     */
    public function getRule();

}