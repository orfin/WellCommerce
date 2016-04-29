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

use WellCommerce\Bundle\CartBundle\Context\Front\CartContextInterface;
use WellCommerce\Bundle\CategoryBundle\Context\Front\CategoryContextInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\ContactBundle\Context\Front\ContactContextInterface;
use WellCommerce\Bundle\CoreBundle\Manager\ManagerInterface;
use WellCommerce\Bundle\NewsBundle\Context\Front\NewsContextInterface;
use WellCommerce\Bundle\OrderBundle\Context\Front\OrderContextInterface;
use WellCommerce\Bundle\PageBundle\Context\Front\PageContextInterface;
use WellCommerce\Bundle\ProducerBundle\Context\Front\ProducerContextInterface;
use WellCommerce\Bundle\ProductBundle\Context\Front\ProductContextInterface;
use WellCommerce\Bundle\ProductStatusBundle\Context\Front\ProductStatusContextInterface;
use WellCommerce\Bundle\ThemeBundle\Context\Front\ThemeContextInterface;

/**
 * Interface FrontManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface FrontManagerInterface extends ManagerInterface
{
    /**
     * @return CategoryContextInterface
     */
    public function getCategoryContext() : CategoryContextInterface;

    /**
     * @return ContactContextInterface
     */
    public function getContactContext() : ContactContextInterface;

    /**
     * @return OrderContextInterface
     */
    public function getOrderContext() : OrderContextInterface;

    /**
     * @return NewsContextInterface
     */
    public function getNewsContext() : NewsContextInterface;

    /**
     * @return PageContextInterface
     */
    public function getPageContext() : PageContextInterface;

    /**
     * @return ProductContextInterface
     */
    public function getProductContext() : ProductContextInterface;

    /**
     * @return ProductStatusContextInterface
     */
    public function getProductStatusContext() : ProductStatusContextInterface;

    /**
     * @return ProducerContextInterface
     */
    public function getProducerContext() : ProducerContextInterface;

    /**
     * @return ThemeContextInterface
     */
    public function getThemeContext() : ThemeContextInterface;

    /**
     * @return null|ClientInterface
     */
    public function getClient();
}
