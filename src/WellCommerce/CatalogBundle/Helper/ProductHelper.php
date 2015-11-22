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

namespace WellCommerce\CatalogBundle\Helper;

use WellCommerce\CatalogBundle\Entity\CategoryInterface;
use WellCommerce\CatalogBundle\Entity\ProductInterface;
use WellCommerce\Component\DataSet\Conditions\Condition\Eq;
use WellCommerce\Component\DataSet\Conditions\ConditionsCollection;
use WellCommerce\Component\DataSet\DataSetInterface;
use WellCommerce\SalesBundle\Provider\ShippingMethodProviderInterface;

/**
 * Class ProductHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductHelper implements ProductHelperInterface
{
    /**
     * @var ShippingMethodProviderInterface
     */
    protected $shippingMethodProvider;

    /**
     * @var ProductAttributeHelperInterface
     */
    protected $productAttributeHelper;

    /**
     * @var DataSetInterface
     */
    protected $dataset;

    /**
     * Constructor
     *
     * @param DataSetInterface                $dataset
     * @param ShippingMethodProviderInterface $shippingMethodProviderInterface
     * @param ProductAttributeHelperInterface $productAttributeHelper
     */
    public function __construct(
        DataSetInterface $dataset,
        ShippingMethodProviderInterface $shippingMethodProvider,
        ProductAttributeHelperInterface $productAttributeHelper
    ) {
        $this->shippingMethodProvider = $shippingMethodProvider;
        $this->productAttributeHelper = $productAttributeHelper;
        $this->dataset                = $dataset;
    }

    /**
     * {@inheritdoc}
     */
    public function getProductDefaultTemplateData(ProductInterface $product)
    {
        $shippingMethodCosts = $this->shippingMethodProvider->getShippingMethodCostsCollection($product);
        $productAttributes   = $product->getAttributes();
        $groups              = $this->productAttributeHelper->getAttributeGroups($productAttributes);
        $attributes          = $this->productAttributeHelper->getAttributes($productAttributes);

        return [
            'product'         => $product,
            'shippingCosts'   => $shippingMethodCosts,
            'attributeGroups' => $groups,
            'attributes'      => json_encode($attributes)
        ];
    }

    /**
     * Returns a dataset of products recommended for category
     *
     * @param CategoryInterface $category
     *
     * @return array
     */
    public function getProductRecommendationsForCategory(CategoryInterface $category)
    {
        $conditions = new ConditionsCollection();
        $conditions->add(new Eq('category', $category->getId()));

        return $this->dataset->getResult('datagrid', [
            'limit'      => 3,
            'order_by'   => 'name',
            'order_dir'  => 'asc',
            'conditions' => $conditions
        ]);
    }

}
