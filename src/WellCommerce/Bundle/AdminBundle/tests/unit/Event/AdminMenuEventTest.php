<?php
namespace Event;

use WellCommerce\Bundle\AdminBundle\Event\AdminMenuEvent;

class AdminMenuEventTest extends \Codeception\TestCase\Test
{
    /**
     * @var \WellCommerce\Bundle\AdminBundle\MenuBuilder\AdminMenuBuilderInterface
     */
    protected $builder;

    /**
     * @var AdminMenuEvent
     */
    protected $event;

    protected function _before()
    {
        $this->builder = $this->getMock('WellCommerce\Bundle\AdminBundle\MenuBuilder\AdminMenuBuilderInterface');
        $this->event   = new AdminMenuEvent($this->builder);
    }

    public function testType()
    {
        $this->assertInstanceOf(
            'WellCommerce\Bundle\AdminBundle\Event\AdminMenuEvent',
            $this->event
        );
    }

    public function testGetBuilder()
    {
        $this->assertInstanceOf(
            'WellCommerce\Bundle\AdminBundle\MenuBuilder\AdminMenuBuilderInterface',
            $this->event->getBuilder()
        );
    }

}