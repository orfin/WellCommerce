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

namespace WellCommerce\Bundle\ProductBundle\DataSet\Admin;

use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Component\DataSet\Conditions\Condition\Eq;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Class ProductDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductDataSet extends AbstractDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'          => 'product.id',
            'name'        => 'product_translation.name',
            'sku'         => 'product.sku',
            'weight'      => 'product.weight',
            'grossAmount' => 'product.sellPrice.grossAmount',
            'stock'       => 'product.stock',
            'shop'        => 'product_shops.id',
            'tax'         => 'sell_tax.value',
            'photo'       => 'photos.path',
            'category'    => 'GROUP_CONCAT(DISTINCT categories_translation.name ORDER BY categories_translation.name ASC SEPARATOR \', \')',
            'categoryId'  => 'categories.id',
        ]);
        
        $configurator->setColumnTransformers([
            'photo' => $this->getDataSetTransformer('image_path', ['filter' => 'small']),
        ]);
    }
    
    protected function getDataSetRequest(array $requestOptions = []) : DataSetRequestInterface
    {
        $request = parent::getDataSetRequest($requestOptions);
        $request->addCondition(new Eq('shop', $this->getShopStorage()->getCurrentShopIdentifier()));
        
        return $request;
    }
}
