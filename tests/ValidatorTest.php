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
use Quartet\ContextualValidation\Rule\NotBlank;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Validator
     */
    private $SUT;
    /**
     * @var ContextCollection
     */
    private $contextCollection;

    /**
     * @test
     */
    public function testValidate()
    {
        $this->SUT->setContextSelector(function () { return 'testContext'; });
        $errorInfo = $this->SUT->validate(['name'=>'test']);

        $this->assertThat($errorInfo->hasError(), $this->equalTo(false));
    }

    protected function setUp()
    {
        $this->contextCollection = new ContextCollection();
        $this->SUT = new Validator($this->contextCollection, null);

        $this->contextCollection->add($context = new Context('testContext'));
        $target = new Target('name', $context);
        $target->addRule(new NotBlank());
    }
}
