<?php

namespace spec\WellCommerce\Bundle\AvailabilityBundle\Controller\Admin;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Manager\Admin\AdminManagerInterface;

class AvailabilityControllerSpec extends ObjectBehavior
{
    function let(AdminManagerInterface $manager)
    {
        $this->beConstructedWith($manager);
        $this->shouldImplement('WellCommerce\Bundle\CoreBundle\Controller\Admin\AdminControllerInterface');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('WellCommerce\Bundle\AvailabilityBundle\Controller\Admin\AvailabilityController');
    }

    function it_should_respond_to_index_action(Request $request)
    {
        $response = $this->indexAction($request)->shouldHaveType('Symfony\Component\HttpFoundation\Response');
    }
}
