<?php
namespace EventListener;


use WellCommerce\Bundle\AdminBundle\Event\AdminMenuEvent;

class AdminSubscriberTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \WellCommerce\Bundle\AdminBundle\MenuBuilder\AdminMenuBuilderInterface
     */
    protected $builder;

    protected function _before()
    {
        $this->builder = $this->getMock('WellCommerce\Bundle\AdminBundle\MenuBuilder\AdminMenuBuilderInterface');
    }

    protected function _after()
    {
    }

    public function testFailure()
    {
        $this->assertInstanceOf('Symfony\Component\EventDispatcher\Event', new AdminMenuEvent($this->builder));
    }

}