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
namespace WellCommerce\Bundle\UnitBundle\EventListener;

use Symfony\Component\Config\FileLocator;
use WellCommerce\Bundle\AdminBundle\Event\AdminMenuEvent;
use WellCommerce\Bundle\AdminBundle\MenuBuilder\XmlLoader;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;

/**
 * Class UnitSubscriber
 *
 * @package WellCommerce\Bundle\UnitBundle\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UnitSubscriber extends AbstractEventSubscriber
{

}