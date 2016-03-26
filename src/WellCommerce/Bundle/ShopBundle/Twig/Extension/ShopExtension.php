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
namespace WellCommerce\Bundle\ShopBundle\Twig\Extension;

use WellCommerce\Bundle\ShopBundle\Context\ShopContextInterface;
use WellCommerce\Bundle\ShopBundle\Entity\ShopInterface;
use WellCommerce\Component\DataSet\DataSetInterface;

/**
 * Class ShopExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopExtension extends \Twig_Extension
{
    /**
     * @var ShopContextInterface
     */
    protected $frontContext;

    /**
     * @var ShopContextInterface
     */
    protected $adminContext;

    /**
     * @var DataSetInterface
     */
    protected $shopDataset;

    /**
     * ShopExtension constructor.
     *
     * @param ShopContextInterface $frontContext
     * @param ShopContextInterface $adminContext
     * @param DataSetInterface     $shopDataset
     */
    public function __construct(ShopContextInterface $frontContext, ShopContextInterface $adminContext, DataSetInterface $shopDataset)
    {
        $this->frontContext = $frontContext;
        $this->adminContext = $adminContext;
        $this->shopDataset  = $shopDataset;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('currentShop', [$this, 'getCurrentShop'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('currentAdminShop', [$this, 'getCurrentAdminShop'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('shops', [$this, 'getShops'], ['is_safe' => ['html']]),
        ];
    }
    
    public function getCurrentShop() : ShopInterface
    {
        return $this->frontContext->getCurrentShop();
    }

    public function getCurrentAdminShop() : ShopInterface
    {
        return $this->adminContext->getCurrentShop();
    }
    
    public function getShops() : array
    {
        return $this->shopDataset->getResult('select');
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'shop';
    }
}
