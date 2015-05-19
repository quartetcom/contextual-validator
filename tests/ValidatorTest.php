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
use Quartet\ContextualValidation\Rule\NotBlank;
use Symfony\Component\PropertyAccess\PropertyAccess;

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

    /**
     * @test
     */
    public function testErrorInfo_normal()
    {
        $this->SUT->setContextSelector(function () { return 'testContext'; });
        $result = $this->SUT->validate(['name'=>'test'], 3);
        $this->assertThat($result, $this->isInstanceOf(ErrorInfo::class));
        $this->assertThat($result->getId(), $this->equalTo(3));
    }

    /**
     * @test
     */
    public function testErrorInfo_no_id()
    {
        $this->SUT->setContextSelector(function () { return 'testContext'; });
        $result = $this->SUT->validate(['name'=>'test']);

        $this->assertThat($result, $this->isInstanceOf(ErrorInfo::class));
        $this->assertThat($result->getId(), $this->logicalNot($this->identicalTo(null)));
    }

    protected function setUp()
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        $this->contextCollection = new ContextCollection();
        $this->SUT = new Validator($this->contextCollection, null, $accessor);

        $this->contextCollection->add($context = new Context('testContext'));
        $target = new Target('name', $context, '[name]');
        $target->addRule(new NotBlank());

    }
}
