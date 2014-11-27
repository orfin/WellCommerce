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
use WellCommerce\Bundle\CoreBundle\Provider\ProviderAwareInterface;
use WellCommerce\Bundle\CoreBundle\Provider\ProviderInterface;

/**
 * Class AbstractFrontManager
 *
 * @package WellCommerce\Bundle\CoreBundle\Manager\Front
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AbstractFrontManager extends AbstractManager implements FrontManagerInterface, ProviderAwareInterface
{
    /**
     * @var ProviderInterface
     */
    protected $provider;

    /**
     * {@inheritdoc}
     */
    public function setProvider(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * {@inheritdoc}
     */
    public function getProvider()
    {
        return $this->provider;
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