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

namespace WellCommerce\Bundle\ContactBundle\Entity;

use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use WellCommerce\Bundle\DoctrineBundle\Behaviours\Enableable\EnableableTrait;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;

/**
 * Class Contact
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Contact extends AbstractEntity implements ContactInterface
{
    use Translatable;
    use Timestampable;
    use Blameable;
    use EnableableTrait;
}
