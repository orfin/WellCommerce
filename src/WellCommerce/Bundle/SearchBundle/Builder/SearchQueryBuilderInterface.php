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

namespace WellCommerce\Bundle\SearchBundle\Builder;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface SearchQueryBuilderInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface SearchQueryBuilderInterface
{
    public function buildFromRequest(Request $request);
    
    public function getQuery();
}
