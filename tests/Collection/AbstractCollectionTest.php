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

class Data implements EntityInterface
{
    /**
     * @var
     */
    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getId()
    {
        return $this->name;
    }
}
class TestCollection extends AbstractCollection
{
    protected function assertType(EntityInterface $entity)
    {
    }
}

class AbstractCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractCollection
     */
    private $SUT;

    /**
     * @test
     */
    public function testAdd()
    {
        $this->assertThat($this->SUT->count(), $this->equalTo(0));
        $this->SUT->add(new Data('test'));
        $this->assertThat($this->SUT->count(), $this->equalTo(1));
    }

    /**
     * @test
     */
    public function testGetIterator()
    {
        $this->SUT->add(new Data('test1'));
        $this->SUT->add(new Data('test2'));
        $this->SUT->add(new Data('test3'));

        $result = [];
        foreach ($this->SUT as $line)
        {
            $result[] = $line;
        }
        $this->assertThat(count($result), $this->equalTo(3));
        $this->assertThat($result[0]->name, $this->equalTo('test1'));
        $this->assertThat($result[1]->name, $this->equalTo('test2'));
        $this->assertThat($result[2]->name, $this->equalTo('test3'));
    }

    /**
     * @test
     */
    public function testGet()
    {
        $this->SUT->add(new Data('test1'));
        $this->SUT->add($target = new Data('test2'));
        $this->SUT->add(new Data('test3'));

        $result = $this->SUT->get('test2');
        $this->assertThat($result, $this->identicalTo($target));

        $result = $this->SUT->get('test4');
        $this->assertThat($result, $this->equalTo(null));
    }

    /**
     * @test
     */
    public function testRemove()
    {
        $this->SUT->add($target = new Data('test1'));
        $this->SUT->add(new Data('test2'));
        $this->SUT->add(new Data('test3'));

        $this->assertThat(count($this->SUT), $this->equalTo(3));

        $this->SUT->remove($target);
        $this->assertThat(count($this->SUT), $this->equalTo(2));

        $result = $this->SUT->get('test1');
        $this->assertThat($result, $this->equalTo(null));
    }

    /**
     * @test
     */
    public function testMerge()
    {
        $collection1 = new TestCollection();
        $collection1->add(new Data('test1'));

        $collection2 = new TestCollection();
        $collection2->add(new Data('test2'));
        $collection2->add(new Data('test3'));

        $this->assertThat(count($collection1), $this->equalTo(1));
        $this->assertThat(count($collection2), $this->equalTo(2));

        $collection1->merge($collection2);
        $this->assertThat(count($collection1), $this->equalTo(3));
        $this->assertThat(count($collection2), $this->equalTo(2));

        $result = [];
        foreach ($collection1 as $line)
        {
            $result[] = $line;
        }
        $this->assertThat($result[0]->name, $this->equalTo('test1'));
        $this->assertThat($result[1]->name, $this->equalTo('test2'));
        $this->assertThat($result[2]->name, $this->equalTo('test3'));
    }

    /**
     * @test
     */
    public function testMergeNumericIndex()
    {
        $collection1 = new TestCollection();
        $collection1->add(new Data(10));

        $collection2 = new TestCollection();
        $collection2->add(new Data(20));
        $collection2->add(new Data(30));

        $this->assertThat(count($collection1), $this->equalTo(1));
        $this->assertThat(count($collection2), $this->equalTo(2));

        $collection1->merge($collection2);
        $this->assertThat(count($collection1), $this->equalTo(3));
        $this->assertThat(count($collection2), $this->equalTo(2));

        $result = [];
        foreach ($collection1 as $key=>$line)
        {
            $result[$key] = $line;
        }
        $this->assertThat($result[10]->name, $this->equalTo(10));
        $this->assertThat($result[20]->name, $this->equalTo(20));
        $this->assertThat($result[30]->name, $this->equalTo(30));
    }

    protected function setUp()
    {
        $this->SUT = new TestCollection();
    }
}
