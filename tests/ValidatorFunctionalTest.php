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

use Quartet\ContextualValidation\Collection\TargetCollection;
use Quartet\ContextualValidation\Rule\F;
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
        $validator = $this->createValidator();
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

    /**
     * @return Validator
     */
    private function createValidator()
    {
        $builder = $this->prepareBuilder();
        $validator = $builder->getValidator();

        return $validator;
    }

    /**
     * @return ValidatorBuilder
     */
    private function prepareBuilder()
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
                    ->rule(new F(function($value, $row) {
                        return strpos($value, '@') !== false;
                    }, '@がありません'));
        ;

        return $builder;
    }

    /**
     * @test
     */
    public function testErrorMessage()
    {
        $validator = $this->createValidator();
        $data = ['type'=>'normal', 'name'=>'', 'email'=>'testtesttestexample.com'];

        $error = $validator->validate($data);

        $errors = $error->getErrors();

        $this->assertThat(count($errors['name']), $this->equalTo(1));
        $this->assertThat($errors['name'][0], $this->equalTo('必須です'));
        $this->assertThat(count($errors['email']), $this->equalTo(2));
        $this->assertThat($errors['email'][0], $this->equalTo('長さが20を超えています'));
        $this->assertThat($errors['email'][1], $this->equalTo('@がありません'));

    }

    /**
     * @test
     */
    public function testBuilder()
    {
        $contexts = $this->prepareBuilder()->getStructure();
        $this->assertThat(count($contexts), $this->equalTo(2));

        /** @var TargetCollection $targets */
        $targets = $contexts->get('default')->getTargets();
        $this->assertThat(count($targets), $this->equalTo(1));
        $target = $targets->get('name');
        $rules = $target->getRules();
        $this->assertThat(count($rules), $this->equalTo(2));
        $this->assertThat($rules[0], $this->isInstanceOf(NotBlank::class));
        $this->assertThat($rules[1], $this->isInstanceOf(Length::class));

        $targets = $contexts->get('normal')->getTargets();
        $this->assertThat(count($targets), $this->equalTo(1));
        $target = $targets->get('email');
        $rules = $target->getRules();
        $this->assertThat(count($rules), $this->equalTo(3));
        $this->assertThat($rules[0], $this->isInstanceOf(NotBlank::class));
        $this->assertThat($rules[1], $this->isInstanceOf(Length::class));
        $this->assertThat($rules[2], $this->isInstanceOf(F::class));
    }
}
