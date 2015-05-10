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

use Quartet\ContextualValidation\Error\ErrorInfo;
use Quartet\ContextualValidation\Error\ErrorInfoCollection;

class ValidationRunnerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ValidationRunner
     */
    private $SUT;

    /**
     * @var Validator
     */
    private $validator1;

    /**
     * @test
     */
    public function testRun()
    {
        $data = [
            ['name' => 'test', 'email' => 'test@example.com'],
            ['name' => 'test2', 'email' => 'test2@sample.co.jp'],
        ];

        $errorInfo = new ErrorInfo();
        $this->validator1->expects($this->exactly(count($data)))
            ->method('validate')
            ->willReturn($errorInfo);

        $result = $this->SUT->run($data);

        $this->assertThat($result, $this->isInstanceOf(ErrorInfoCollection::class));
    }

    protected function setUp()
    {
        $this->validator1 = $this->getMockBuilder(Validator::class)->disableOriginalConstructor()->getMock();
        $this->SUT = new ValidationRunner();
        $this->SUT->addRowValidator($this->validator1);
    }
}
