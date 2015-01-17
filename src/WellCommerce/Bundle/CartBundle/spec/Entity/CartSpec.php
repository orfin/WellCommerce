<?php

namespace spec\WellCommerce\Bundle\CartBundle\Entity;

use PhpSpec\ObjectBehavior;

/**
 * Class CartSpec
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 * @mixin \WellCommerce\Bundle\CartBundle\Entity\Cart
 */
class CartSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('WellCommerce\Bundle\CartBundle\Entity\Cart');
    }

    public function it_has_no_id_by_default()
    {
        $this->getId()->shouldReturn(null);
    }

    public function it_has_empty_product_collection_by_default()
    {
        $this->getProducts()->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
        $this->getProducts()->count()->shouldReturn(0);
    }

    public function it_has_no_internal_identifier_by_default()
    {
        $this->getInternalId()->shouldReturn(null);
    }

    public function it_allows_to_add_new_product_to_collection($item)
    {
        $this->addItem($item);
    }
}
