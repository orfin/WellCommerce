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

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;

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
    
    protected function createQueryBuilder(): QueryBuilder
    {
        $queryBuilder = $this->repository->getQueryBuilder();
        $queryBuilder->groupBy('product.id');
        $queryBuilder->leftJoin('product.translations', 'product_translation');
        $queryBuilder->leftJoin('product.categories', 'categories');
        $queryBuilder->leftJoin('product.categories', 'filtered_categories');
        $queryBuilder->leftJoin('product.producer', 'producers');
        $queryBuilder->leftJoin('product.sellPriceTax', 'sell_tax');
        $queryBuilder->leftJoin('categories.translations', 'categories_translation');
        $queryBuilder->leftJoin('producers.translations', 'producers_translation');
        $queryBuilder->leftJoin('product.productPhotos', 'gallery', Expr\Join::WITH, 'gallery.mainPhoto = :mainPhoto');
        $queryBuilder->leftJoin('gallery.photo', 'photos');
        $queryBuilder->leftJoin('product.distinctions', 'distinction', Expr\Join::WITH, 'distinction.status = :status');
        $queryBuilder->leftJoin('product.shops', 'product_shops');
        $queryBuilder->leftJoin('product.variants', 'variant', Expr\Join::WITH, 'variant.enabled = :variantEnabled');
        $queryBuilder->leftJoin('variant.options', 'variant_option');
        $queryBuilder->where($queryBuilder->expr()->eq('product_shops.shop', $this->getShopStorage()->getCurrentShopIdentifier()));
        $queryBuilder->setParameter('mainPhoto', 1);
        $queryBuilder->setParameter('status', 0);
        $queryBuilder->setParameter('variantEnabled', 1);
        
        return $queryBuilder;
    }
}
