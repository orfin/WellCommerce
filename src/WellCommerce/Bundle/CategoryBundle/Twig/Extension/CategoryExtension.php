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
namespace WellCommerce\Bundle\CategoryBundle\Twig\Extension;

use WellCommerce\Bundle\CategoryBundle\Provider\CategoryProviderInterface;

/**
 * Class CategoryExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryExtension extends \Twig_Extension
{
    /**
     * @var CategoryProviderInterface
     */
    protected $provider;

    /**
     * Constructor
     *
     * @param CategoryProviderInterface $provider
     */
    public function __construct(CategoryProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('categoriesTree', [$this, 'getCategoriesTree'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'category';
    }

    /**
     * Returns categories tree
     *
     * @param int    $limit
     * @param string $orderBy
     * @param string $orderDir
     *
     * @return array
     */
    public function getCategoriesTree($limit = 10, $orderBy = 'hierarchy', $orderDir = 'asc')
    {
        $collectionBuilder = $this->provider->getCollectionBuilder();

        $params = [
            'limit'         => $limit,
            'order_by'      => $orderBy,
            'order_dir'     => $orderDir,
            'cache_enabled' => true,
            'cache_ttl'     => 3600
        ];

        return $collectionBuilder->getTree($params);
    }
}
