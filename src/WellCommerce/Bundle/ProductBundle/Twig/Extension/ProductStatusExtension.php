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
namespace WellCommerce\Bundle\ProductBundle\Twig\Extension;

use WellCommerce\Bundle\ProductBundle\Provider\ProductStatusProviderInterface;

/**
 * Class ProductStatusExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusExtension extends \Twig_Extension
{
    /**
     * @var ProductStatusProviderInterface
     */
    protected $provider;

    /**
     * Constructor
     *
     * @param ProductStatusProviderInterface $provider
     */
    public function __construct(ProductStatusProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('productStatuses', [$this, 'getProductStatuses'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'product_status';
    }

    /**
     * Returns product statuses
     *
     * @param int    $limit
     * @param string $orderBy
     * @param string $orderDir
     *
     * @return array
     */
    public function getProductStatuses($limit = 5, $orderBy = 'name', $orderDir = 'asc')
    {
        $params = [
            'limit'         => $limit,
            'order_by'      => $orderBy,
            'order_dir'     => $orderDir,
            'cache_enabled' => true,
            'cache_ttl'     => 3600
        ];

        $statuses = $this->provider->getCollectionBuilder()->getArray($params);

        return $statuses;
    }
}
