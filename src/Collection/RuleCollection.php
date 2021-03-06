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

use PHPMentors\DomainKata\Entity\EntityInterface;
use Quartet\ContextualValidation\RuleInterface;

class RuleCollection extends AbstractCollection
{
    protected function assertType(EntityInterface $entity)
    {
        assert($entity instanceof RuleInterface);
    }
}
