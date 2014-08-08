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

namespace WellCommerce\Bundle\CompanyBundle\Entity;

use Doctrine\ORM\EntityRepository;
use WellCommerce\Bundle\CoreBundle\DataGrid\Repository\DataGridRepositoryInterface;

/**
 * Class CompanyRepository
 *
 * @package WellCommerce\Bundle\CompanyBundle\Entity
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyRepository extends EntityRepository implements DataGridRepositoryInterface
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
}
