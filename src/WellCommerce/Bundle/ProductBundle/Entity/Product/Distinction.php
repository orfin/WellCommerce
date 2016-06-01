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

namespace WellCommerce\Bundle\ProductBundle\Entity\Product;

use DateTime;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAwareTrait;
use WellCommerce\Bundle\ProductStatusBundle\Entity\ProductStatusInterface;

/**
 * Class Distinction
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Distinction extends AbstractEntity implements DistinctionInterface
{
    use Timestampable;
    use ProductAwareTrait;

    /**
     * @var null|DateTime
     */
    protected $validFrom = null;

    /**
     * @var null|DateTime
     */
    protected $validTo = null;

    /**
     * @var ProductStatusInterface
     */
    protected $status;

    public function getValidFrom()
    {
        return $this->validFrom;
    }

    public function setValidFrom(DateTime $validFrom = null)
    {
        if (null !== $validFrom) {
            $validFrom = $validFrom->setTime(0, 0, 0);
        }

        $this->validFrom = $validFrom;
    }

    public function getValidTo()
    {
        return $this->validTo;
    }

    public function setValidTo(DateTime $validTo = null)
    {
        if (null !== $validTo) {
            $validTo = $validTo->setTime(23, 59, 59);
        }

        $this->validTo = $validTo;
    }

    public function setStatus(ProductStatusInterface $status)
    {
        $this->status = $status;
    }

    public function getStatus() : ProductStatusInterface
    {
        return $this->status;
    }
}
