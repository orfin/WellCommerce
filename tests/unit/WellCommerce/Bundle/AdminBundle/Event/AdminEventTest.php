<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\AdminBundle\Event;

/**
 * Class AdminEventTest
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class AdminEventTest extends \Codeception\TestCase\Test
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

    public function testTypeIsCorrect()
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
