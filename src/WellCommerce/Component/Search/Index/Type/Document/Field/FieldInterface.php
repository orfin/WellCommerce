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

namespace WellCommerce\Component\Search;

/**
 * Interface FieldInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface FieldInterface
{
    public function getName() : string;

    public function getValue() : string;

    public function getBoost() : float;

    public function getAnalyzer() : string;

    public function isIndexed() : bool;
}
