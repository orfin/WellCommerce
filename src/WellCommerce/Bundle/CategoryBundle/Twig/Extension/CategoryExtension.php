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
 * @package WellCommerce\Bundle\CategoryBundle\Twig\Extension
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
     * Returns categories tree
     *
     * @param int    $limit
     * @param string $orderBy
     * @param string $orderDir
     *
     * @return mixed
     */
    public function getCategoriesTree(
        $limit = CategoryProviderInterface::CATEGORY_TREE_LIMIT,
        $orderBy = CategoryProviderInterface::CATEGORY_ORDER_BY,
        $orderDir = CategoryProviderInterface::CATEGORY_ORDER_DIR
    ) {

        return $this->provider->getCategoriesTree($limit, $orderBy, $orderDir);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'category';
    }
}
