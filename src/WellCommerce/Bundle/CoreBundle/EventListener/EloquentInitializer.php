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

namespace WellCommerce\Bundle\CoreBundle\EventListener;

use Illuminate\Database\Capsule\Manager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class EloquentInitializer
 *
 * @package WellCommerce\Bundle\CoreBundle\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class EloquentInitializer implements EventSubscriberInterface
{
    /**
     * @var Manager Eloquent database manager
     */
    private $manager;

    /**
     * Constructor
     *
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->setManager($manager);
    }

    /**
     * Boots Eloquent
     *
     * @return void
     */
    public function initialize()
    {
        $manager = $this->getManager();
        $manager->bootEloquent();
        $manager->setAsGlobal();
    }

    /**
     * Returns manager instance
     *
     * @return \Illuminate\Database\Capsule\Manager
     */
    protected function getManager()
    {
        return $this->manager;
    }

    /**
     * Sets manager instance
     *
     * @param Manager $manager
     */
    private function setManager(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'initialize',
        ];
    }
}