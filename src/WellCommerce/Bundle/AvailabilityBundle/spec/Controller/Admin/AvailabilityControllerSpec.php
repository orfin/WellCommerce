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

namespace spec\WellCommerce\Bundle\AvailabilityBundle\Controller\Admin;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use WellCommerce\Bundle\CoreBundle\Manager\Admin\AdminManagerInterface;

/**
 * Class AvailabilityControllerSpec
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityControllerSpec extends ObjectBehavior
{
    function let(AdminManagerInterface $manager)
    {
        $this->beConstructedWith($manager, true);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('WellCommerce\Bundle\AvailabilityBundle\Controller\Admin\AvailabilityController');
    }
}
