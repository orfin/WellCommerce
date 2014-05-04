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

namespace WellCommerce\Plugin\ClientGroup\Repository;

/**
 * Class ClientGroupRepositoryEvents
 *
 * @package WellCommerce\Plugin\ClientGroup\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ClientGroupRepositoryEvents
{
    const PRE_DELETE  = 'client_group.repository.pre_delete';
    const POST_DELETE = 'client_group.repository.post_delete';
    const PRE_SAVE    = 'client_group.repository.pre_save';
    const POST_SAVE   = 'client_group.repository.post_save';
}