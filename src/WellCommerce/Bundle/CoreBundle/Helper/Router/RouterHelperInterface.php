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

namespace WellCommerce\Bundle\CoreBundle\Helper\Router;

/**
 * Interface RouterHelperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface RouterHelperInterface
{
    /**
     * @param object $controller
     * @param string $action
     *
     * @return bool
     */
    public function hasControllerAction($controller, $action);

    /**
     * @return string
     */
    public function getCurrentAction();

    /**
     * Returns the current request context
     *
     * @return \Symfony\Component\Routing\RequestContext
     */
    public function getRouterRequestContext();
}
