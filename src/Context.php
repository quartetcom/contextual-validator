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

namespace Quartet\ContextualValidation;

use PHPMentors\DomainKata\Entity\EntityInterface;
use Quartet\ContextualValidation\Collection\TargetCollection;

class Context implements EntityInterface
{
    /**
     * @var
     */
    private $name;

    /**
     * @var TargetCollection
     */
    private $targets;

    public function __construct($name)
    {
        $this->name = $name;
        $this->targets = new TargetCollection();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->name;
    }

    /**
     * @param Target $target
     */
    public function addTarget(Target $target)
    {
        $this->targets->add($target);
    }

    /**
     * @return TargetCollection
     */
    public function getTargets()
    {
        return $this->targets;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}
