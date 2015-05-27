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

namespace Quartet\ContextualValidation\Error;

class ErrorInfoCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testAdd()
    {
        $collection = new ErrorInfoCollection();

        $this->assertThat(count($collection), $this->equalTo(0));

        $error1 = new ErrorInfo();
        $error1->setId(1);
        $error1->addError('test1', 'test1');
        $collection->add($error1);
        $this->assertThat(count($collection), $this->equalTo(1));
        $error2 = new ErrorInfo();
        $error2->setId(2);
        $error2->addError('test2', 'test2');
        $collection->add($error2);
        $this->assertThat(count($collection), $this->equalTo(2));
    }

    /**
     * @test
     */
    public function testAddSameId()
    {
        $collection = new ErrorInfoCollection();

        $this->assertThat(count($collection), $this->equalTo(0));

        $error1 = new ErrorInfo();
        $error1->setId(1);
        $error1->addError('test1', 'test1');
        $collection->add($error1);
        $this->assertThat(count($collection), $this->equalTo(1));
        $error2 = new ErrorInfo();
        $error2->setId(1);
        $error2->addError('test2', 'test2');
        $collection->add($error2);
        $this->assertThat(count($collection), $this->equalTo(1));

        /** @var ErrorInfo $error */
        $error = $collection->get(1);
        $this->assertThat(count($error->getErrors()), $this->equalTo(2));
    }
}
