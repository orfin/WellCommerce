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

namespace WellCommerce\Bundle\DoctrineBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use WellCommerce\Bundle\DoctrineBundle\Entity\IdentifiableEntityInterface;

/**
 * Class EntityEvent
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class EntityEvent extends Event
{
    private $entity;

    /**
     * EntityEvent constructor.
     *
     * @param IdentifiableEntityInterface $entity
     */
    public function __construct(IdentifiableEntityInterface $entity)
    {
        $this->entity = $entity;
    }

    public function getEntity() : IdentifiableEntityInterface
    {
        return $this->entity;
    }
}
