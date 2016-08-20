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

use DateTime;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\CoreBundle\Entity\IdentifiableTrait;
use WellCommerce\Bundle\ProductStatusBundle\Entity\ProductStatusInterface;

/**
 * Class ProductDistinction
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductDistinction implements ProductDistinctionInterface
{
    use IdentifiableTrait;
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
