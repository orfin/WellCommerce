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
namespace WellCommerce\Bundle\CmsBundle\Repository;

use WellCommerce\Bundle\CategoryBundle\Tree\CategoryTreeBuilder;
use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;

/**
 * Class PageRepository
 *
 * @package WellCommerce\Bundle\CmsBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PageRepository extends AbstractEntityRepository implements PageRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataSetQueryBuilder()
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->leftJoin('page.translations', 'page_translation');
        $queryBuilder->leftJoin('page.children', 'page_children');
        $queryBuilder->groupBy('page.id');

        return $queryBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getPagesTree()
    {
        $queryBuilder = $this->getQueryBuilder('page');

        // select columns
        $queryBuilder->select('
            page.id,
            IDENTITY(page.parent) parent,
            COUNT(page_children.id) children,
            page_translation.name,
            page_translation.slug,
            page_translation.locale,
            IDENTITY(page_translation.route) route
        ');

        // page table
        $queryBuilder->leftJoin(
            'WellCommerceCmsBundle:Page',
            'page_children',
            'WITH',
            'page_children.parent = page.id');

        // page_translation table
        $queryBuilder->leftJoin(
            'WellCommerceCmsBundle:PageTranslation',
            'page_translation',
            'WITH',
            'page.id = page_translation.translatable');
        $queryBuilder->groupBy('page.id');
        $query   = $queryBuilder->getQuery();
        $items   = $query->getArrayResult();
        $builder = new CategoryTreeBuilder($items);

        return $builder->getTree();
    }
}
