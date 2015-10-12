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

namespace WellCommerce\Bundle\ProductBundle\Provider;

use WellCommerce\Bundle\CategoryBundle\Entity\CategoryInterface;
use WellCommerce\Bundle\CoreBundle\Provider\AbstractProvider;
use WellCommerce\Bundle\DataSetBundle\Conditions\Condition\Eq;
use WellCommerce\Bundle\DataSetBundle\Conditions\ConditionsCollection;
use WellCommerce\Bundle\ProductBundle\Entity\Product;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\ProductBundle\Helper\ProductAttributeHelperInterface;
use WellCommerce\Bundle\ShippingBundle\Provider\ProductShippingMethodProviderInterface;

/**
 * Class ProductsProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductProvider extends AbstractProvider implements ProductProviderInterface
{
    /**
     * @var ProductShippingMethodProviderInterface
     */
    protected $productShippingMethodProvider;

    /**
     * @var ProductAttributeHelperInterface
     */
    protected $productAttributeHelper;

    /**
     * Constructor
     *
     * @param ProductShippingMethodProviderInterface $productShippingMethodProvider
     * @param ProductAttributeHelperInterface        $productAttributeHelper
     */
    public function __construct(ProductShippingMethodProviderInterface $productShippingMethodProvider, ProductAttributeHelperInterface $productAttributeHelper)
    {
        $this->productShippingMethodProvider = $productShippingMethodProvider;
        $this->productAttributeHelper        = $productAttributeHelper;
    }

    /**
     * @var Product
     */
    protected $product;

    /**
     * {@inheritdoc}
     */
    public function setCurrentProduct(ProductInterface $product)
    {
        $this->product = $product;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentProduct()
    {
        return $this->product;
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

        return $this->getCollectionBuilder()->getDataSet([
            'limit'      => 3,
            'order_by'   => 'name',
            'order_dir'  => 'asc',
            'conditions' => $conditions
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getProductDefaultTemplateData()
    {
        $product             = $this->getCurrentProduct();
        $shippingMethodCosts = $this->productShippingMethodProvider->getShippingMethodCostsCollection($product);
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
     * {@inheritdoc}
     */
    public function hasCurrentProduct()
    {
        return (null !== $this->product);
    }
}
