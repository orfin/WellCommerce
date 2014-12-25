<?php

namespace spec\WellCommerce\Bundle\AvailabilityBundle\Controller\Admin;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use WellCommerce\Bundle\CoreBundle\Manager\Admin\AdminManagerInterface;

class AvailabilityControllerSpec extends ObjectBehavior
{
    function let(AdminManagerInterface $manager)
    {
        $this->beConstructedWith($manager);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('WellCommerce\Bundle\AvailabilityBundle\Controller\Admin\AvailabilityController');
    }
}
