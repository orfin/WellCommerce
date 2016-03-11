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

namespace WellCommerce\Bundle\CurrencyBundle\Entity;

use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\DoctrineBundle\Behaviours\Enableable\EnableableTrait;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;

/**
 * Class Currency
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Currency extends AbstractEntity implements CurrencyInterface
{
    use Timestampable;
    use Blameable;
    use EnableableTrait;

    /**
     * @var string
     */
    protected $code;

    /**
     * {@inheritdoc}
     */
    public function setCode(string $code)
    {
        $this->code = $code;
    }

    /**
     * {@inheritdoc}
     */
    public function getCode() : string
    {
        return $this->code;
    }
}
