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
use Quartet\ContextualValidation\Error\ErrorInfo;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class Validator implements ValidatorInterface
{
    private $id = 0;

    /**
     * @var ContextCollection
     */
    private $contexts;
    /**
     * @var \Callable
     */
    private $contextSelector;
    /**
     * @var PropertyAccessor
     */
    private $accessor;

    public function __construct(ContextCollection $contexts, $contextSelector = null, PropertyAccessor $accessor)
    {
        $this->contexts = $contexts;
        $this->contextSelector = $contextSelector;
        $this->accessor = $accessor;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($data, $no = null)
    {
        $errorInfo = new ErrorInfo();
        if ($no === null) {
            $no = $this->generateId();
        }
        $errorInfo->setId($no);

        $contexts = [];
        $context = $this->selectDefaultContext();
        if ($context) {
            $contexts[] = $context;
        }
        $context = $this->selectContext($data);
        if ($context) {
            $contexts[] = $context;
        }

        if (count($contexts) < 1) {
            return $errorInfo;
        }

        foreach ($contexts as $context) {
            $errorInfo->merge($this->validateUnderContext($context, $data));
        }

        return $errorInfo;
    }

    /**
     * {@inheritdoc}
     */
    public function selectContext($data)
    {
        $contextName = call_user_func($this->contextSelector, $data);

        return $this->contexts->get($contextName);
    }

    /**
     * @return Context
     */
    protected function selectDefaultContext()
    {
        return $this->contexts->get('default');
    }

    /**
     * @param Context $context
     * @param $data
     * @return ErrorInfo
     */
    protected function validateUnderContext(Context $context, $data)
    {
        $errorInfo = new ErrorInfo();
        foreach ($context->getTargets() as $target) {
            $error = $this->validateUnderTarget($target, $data);
            $errorInfo->merge($error);
        }

        return $errorInfo;
    }

    /**
     * @param Target $target
     * @param $data
     * @return ErrorInfo
     */
    protected function validateUnderTarget(Target $target, $data)
    {
        $value = $this->accessor->getValue($data, $target->getAccessor());

        $errorInfo = new ErrorInfo();
        foreach ($target->getRules() as $rule) {
            if (call_user_func($rule, $value, $data) === true) {
                continue;
            }
            $errorInfo->addError($target->getName(),
                $rule->getMessage()
            );
        }

        return $errorInfo;
    }

    /**
     * {@inheritdoc}
     */
    public function setContextSelector($f)
    {
        $this->contextSelector = $f;
    }

    /**
     * @return int
     */
    private function generateId()
    {
        return $this->id++;
    }
}
