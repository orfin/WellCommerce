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
namespace WellCommerce\Bundle\CoreBundle\Repository;

use Closure;
use Doctrine\Entity;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainer;
use WellCommerce\Bundle\CoreBundle\Event\RepositoryEvent;

/**
 * Class AbstractRepository
 *
 * Provides methods needed in repositories
 *
 * @package WellCommerce\Bundle\CoreBundle\Component\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractRepository extends AbstractContainer implements RepositoryInterface
{
    /**
     * Dispatches the event for repository action
     *
     * @param       $eventName
     * @param array $data
     * @param       $id
     */
    final protected function dispatchEvent($eventName, Entity $entity, array $data = [])
    {
        $event = new RepositoryEvent($entity, $data);
        $this->getDispatcher()->dispatch($eventName, $event);

        return $event->getData();
    }
}