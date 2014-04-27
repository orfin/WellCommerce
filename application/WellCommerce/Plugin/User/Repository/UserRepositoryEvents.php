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

/**
 * Class UserRepositoryEvents
 *
 * @package WellCommerce\Plugin\User\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class UserRepositoryEvents
{
    const PRE_DELETE    = 'user.repository.pre_delete';
    const POST_DELETE   = 'user.repository.post_delete';
    const PRE_SAVE      = 'user.repository.pre_save';
    const POST_SAVE     = 'user.repository.post_save';
    const LOGIN_FAILED  = 'user.repository.login_failed';
    const LOGIN_SUCCEED = 'user.repository.login_succeed';
}