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
     * @return \WellCommerce\AppBundle\Context\Front\CartContextInterface
     */
    public function getCartContext();

    /**
     * @return \WellCommerce\AppBundle\Context\Front\CategoryContextInterface
     */
    public function getCategoryContext();

    /**
     * @return \WellCommerce\AppBundle\Context\Front\ContactContextInterface
     */
    public function getContactContext();

    /**
     * @return \WellCommerce\AppBundle\Context\Front\NewsContextInterface
     */
    public function getNewsContext();

    /**
     * @return \WellCommerce\AppBundle\Context\Front\PageContextInterface
     */
    public function getPageContext();

    /**
     * @return \WellCommerce\AppBundle\Context\Front\ProductContextInterface
     */
    public function getProductContext();

    /**
     * @return \WellCommerce\AppBundle\Context\Front\ProductStatusContextInterface
     */
    public function getProductStatusContext();

    /**
     * @return \WellCommerce\AppBundle\Context\Front\ProducerContextInterface
     */
    public function getProducerContext();

    /**
     * @return \WellCommerce\AppBundle\Context\Front\ThemeContextInterface
     */
    public function getThemeContext();

    /**
     * @return null|\WellCommerce\AppBundle\Entity\ClientInterface
     */
    public function getClient();
}
