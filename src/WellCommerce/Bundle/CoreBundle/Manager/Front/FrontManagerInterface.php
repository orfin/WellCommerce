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

use WellCommerce\Bundle\CoreBundle\Manager\ManagerInterface;

/**
 * Interface FrontManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface FrontManagerInterface extends ManagerInterface
{
    /**
     * @return \WellCommerce\Bundle\CartBundle\Context\Front\CartContextInterface
     */
    public function getCartContext();

    /**
     * @return \WellCommerce\Bundle\CategoryBundle\Context\Front\CategoryContextInterface
     */
    public function getCategoryContext();

    /**
     * @return \WellCommerce\Bundle\CmsBundle\Context\Front\ContactContextInterface
     */
    public function getContactContext();

    /**
     * @return \WellCommerce\Bundle\CmsBundle\Context\Front\NewsContextInterface
     */
    public function getNewsContext();

    /**
     * @return \WellCommerce\Bundle\CmsBundle\Context\Front\PageContextInterface
     */
    public function getPageContext();

    /**
     * @return \WellCommerce\Bundle\ProductBundle\Context\Front\ProductContextInterface
     */
    public function getProductContext();

    /**
     * @return \WellCommerce\Bundle\ProductBundle\Context\Front\ProductStatusContextInterface
     */
    public function getProductStatusContext();

    /**
     * @return \WellCommerce\Bundle\ProducerBundle\Context\Front\ProducerContextInterface
     */
    public function getProducerContext();

    /**
     * @return \WellCommerce\Bundle\LayoutBundle\Context\Front\ThemeContextInterface
     */
    public function getThemeContext();

    /**
     * @return null|\WellCommerce\Bundle\ClientBundle\Entity\ClientInterface
     */
    public function getClient();
}
