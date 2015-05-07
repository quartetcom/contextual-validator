<?php
namespace Quartet\ContextualValidation\Collection;

use PHPMentors\DomainKata\Entity\EntityCollectionInterface;
use PHPMentors\DomainKata\Entity\EntityInterface;

abstract class AbstractCollection implements EntityCollectionInterface
{
    protected $store = [];

    public function add(EntityInterface $entity)
    {
        $this->assertType($entity);
        $this->store[$entity->getId()] = $entity;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->store);
    }

    public function get($key)
    {
        if (!array_key_exists($key, $this->store)) {
            return null;
        }
        return $this->store[$key];
    }

    public function remove(EntityInterface $entity)
    {
        unset($this->store[$entity->getId()]);
    }

    public function count()
    {
        return count($this->store);
    }

    abstract protected function assertType(EntityInterface $entity);
}
