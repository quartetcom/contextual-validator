<?php
/*
 * Copyright (c) 2015 GOTO Hidenori <hidenorigoto@gmail.com>,
 * All rights reserved.
 *
 * This file is part of Quartet/Contextual Validation.
 *
 * This program and the accompanying materials are made available under
 * the terms of the BSD 2-Clause License which accompanies this
 * distribution, and is available at http://opensource.org/licenses/BSD-2-Clause
 */

namespace Quartet\ContextualValidation\Collection;

use PHPMentors\DomainKata\Entity\EntityCollectionInterface;
use PHPMentors\DomainKata\Entity\EntityInterface;

abstract class AbstractCollection implements EntityCollectionInterface
{
    protected $store = [];

    /**
     * @param EntityInterface $entity
     */
    public function add(EntityInterface $entity)
    {
        $this->assertType($entity);
        $this->store[$entity->getId()] = $entity;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->store);
    }

    /**
     * @param $key
     * @return null
     */
    public function get($key)
    {
        if (!array_key_exists($key, $this->store)) {
            return null;
        }
        return $this->store[$key];
    }

    /**
     * @param EntityInterface $entity
     */
    public function remove(EntityInterface $entity)
    {
        unset($this->store[$entity->getId()]);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->store);
    }

    /**
     * @param AbstractCollection $target
     */
    public function merge(AbstractCollection $target)
    {
        $this->store = $this->store + $target->store;
    }

    /**
     * @param EntityInterface $entity
     */
    abstract protected function assertType(EntityInterface $entity);
}
