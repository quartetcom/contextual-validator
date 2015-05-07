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

use Quartet\ContextualValidation\Collection\ContextCollection;

class ValidatorBuilder
{
    /**
     * @var ContextCollection
     */
    private $contexts;

    /**
     * @var \Callable
     */
    private $contextSelector = null;

    /**
     * @var Context
     */
    private $currentContext;

    /**
     * @var Target
     */
    private $currentTarget;

    public function __construct()
    {
        $this->contexts = new ContextCollection();
    }

    /**
     * @param string $name
     * @return ValidatorBuilder
     */
    public function context($name)
    {
        $this->currentContext = $context = new Context($name);
        $this->contexts->add($context);
        return $this;
    }

    /**
     * @param $f
     * @return ValidatorBuilder
     */
    public function setContextSelector($f)
    {
        $this->contextSelector = $f;
        return $this;
    }

    /**
     * @param string $name
     * @return ValidatorBuilder
     */
    public function target($name)
    {
        $this->currentTarget = $target = new Target($name, $this->currentContext);
        $this->currentContext->addTarget($target);
        return $this;
    }

    /**
     * @param RuleInterface $rule
     * @return ValidatorBuilder
     */
    public function rule(RuleInterface $rule)
    {
        $this->currentTarget->addRule($rule);
        return $this;
    }

    /**
     * @return Validator
     */
    public function getValidator()
    {
        return new Validator($this->contexts, $this->contextSelector);
    }
}
