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

namespace WellCommerce\CoreBundle\Manager\Front;

use WellCommerce\CoreBundle\Manager\ManagerInterface;

/**
 * Interface FrontManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface FrontManagerInterface extends ManagerInterface
{
    /**
     * @return \WellCommerce\SalesBundle\Context\Front\CartContextInterface
     */
    public function getCartContext();

    /**
     * @return \WellCommerce\CatalogBundle\Context\Front\CategoryContextInterface
     */
    public function getCategoryContext();

    /**
     * @return \WellCommerce\CmsBundle\Context\Front\ContactContextInterface
     */
    public function getContactContext();

    /**
     * @return \WellCommerce\CmsBundle\Context\Front\NewsContextInterface
     */
    public function getNewsContext();

    /**
     * @return \WellCommerce\CmsBundle\Context\Front\PageContextInterface
     */
    public function getPageContext();

    /**
     * @return \WellCommerce\CatalogBundle\Context\Front\ProductContextInterface
     */
    public function getProductContext();

    /**
     * @return \WellCommerce\CatalogBundle\Context\Front\ProductStatusContextInterface
     */
    public function getProductStatusContext();

    /**
     * @return \WellCommerce\CatalogBundle\Context\Front\ProducerContextInterface
     */
    public function getProducerContext();

    /**
     * @return \WellCommerce\LayoutBundle\Context\Front\ThemeContextInterface
     */
    public function getThemeContext();

    /**
     * @return null|\WellCommerce\ClientBundle\Entity\ClientInterface
     */
    public function getClient();
}
