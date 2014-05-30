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

namespace WellCommerce\Plugin\User\Repository;

use WellCommerce\Plugin\User\Model\UserDataInterface;

/**
 * Interface UserRepositoryInterface
 *
 * @package WellCommerce\Plugin\User\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface UserRepositoryInterface
{
    const PRE_DELETE_EVENT  = 'user.repository.pre_delete';
    const POST_DELETE_EVENT = 'user.repository.post_delete';
    const PRE_SAVE_EVENT    = 'user.repository.pre_save';
    const POST_SAVE_EVENT   = 'user.repository.post_save';

    public function all();

    public function find($id);

    public function save(UserDataInterface $user);

    public function delete($id);

    public function authProcess(array $data);
}