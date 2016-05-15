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

namespace WellCommerce\Bundle\SearchBundle\Storage;

/**
 * Class SearchResultStorage
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class SearchResultStorage
{
    private $result = [];

    public function getResult() : array
    {
        return (0 !== count($this->result)) ? $this->result : [0];
    }

    public function setResult(array $result)
    {
        $this->result = $result;
    }
}
