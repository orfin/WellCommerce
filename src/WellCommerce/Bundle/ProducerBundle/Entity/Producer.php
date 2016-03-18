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

use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use WellCommerce\Bundle\DelivererBundle\Entity\DelivererInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;
use WellCommerce\Bundle\MediaBundle\Entity\MediaAwareTrait;
use WellCommerce\Bundle\ShopBundle\Entity\ShopCollectionAwareTrait;

/**
 * Class Producer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Producer extends AbstractEntity implements ProducerInterface
{
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

    /**
     * {@inheritdoc}
     */
    public function getProducts() : Collection
    {
        return $this->products;
    }

    /**
     * {@inheritdoc}
     */
    public function getDeliverers() : Collection
    {
        return $this->deliverers;
    }

    /**
     * {@inheritdoc}
     */
    public function setDeliverers(Collection $collection)
    {
        $this->deliverers = $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function addDeliverer(DelivererInterface $deliverer)
    {
        $this->deliverers = $deliverer;
    }
}
