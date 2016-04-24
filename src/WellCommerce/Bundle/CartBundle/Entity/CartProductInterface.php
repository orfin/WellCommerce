<?php

namespace WellCommerce\Bundle\CartBundle\Entity;

use WellCommerce\Bundle\AppBundle\Entity\DiscountablePrice;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAwareInterface;
use WellCommerce\Bundle\ProductBundle\Entity\VariantAwareInterface;

/**
 * Interface CartProductInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartProductInterface extends
    EntityInterface,
    VariantAwareInterface,
    TimestampableInterface,
    ProductAwareInterface,
    CartAwareInterface
{
    public function getQuantity() : int;

    public function setQuantity(int $quantity);

    public function increaseQuantity(int $increase);

    public function decreaseQuantity(int $decrease);

    public function getSellPrice() : DiscountablePrice;

    public function getWeight() : float;

    public function getOptions() : array;

    public function setOptions(array $options);
}
