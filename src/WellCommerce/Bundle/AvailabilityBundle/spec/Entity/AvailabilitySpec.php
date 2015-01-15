<?php

namespace spec\WellCommerce\Bundle\AvailabilityBundle\Entity;

use PhpSpec\ObjectBehavior;

class AvailabilitySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('WellCommerce\Bundle\AvailabilityBundle\Entity\Availability');
    }

    public function it_has_no_id_by_default()
    {
        $this->getId()->shouldReturn(null);
    }

    public function its_created_at_is_mutable()
    {
        $date = new \DateTime('now');
        $this->setCreatedAt($date);
        $this->getCreatedAt()->shouldReturn($date);
    }

    public function it_has_no_created_at_by_default()
    {
        $this->getCreatedAt()->shouldReturn(null);
    }

    public function it_has_no_updated_at_by_default()
    {
        $this->getUpdatedAt()->shouldReturn(null);
    }
}
