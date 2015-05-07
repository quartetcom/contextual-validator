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

class Target implements EntityInterface
{
    /**
     * @var
     */
    private $name;

    /**
     * @var \Callable[]
     */
    private $rules = [];

    public function __construct($name, Context $context)
    {
        $this->name = $name;

        $context->addTarget($this);
    }

    public function getId()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $rule
     */
    public function addRule(RuleInterface $rule)
    {
        $this->rules[] = $rule;
    }

    /**
     * @return \Callable[]
     */
    public function getRules()
    {
        return $this->rules;
    }
}
