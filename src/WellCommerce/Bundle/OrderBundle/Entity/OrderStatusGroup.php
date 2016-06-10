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
namespace WellCommerce\Bundle\OrderBundle\Entity;

use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use WellCommerce\Bundle\DoctrineBundle\Entity\IdentifiableEntityTrait;

/**
 * Class OrderStatusGroup
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderStatusGroup implements OrderStatusGroupInterface
{
    use IdentifiableEntityTrait;
    use Timestampable;
    use Blameable;
    use Translatable;
}
