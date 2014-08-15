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

use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;

/**
 * Class ClientGroupRepository
 *
 * @package WellCommerce\Bundle\ClientBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientGroupRepository extends AbstractEntityRepository implements ClientGroupRepositoryInterface
{
    public function getDataGridQueryBuilder()
    {
        return parent::getQueryBuilder()
            ->leftJoin(
                'WellCommerce\Bundle\ClientBundle\Entity\ClientGroupTranslation',
                'client_group_translation',
                'WITH',
                'client_group.id = client_group_translation.translatable AND client_group_translation.locale = :locale');
    }

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
}
