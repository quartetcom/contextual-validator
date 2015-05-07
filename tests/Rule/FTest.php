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

class FTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var F
     */
    private $SUT;

    /**
     * @test
     * @dataProvider dataForTestValidate
     */
    public function testValidate($value, $expected)
    {
        $result = call_user_func($this->SUT, $value, null);
        $this->assertThat($result, $this->equalTo($expected));
    }

    public function dataForTestValidate()
    {
        return [
            'normal data' => [4, true],
            'invalid data' => [2, false],
            'null' => [null, false],
        ];
    }

    protected function setUp()
    {
        $this->SUT = new F(function($data, $row) {
            return $data % 3 === 1;
        }, 'error');
    }
}
