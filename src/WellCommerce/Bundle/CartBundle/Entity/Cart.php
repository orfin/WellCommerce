<?php

namespace WellCommerce\Bundle\CartBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Cart
{
    private $id;

    private $products;

    private $internalId;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }

    public function getInternalId()
    {
        return $this->internalId;
    }

    public function setProducts(ArrayCollection $products)
    {
        $this->products = $products;
    }

    public function addItem(CartItem $cartItem)
    {
        $this->products->add($cartItem);
    }
}
