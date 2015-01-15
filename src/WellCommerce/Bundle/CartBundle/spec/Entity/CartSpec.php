<?php

namespace spec\WellCommerce\Bundle\CartBundle\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin \WellCommerce\Bundle\CartBundle\Entity\Cart
 */
class CartSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('WellCommerce\Bundle\CartBundle\Entity\Cart');
    }

    function it_has_no_id_by_default()
    {
        $this->getId()->shouldReturn(null);
    }

    function it_has_empty_product_collection_by_default()
    {
        $this->getProducts()->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
        $this->getProducts()->count()->shouldReturn(0);
    }

    function it_has_no_internal_identifier_by_default()
    {
        $this->getInternalId()->shouldReturn(null);
    }

    function it_allows_to_add_new_product_to_collection($item)
    {
        $this->addItem($item);
    }
}
