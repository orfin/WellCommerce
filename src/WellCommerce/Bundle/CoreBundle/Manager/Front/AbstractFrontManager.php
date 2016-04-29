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
use WellCommerce\Bundle\CoreBundle\Manager\AbstractManager;
use WellCommerce\Bundle\NewsBundle\Context\Front\NewsContextInterface;
use WellCommerce\Bundle\OrderBundle\Context\Front\OrderContextInterface;
use WellCommerce\Bundle\PageBundle\Context\Front\PageContextInterface;
use WellCommerce\Bundle\ProducerBundle\Context\Front\ProducerContextInterface;
use WellCommerce\Bundle\ProductBundle\Context\Front\ProductContextInterface;
use WellCommerce\Bundle\ProductStatusBundle\Context\Front\ProductStatusContextInterface;
use WellCommerce\Bundle\ShopBundle\Context\ShopContextInterface;
use WellCommerce\Bundle\ThemeBundle\Context\Front\ThemeContextInterface;

/**
 * Class AbstractFrontManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractFrontManager extends AbstractManager implements FrontManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getShopContext() : ShopContextInterface
    {
        return $this->get('shop.context.front');
    }

    /**
     * {@inheritdoc}
     */
    public function getCategoryContext() : CategoryContextInterface
    {
        return $this->get('category.context.front');
    }

    /**
     * {@inheritdoc}
     */
    public function getProductContext() : ProductContextInterface
    {
        return $this->get('product.context.front');
    }

    /**
     * {@inheritdoc}
     */
    public function getProductStatusContext() : ProductStatusContextInterface
    {
        return $this->get('product_status.context.front');
    }

    /**
     * {@inheritdoc}
     */
    public function getProducerContext() : ProducerContextInterface
    {
        return $this->get('producer.context.front');
    }

    /**
     * {@inheritdoc}
     */
    public function getContactContext() : ContactContextInterface
    {
        return $this->get('contact.context.front');
    }

    /**
     * {@inheritdoc}
     */
    public function getNewsContext() : NewsContextInterface
    {
        return $this->get('news.context.front');
    }

    /**
     * {@inheritdoc}
     */
    public function getPageContext() : PageContextInterface
    {
        return $this->get('page.context.front');
    }

    /**
     * {@inheritdoc}
     */
    public function getThemeContext() : ThemeContextInterface
    {
        return $this->get('theme.context.front');
    }
    
    /**
     * {@inheritdoc}
     */
    public function getOrderContext() : OrderContextInterface
    {
        return $this->get('order.context.front');
    }

    /**
     * {@inheritdoc}
     */
    public function getClient()
    {
        $user = $this->getUser();

        if ($user instanceof ClientInterface) {
            return $user;
        }

        return null;
    }
}
