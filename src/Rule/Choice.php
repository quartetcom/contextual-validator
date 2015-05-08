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

class Choice implements RuleInterface
{
    /**
     * @var null
     */
    private $message;
    /**
     * @var array
     */
    private $choice;

    public function __construct($choice, $message = null)
    {
        $this->choice = $choice;
        if ($message === null) {
            $message = implode(',', $choice).'のみです';
        }
        $this->message = $message;
    }

    public function __invoke($value, $row)
    {
        return in_array($value, $this->choice, true);
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
