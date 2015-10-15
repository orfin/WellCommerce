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
use WellCommerce\Bundle\CoreBundle\Provider\AbstractResourceProvider;
use WellCommerce\Bundle\DataSetBundle\Conditions\Condition\Eq;
use WellCommerce\Bundle\DataSetBundle\Conditions\ConditionsCollection;
use WellCommerce\Bundle\DataSetBundle\DataSetInterface;
use WellCommerce\Bundle\ProductBundle\Helper\ProductAttributeHelperInterface;
use WellCommerce\Bundle\ShippingBundle\Provider\ProductShippingMethodProviderInterface;
use WellCommerce\Bundle\ShippingBundle\Provider\ShippingMethodProviderInterface;

/**
 * Class ProductProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductProvider extends AbstractResourceProvider implements ProductProviderInterface
{
    /**
     * @var ShippingMethodProviderInterface
     */
    protected $provider;

    /**
     * @var ProductAttributeHelperInterface
     */
    protected $helper;

    /**
     * @var DataSetInterface
     */
    protected $dataset;

    /**
     * Constructor
     *
     * @param DataSetInterface                       $dataset
     * @param ProductShippingMethodProviderInterface $provider
     * @param ProductAttributeHelperInterface        $helper
     */
    public function __construct(
        DataSetInterface $dataset,
        ProductShippingMethodProviderInterface $provider,
        ProductAttributeHelperInterface $helper
    ) {
        $this->provider = $provider;
        $this->helper   = $helper;
        $this->dataset  = $dataset;
    }

    /**
     * {@inheritdoc}
     */
    public function getProductDefaultTemplateData()
    {
        $product             = $this->getProduct();
        $shippingMethodCosts = $this->provider->getShippingMethodCostsCollection($product);
        $productAttributes   = $product->getAttributes();
        $groups              = $this->helper->getAttributeGroups($productAttributes);
        $attributes          = $this->helper->getAttributes($productAttributes);

        return [
            'product'         => $product,
            'shippingCosts'   => $shippingMethodCosts,
            'attributeGroups' => $groups,
            'attributes'      => json_encode($attributes)
        ];
    }

    /**
     * @return \WellCommerce\Bundle\ProductBundle\Entity\ProductInterface
     */
    protected function getProduct()
    {
        return $this->getResource(true);
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
