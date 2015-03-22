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
    const SESSION_BAG_NAMESPACE = 'admin/shop';

    /**
     * {@inheritdoc}
     */
    public function getSessionBagNamespace()
    {
        return self::SESSION_BAG_NAMESPACE;
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrentScope(Shop $shop = null)
    {
        $this->currentScope = $shop;
        $this->setSessionVariables();
    }

    /**
     * Sets current shop scope by url
     *
     * @param string $host
     */
    public function setCurrentScopeByHost($host)
    {
        $result = $this->repository->findOneBy(['url' => $host]);
        $this->setCurrentScope($result);
    }

    public function determineCurrentScope($host)
    {
        $sessionBag = $this->requestStack->getMasterRequest()->getSession();
        if (!$this->hasSessionPreviousData($sessionBag)) {
            $this->setCurrentScopeByHost($host);
        }
    }

    protected function setSessionVariables()
    {
        $sessionBag  = $this->requestStack->getMasterRequest()->getSession();
        $sessionData = [];

        if (null !== $this->currentScope) {
            $sessionData = [
                'id'   => $this->currentScope->getId(),
                'name' => $this->currentScope->getName(),
                'url'  => $this->currentScope->getUrl(),
            ];
        }

        $sessionBag->set(self::SESSION_BAG_NAMESPACE, $sessionData);
    }

    /**
     * Checks whether session contains previous shop data
     *
     * @param SessionInterface $sessionBag
     *
     * @return bool
     */
    protected function hasSessionPreviousData(SessionInterface $sessionBag)
    {
        return (bool)$sessionBag->has(self::SESSION_BAG_NAMESPACE);
    }
}
