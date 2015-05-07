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

use Quartet\ContextualValidation\Rule\Length;
use Quartet\ContextualValidation\Rule\NotBlank;

class ValidatorFunctionalTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider dataForTest
     */
    public function test($entity, $expected)
    {
        $builder = new ValidatorBuilder();
        $builder
            ->setContextSelector(function ($row) {
                return $row['type'];
            })
            ->defaultContext()
                ->target('name')
                    ->rule(new NotBlank())
                    ->rule(new Length(['max'=>10]))
            ->context('normal')
                ->target('email')
                    ->rule(new NotBlank())
                    ->rule(new Length(['max'=>20]))
        ;
        $validator = $builder->getValidator();

        $result = $validator->validate($entity);
        $this->assertThat($result->hasError(), $this->equalTo($expected));
    }

    public function dataForTest()
    {
        return [
            [['type'=>'normal', 'name'=>'test', 'email'=>'test@example.com'], false],
            [['type'=>'normal', 'name'=>'', 'email'=>'test@example.com'], true],
            [['type'=>'normal', 'name'=>'test', 'email'=>''], true],
            [['type'=>'normal', 'name'=>'', 'email'=>''], true],
            [['type'=>'normal', 'name'=>'12345678901', 'email'=>'test@example.com'], true],
            [['type'=>'special', 'name'=>'', 'email'=>''], true],
            [['type'=>'special', 'name'=>'test', 'email'=>''], false],
            [['type'=>'special', 'name'=>'testtesttest', 'email'=>''], true],
        ];
    }
}
