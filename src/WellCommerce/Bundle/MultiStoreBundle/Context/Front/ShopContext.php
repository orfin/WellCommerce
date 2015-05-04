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

namespace WellCommerce\Bundle\MultiStoreBundle\Context\Front;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use WellCommerce\Bundle\MultiStoreBundle\Context\AbstractShopContext;
use WellCommerce\Bundle\MultiStoreBundle\Context\ShopContextInterface;
use WellCommerce\Bundle\MultiStoreBundle\Entity\Shop;

/**
 * Class ShopContext
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopContext extends AbstractShopContext implements ShopContextInterface
{
    const SESSION_BAG_NAMESPACE = 'front/shop';

    public function getSessionBagNamespace()
    {
        return self::SESSION_BAG_NAMESPACE;
    }

    public function setSessionVariables()
    {
        $sessionBag = $this->requestStack->getMasterRequest()->getSession();

        if (!$this->hasSessionPreviousData($sessionBag)) {
            $sessionData = [
                'id'    => $this->currentScope->getId(),
                'name'  => $this->currentScope->getName(),
                'url'   => $this->currentScope->getUrl(),
                'theme' => [
                    'id'     => $this->currentScope->getTheme()->getId(),
                    'name'   => $this->currentScope->getTheme()->getName(),
                    'folder' => $this->currentScope->getTheme()->getFolder(),
                ]
            ];

            $sessionBag->set(self::SESSION_BAG_NAMESPACE, $sessionData);
        }
    }
}
