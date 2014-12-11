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
namespace WellCommerce\Bundle\ProductBundle\Repository;

use Doctrine\ORM\Query\Expr;
use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;

/**
 * Class ProductRepository
 *
 * @package WellCommerce\Bundle\ProductBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductRepository extends AbstractEntityRepository implements ProductRepositoryInterface
{
    public function getProductCollectionQueryBuilder()
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->select([
            'product',
            'currency',
            'gallery',
            'photos',
            'translations',
            'routes',

        ]);
        $queryBuilder->groupBy('product.id');
        $queryBuilder->leftJoin('product.translations', 'translations');
        $queryBuilder->leftJoin('product.sellCurrency', 'currency');
        $queryBuilder->leftJoin('translations.route', 'routes');
        $queryBuilder->leftJoin('product.productPhotos', 'gallery', Expr\Join::WITH, 'gallery.mainPhoto = :mainPhoto');
        $queryBuilder->leftJoin('gallery.photo', 'photos');
        $queryBuilder->leftJoin('product.statuses', 'statuses');
        $queryBuilder->leftJoin('statuses.translations', 'statuses_translation');
        $queryBuilder->setParameter('mainPhoto', 1);

        return $queryBuilder;
    }
}
