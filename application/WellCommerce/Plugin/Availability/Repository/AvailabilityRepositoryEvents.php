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

namespace WellCommerce\Plugin\Availability\Repository;

/**
 * Class AvailabilityRepositoryEvents
 *
 * @package WellCommerce\Plugin\Availability\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class AvailabilityRepositoryEvents
{
    const PRE_DELETE  = 'availability.repository.pre_delete';
    const POST_DELETE = 'availability.repository.post_delete';
    const PRE_SAVE    = 'availability.repository.pre_save';
    const POST_SAVE   = 'availability.repository.post_save';
}