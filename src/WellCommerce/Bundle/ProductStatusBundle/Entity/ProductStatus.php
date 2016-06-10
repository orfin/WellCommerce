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

use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use WellCommerce\Bundle\DoctrineBundle\Entity\IdentifiableTrait;

/**
 * Class ProductStatus
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatus implements ProductStatusInterface
{
    use IdentifiableTrait;
    use Translatable;
    use Timestampable;
    use Blameable;

    protected $symbol;

    public function getSymbol() : string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol)
    {
        $this->symbol = $symbol;
    }
}
