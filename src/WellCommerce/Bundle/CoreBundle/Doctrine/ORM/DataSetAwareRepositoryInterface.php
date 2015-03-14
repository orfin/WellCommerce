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

namespace WellCommerce\Bundle\CoreBundle\Doctrine\ORM;

/**
 * Interface DataSetAwareRepositoryInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DataSetAwareRepositoryInterface
{
    /**
     * Returns query builder from related repository
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getDataSetQueryBuilder();

    /**
     * Returns repository alias which is used also as dataset identifier
     *
     * @return mixed
     */
    public function getAlias();
}
