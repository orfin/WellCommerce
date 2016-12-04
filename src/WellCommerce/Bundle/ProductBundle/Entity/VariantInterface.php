<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 * 
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 * 
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\ProductBundle\Entity;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\AppBundle\Entity\DiscountablePrice;
use WellCommerce\Bundle\AppBundle\Entity\HierarchyAwareInterface;
use WellCommerce\Bundle\AvailabilityBundle\Entity\AvailabilityAwareInterface;
use WellCommerce\Bundle\CoreBundle\Behaviours\Enableable\EnableableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\MediaBundle\Entity\MediaAwareInterface;

/**
 * Interface VariantInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface VariantInterface extends
    EntityInterface,
    TimestampableInterface,
    AvailabilityAwareInterface,
    ProductAwareInterface,
    HierarchyAwareInterface,
    MediaAwareInterface,
    EnableableInterface
{
    public function getWeight() : float;
    
    public function setWeight(float $weight);

    public function getSymbol() : string;

    public function setSymbol(string $symbol);
    
    public function getStock() : int;

    public function setStock(int $stock);

    public function getSellPrice() : DiscountablePrice;

    public function setSellPrice(DiscountablePrice $sellPrice);

    public function getModifierValue() : float;

    public function setModifierValue(float $modifierValue);

    public function getModifierType() : string;

    public function setModifierType(string $modifierType);

    public function getOptions() : Collection;

    public function setOptions(Collection $options);
}
