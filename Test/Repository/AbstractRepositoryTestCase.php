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

namespace WellCommerce\Bundle\CoreBundle\Test\Repository;

use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;

/**
 * Class AbstractRepositoryTestCase
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractRepositoryTestCase extends AbstractTestCase
{
    public function testRepositoryServiceIsCreated()
    {
        $repository = $this->get();

        if (null !== $repository) {
            $this->assertInstanceOf('WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface', $repository);
        }
    }

    /**
     * @return null|\WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface
     */
    protected function get()
    {
        return null;
    }

    public function testRepositoryHasDatasetQueryBuilder()
    {
        $repository = $this->get();
        if (null !== $repository) {
            $this->assertInstanceOf('Doctrine\ORM\QueryBuilder', $repository->getDataSetQueryBuilder());
        }
    }

    public function testQueryBuilderReturnsValidQuery()
    {
        $repository = $this->get();
        if (null !== $repository) {
            $this->assertInstanceOf('Doctrine\ORM\Query', $repository->getDataSetQueryBuilder()->getQuery());
        }
    }
}
