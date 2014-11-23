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

namespace WellCommerce\Bundle\CoreBundle\Controller\Front\Manager;

/**
 * Interface FrontManagerInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\Controller\Front\Manager
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface FrontManagerInterface
{
    /**
     * Returns redirect helper
     *
     * @return \WellCommerce\Bundle\CoreBundle\Helper\Redirect\RedirectHelperInterface
     */
    public function getRedirectHelper();

    /**
     * Returns redirect helper
     *
     * @return \WellCommerce\Bundle\CoreBundle\Helper\Flash\FlashHelperInterface
     */
    public function getFlashHelper();

    /**
     * Returns image helper
     *
     * @return \WellCommerce\Bundle\CoreBundle\Helper\Image\ImageHelperInterface
     */
    public function getImageHelper();


} 