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

namespace WellCommerce\Bundle\SearchBundle\Mapping\Field;

/**
 * Interface SearchFieldInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface SearchFieldInterface
{
    public function getLabel() : string;

    public function isIndexed() : bool;

    public function getType() : string;

    public function getBoost() : float;

    public function isTranslatable() : bool;

    public function getPropertyName() : string;

    public function getAnalyzer();
}
