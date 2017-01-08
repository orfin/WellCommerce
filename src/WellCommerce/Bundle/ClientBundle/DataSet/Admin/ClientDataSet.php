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

namespace WellCommerce\Bundle\ClientBundle\DataSet\Admin;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;

/**
 * Class ClientDataSet
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientDataSet extends AbstractDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'          => 'client.id',
            'firstName'   => 'client.contactDetails.firstName',
            'lastName'    => 'client.contactDetails.lastName',
            'companyName' => 'client.billingAddress.companyName',
            'vatId'       => 'client.billingAddress.vatId',
            'email'       => 'client.contactDetails.email',
            'phone'       => 'client.contactDetails.phone',
            'groupName'   => 'client_group_translation.name',
            'createdAt'   => 'client.createdAt',
            'shop'        => 'IDENTITY(client.shop)',
            'lastActive'  => 'client_cart.updatedAt',
            'cart'        => 'IF_NULL(client_cart.id, 0)',
            'cartValue'   => 'IF_NULL(client_cart.summary.grossAmount, 0)',
        ]);
        
        $configurator->setColumnTransformers([
            'createdAt'  => $this->manager->createTransformer('date', ['format' => 'Y-m-d H:i:s']),
            'lastActive' => $this->manager->createTransformer('date', ['format' => 'Y-m-d H:i:s']),
            'cart'       => $this->manager->createTransformer('client_cart'),
        ]);
    }
    
    protected function createQueryBuilder(): QueryBuilder
    {
        $queryBuilder = $this->repository->getQueryBuilder();
        $queryBuilder->groupBy('client.id');
        $queryBuilder->leftJoin('client.clientGroup', 'client_group');
        $queryBuilder->leftJoin('client_group.translations', 'client_group_translation');
        $queryBuilder->leftJoin('client.orders', 'client_cart', Expr\Join::WITH, 'client_cart.confirmed = 0');
        $queryBuilder->where($queryBuilder->expr()->eq('client.shop', $this->getShopStorage()->getCurrentShopIdentifier()));
        
        return $queryBuilder;
    }
}
