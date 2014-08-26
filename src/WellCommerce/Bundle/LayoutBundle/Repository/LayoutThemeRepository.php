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
namespace WellCommerce\Bundle\LayoutBundle\Repository;

use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;
use WellCommerce\Bundle\LayoutBundle\Entity\LayoutTheme;
use WellCommerce\Bundle\LayoutBundle\Manager\Layout;

/**
 * Class LayoutThemeRepository
 *
 * @package WellCommerce\Bundle\LayoutBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutThemeRepository extends AbstractEntityRepository implements LayoutThemeRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataGridQueryBuilder()
    {
        return parent::getQueryBuilder();
    }

    /**
     * {@inheritdoc}
     */
    public function getLayoutColumns(LayoutTheme $theme, Layout $layout)
    {
        $queryBuilder = parent::getQueryBuilder();

        $queryBuilder->select('layout_page_column');

        $queryBuilder->leftJoin(
            'WellCommerce\Bundle\LayoutBundle\Entity\LayoutPageColumn',
            'layout_page_column',
            'WITH',
            'layout_page_column.theme = layout_theme.id');

        $queryBuilder->leftJoin(
            'WellCommerce\Bundle\LayoutBundle\Entity\LayoutPage',
            'layout_page',
            'WITH',
            'layout_page_column.page = layout_page.id');

        $queryBuilder
            ->where($queryBuilder->expr()->eq('layout_theme.id', ':themeId'))
            ->andWhere($queryBuilder->expr()->eq('layout_page.name', ':layoutName'));

        $queryBuilder->setParameters([
            'themeId'    => $theme->getId(),
            'layoutName' => $layout->getName()
        ]);

        return $queryBuilder->getQuery()->getResult();
    }
}
