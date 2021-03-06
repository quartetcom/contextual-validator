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

class TargetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testDefaultAccessor()
    {
        $target = new Target('name', new Context('test'));

        $this->assertThat($target->getAccessor(), $this->equalTo('name'));
    }
}
