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

namespace WellCommerce\Bundle\ClientBundle\Repository;

use WellCommerce\Bundle\CoreBundle\DataGrid\Repository\DataGridRepositoryInterface;
use WellCommerce\Bundle\CoreBundle\Repository\TranslatableRepository;

/**
 * Class ClientGroupRepository
 *
 * @package WellCommerce\Bundle\ClientBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientGroupRepository extends TranslatableRepository implements DataGridRepositoryInterface, ClientGroupRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function deleteRow($id)
    {
        $entity = $this->find($id);
        $this->_em->remove($entity);
        $this->_em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function updateRow(array $request)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function deleteMultipleRows(array $ids)
    {
        return false;
    }

    public function findAll()
    {
        $qb = $this->createQueryBuilder('client_group');
        return $this->getResult($qb, 'fr_FRa');
    }
}
