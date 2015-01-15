<?php

namespace WellCommerce\Bundle\CartBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Cart
{
    private $id;

    private $products;

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
        // TODO: write logic here
    }

    public function setProducts(ArrayCollection $products)
    {
        $this->products = $products;
    }
}
