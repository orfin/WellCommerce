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

namespace WellCommerce\Bundle\LayoutBundle\Resolver;

use WellCommerce\Bundle\LayoutBundle\Entity\LayoutBox;

/**
 * Interface ServiceResolverInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ServiceResolverInterface
{
    /**
     * Resolves controller service
     *
     * @param LayoutBox $layoutBox
     *
     * @return \WellCommerce\Bundle\CoreBundle\Controller\Box\BoxControllerInterface
     */
    public function resolveControllerService(LayoutBox $layoutBox);
}
