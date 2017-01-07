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

namespace WellCommerce\Bundle\AdminBundle\DataSet\Admin;

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;

/**
 * Class UserDataSet
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserDataSet extends AbstractDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'         => 'user.id',
            'username'   => 'user.username',
            'name'       => 'CONCAT(user.firstName,\' \', user.lastName)',
            'first_name' => 'user.firstName',
            'last_name'  => 'user.lastName',
            'email'      => 'user.email',
            'enabled'    => 'user.enabled',
        ]);
    }
    
    protected function createQueryBuilder(): QueryBuilder
    {
        $queryBuilder = $this->repository->getQueryBuilder();
        $queryBuilder->groupBy('user.id');
        
        return $queryBuilder;
    }
}
