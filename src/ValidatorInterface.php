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
use Quartet\ContextualValidation\Error\ErrorInfo;

interface ValidatorInterface extends EntityInterface
{
    /**
     * @param $data
     * @param int $no
     * @return ErrorInfo
     * @api
     */
    public function validate($data, $no = null);

    /**
     * @param $data
     * @return Context
     * @api
     */
    public function selectContext($data);

    /**
     * @param \Callable $f
     * @api
     */
    public function setContextSelector($f);
}
