<?php
namespace Quartet\ContextualValidation\Collection;

use PHPMentors\DomainKata\Entity\EntityInterface;

class Data implements EntityInterface
{
    public function getId()
    {
        return "1";
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
        $this->SUT->add(new Data());
        $this->assertThat($this->SUT->count(), $this->equalTo(1));
    }

    protected function setUp()
    {
        $this->SUT = new TestCollection();
    }
}
