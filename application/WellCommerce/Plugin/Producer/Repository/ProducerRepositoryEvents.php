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

namespace WellCommerce\Plugin\Producer\Repository;

/**
 * Class ProducerRepositoryEvents
 *
 * @package WellCommerce\Plugin\Producer\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ProducerRepositoryEvents
{
    const PRE_DELETE  = 'producer.repository.pre_delete';
    const POST_DELETE = 'producer.repository.post_delete';
    const PRE_SAVE    = 'producer.repository.pre_save';
    const POST_SAVE   = 'producer.repository.post_save';
}