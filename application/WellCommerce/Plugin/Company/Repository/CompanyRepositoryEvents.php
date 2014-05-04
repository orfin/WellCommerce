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

/**
 * Class CompanyRepositoryEvents
 *
 * @package WellCommerce\Plugin\Company\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class CompanyRepositoryEvents
{
    const PRE_DELETE  = 'company.repository.pre_delete';
    const POST_DELETE = 'company.repository.post_delete';
    const PRE_SAVE    = 'company.repository.pre_save';
    const POST_SAVE   = 'company.repository.post_save';
}