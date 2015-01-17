<?php

namespace spec\WellCommerce\Bundle\CartBundle\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CartItemSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('WellCommerce\Bundle\CartBundle\Entity\CartItem');
    }
}
