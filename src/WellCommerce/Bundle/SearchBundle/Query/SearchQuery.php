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
 * Class SearchQuery
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class SearchQuery
{
    /**
     * @var string
     */
    private $phrase;

    /**
     * SearchQuery constructor.
     *
     * @param string $phrase
     */
    public function __construct(string $phrase)
    {
        $this->phrase = $phrase;
    }

    public function getSearchPhrase() : string
    {
        return $this->phrase;
    }
}
