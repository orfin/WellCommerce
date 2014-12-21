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

namespace WellCommerce\Bundle\CoreBundle\Manager\Front;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use WellCommerce\Bundle\CoreBundle\Event\ResourceEvent;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;
use WellCommerce\Bundle\CoreBundle\Manager\AbstractManager;
use WellCommerce\Bundle\CoreBundle\Provider\ProviderCollection;

/**
 * Class AbstractFrontManager
 *
 * @package WellCommerce\Bundle\CoreBundle\Manager\Front
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AbstractFrontManager extends AbstractManager implements FrontManagerInterface
{
    /**
     * @var ProviderCollection
     */
    protected $providers;

    /**
     * {@inheritdoc}
     */
    public function setProviders(ProviderCollection $collection)
    {
        $this->providers = $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * {@inheritdoc}
     */
    public function getProvider($type)
    {
        return $this->providers->get($type);
    }

    /**
     * Triggers event
     *
     * @param $resource
     * @param $request
     * @param $name
     */
    protected function dispatchEvent($resource, $request, $name)
    {
        $reflection = new \ReflectionClass($resource);
        $eventName  = $this->getEventName($reflection->getShortName(), $name);
        $event      = new ResourceEvent($resource, $request);
        $this->eventDispatcher->dispatch($eventName, $event);
    }

    /**
     * Returns event name for resource
     *
     * @param $class
     * @param $name
     *
     * @return string
     */
    protected function getEventName($class, $name)
    {
        return sprintf('%s.%s', Helper::snake($class), $name);
    }
}