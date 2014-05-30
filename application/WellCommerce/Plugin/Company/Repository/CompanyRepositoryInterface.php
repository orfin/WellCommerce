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

namespace WellCommerce\Plugin\Company\Repository;

use WellCommerce\Plugin\Company\Model\CompanyDataInterface;

/**
 * Interface CompanyRepositoryInterface
 *
 * @package WellCommerce\Plugin\Company\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CompanyRepositoryInterface
{
    const PRE_DELETE_EVENT  = 'company.repository.pre_delete';
    const POST_DELETE_EVENT = 'company.repository.post_delete';
    const PRE_SAVE_EVENT    = 'company.repository.pre_save';
    const POST_SAVE_EVENT   = 'company.repository.post_save';

    public function all();

    public function find($id);

    public function save(array $data, $id = null);

    public function delete($id);

    public function getAllCompanyToSelect();

    public function getShopsTree();
} 