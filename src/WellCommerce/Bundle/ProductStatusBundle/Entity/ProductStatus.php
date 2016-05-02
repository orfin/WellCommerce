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

namespace WellCommerce\Bundle\ProductStatusBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;

/**
 * Class ProductStatus
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatus extends AbstractEntity implements ProductStatusInterface
{
    use Translatable;
    use Timestampable;
    use Blameable;

    /**
     * @var Collection
     */
    protected $products;

    public function getProducts() : Collection
    {
        return $this->products;
    }

    public function setProducts(Collection $collection)
    {
        $this->products = $collection;
    }
}
