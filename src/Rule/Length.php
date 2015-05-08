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

class Length implements RuleInterface
{
    /**
     * @var
     */
    private $options;
    /**
     * @var
     */
    private $message;

    public function __construct($options, $message = null)
    {
        $this->options = $options;
        $this->message = $message;
    }

    public function __invoke($value, $row)
    {
        if (array_key_exists('max', $this->options)) {
            return mb_strlen($value, 'UTF-8') <= $this->options['max'];
        }
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return '長さが'.$this->options['max'].'を超えています';
    }
}
