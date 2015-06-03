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

class Length extends AbstractRule
{
    /**
     * @var
     */
    private $options;

    public function __construct($options, $message = null)
    {
        $this->options = $options;
        if ($message === null) {
            $message = '長さが'.$this->options['max'].'を超えています';
        }
        $this->message = $message;
    }

    public function __invoke($value, $row)
    {
        if (array_key_exists('max', $this->options)) {
            return mb_strlen($value, 'UTF-8') <= $this->options['max'];
        }
    }
}
