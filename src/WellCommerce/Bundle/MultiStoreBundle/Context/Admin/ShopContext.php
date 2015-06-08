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

namespace WellCommerce\Bundle\MultiStoreBundle\Context\Admin;

use WellCommerce\Bundle\MultiStoreBundle\Context\AbstractShopContext;
use WellCommerce\Bundle\MultiStoreBundle\Context\ShopContextInterface;

/**
 * Class ShopContext
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopContext extends AbstractShopContext implements ShopContextInterface
{
    const SESSION_BAG_NAMESPACE = 'admin/shop';

    /**
     * {@inheritdoc}
     */
    public function getSessionBagNamespace()
    {
        return self::SESSION_BAG_NAMESPACE;
    }

    /**
     * Stores context variables in session
     */
    public function setSessionVariables()
    {
        $sessionBag = $this->requestStack->getMasterRequest()->getSession();

        $sessionBag->set(self::SESSION_BAG_NAMESPACE, [
            'id'   => (null !== $this->currentScope) ? $this->currentScope->getId() : 0,
            'name' => (null !== $this->currentScope) ? $this->currentScope->getName() : null,
            'url'  => (null !== $this->currentScope) ? $this->currentScope->getUrl() : null,
        ]);
    }
}
