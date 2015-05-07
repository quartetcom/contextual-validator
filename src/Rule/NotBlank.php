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

namespace Quartet\ContextualValidation\Rule;

use Quartet\ContextualValidation\RuleInterface;

class NotBlank implements RuleInterface
{
    /**
     * @var null
     */
    private $message;

    public function __construct($message = null)
    {
        $this->message = $message;
    }

    public function __invoke($value, $row)
    {
        return !empty($value);
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return '必須です';
    }
}
