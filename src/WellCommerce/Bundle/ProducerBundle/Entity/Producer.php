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

namespace WellCommerce\Bundle\ProducerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use WellCommerce\Bundle\CoreBundle\Entity\IdentifiableTrait;
use WellCommerce\Bundle\DelivererBundle\Entity\DelivererInterface;
use WellCommerce\Bundle\MediaBundle\Entity\MediaAwareTrait;
use WellCommerce\Bundle\ShopBundle\Entity\ShopCollectionAwareTrait;

/**
 * Class Producer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Producer implements ProducerInterface
{
    use IdentifiableTrait;
    use Translatable;
    use Timestampable;
    use Blameable;
    use MediaAwareTrait;
    use ShopCollectionAwareTrait;
    
    /**
     * @var Collection
     */
    protected $products;
    
    /**
     * @var Collection
     */
    protected $deliverers;
    
    public function __construct()
    {
        $this->products   = new ArrayCollection();
        $this->deliverers = new ArrayCollection();
    }
    
    public function getProducts(): Collection
    {
        return $this->products;
    }
    
    public function getDeliverers(): Collection
    {
        return $this->deliverers;
    }
    
    public function setDeliverers(Collection $collection)
    {
        $this->deliverers = $collection;
    }
    
    public function addDeliverer(DelivererInterface $deliverer)
    {
        $this->deliverers = $deliverer;
    }
}
