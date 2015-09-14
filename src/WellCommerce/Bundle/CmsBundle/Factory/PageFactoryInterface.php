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

namespace WellCommerce\Bundle\CmsBundle\Factory;

use WellCommerce\Bundle\CoreBundle\Factory\FactoryInterface;

interface PageFactoryInterface extends FactoryInterface
{
    /**
     * @return \WellCommerce\Bundle\CmsBundle\Entity\PageInterface
     */
    public function create();
}
