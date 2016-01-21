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

use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\CoreBundle\Manager\AbstractManager;

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
    public function getShopContext()
    {
        return $this->get('shop.context.front');
    }

    /**
     * {@inheritdoc}
     */
    public function getCartContext()
    {
        return $this->get('cart.context.front');
    }

    /**
     * {@inheritdoc}
     */
    public function getCategoryContext()
    {
        return $this->get('category.context.front');
    }

    /**
     * {@inheritdoc}
     */
    public function getProductContext()
    {
        return $this->get('product.context.front');
    }

    /**
     * {@inheritdoc}
     */
    public function getProductStatusContext()
    {
        return $this->get('product_status.context.front');
    }

    /**
     * {@inheritdoc}
     */
    public function getProducerContext()
    {
        return $this->get('producer.context.front');
    }

    /**
     * {@inheritdoc}
     */
    public function getContactContext()
    {
        return $this->get('contact.context.front');
    }

    /**
     * {@inheritdoc}
     */
    public function getNewsContext()
    {
        return $this->get('news.context.front');
    }

    /**
     * {@inheritdoc}
     */
    public function getPageContext()
    {
        return $this->get('page.context.front');
    }

    /**
     * {@inheritdoc}
     */
    public function getThemeContext()
    {
        return $this->get('theme.context.front');
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
