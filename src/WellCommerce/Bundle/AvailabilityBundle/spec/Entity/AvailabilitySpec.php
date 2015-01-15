<?php

namespace spec\WellCommerce\Bundle\AvailabilityBundle\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AvailabilitySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('WellCommerce\Bundle\AvailabilityBundle\Entity\Availability');
    }

    function it_has_no_id_by_default()
    {
        $this->getId()->shouldReturn(null);
    }

    function its_created_at_is_mutable()
    {
        $date = new \DateTime('now');
        $this->setCreatedAt($date);
        $this->getCreatedAt()->shouldReturn($date);
    }


    function it_has_no_created_at_by_default()
    {
        $this->getCreatedAt()->shouldReturn(null);
    }

    function it_has_no_updated_at_by_default()
    {
        $this->getUpdatedAt()->shouldReturn(null);
    }
}
