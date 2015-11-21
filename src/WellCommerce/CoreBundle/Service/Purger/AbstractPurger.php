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

namespace WellCommerce\CoreBundle\Service\Purger;

use WellCommerce\CoreBundle\DependencyInjection\AbstractContainerAware;

/**
 * Class AbstractPurger
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractPurger extends AbstractContainerAware
{
    abstract public function purge();
}
