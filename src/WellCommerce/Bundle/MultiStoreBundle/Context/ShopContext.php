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

namespace WellCommerce\Bundle\MultiStoreBundle\Context;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use WellCommerce\Bundle\MultiStoreBundle\Entity\Shop;
use WellCommerce\Bundle\MultiStoreBundle\Repository\ShopRepositoryInterface;

/**
 * Class ShopContext
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopContext
{
    const SESSION_BAG_NAMESPACE = 'scope/shop';

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var ShopRepositoryInterface
     */
    protected $repository;

    /**
     * @var Shop
     */
    protected $currentScope;

    /**
     * Constructor
     *
     * @param RequestStack            $requestStack
     * @param ShopRepositoryInterface $repository
     */
    public function __construct(RequestStack $requestStack, ShopRepositoryInterface $repository)
    {
        $this->requestStack = $requestStack;
        $this->repository   = $repository;
    }

    /**
     * Returns active shop
     *
     * @return Shop
     */
    public function getCurrentScope()
    {
        return $this->currentScope;
    }

    /**
     * Sets active shop
     *
     * @param Shop $shop
     */
    public function setCurrentScope(Shop $shop)
    {
        $this->currentScope = $shop;
        $this->setSessionVariables();
    }

    /**
     * Sets current shop scope by url
     *
     * @param string $url
     */
    public function setCurrentScopeByUrl($url)
    {
        $result = $this->repository->findOneBy(['url' => $url]);
        if (null !== $result) {
            $this->setCurrentScope($result);
        }
    }

    protected function setSessionVariables()
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
