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

namespace WellCommerce\Bundle\SearchBundle\Query;

/**
 * Class SimpleQuery
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SimpleQuery
{
    /**
     * @var string
     */
    protected $searchPhrase;

    /**
     * Term constructor.
     *
     * @param string $searchPhrase
     */
    public function __construct($searchPhrase)
    {
        $this->searchPhrase = $searchPhrase;
    }

    /**
     * @return string
     */
    public function getSearchPhrase()
    {
        return $this->searchPhrase;
    }
}
