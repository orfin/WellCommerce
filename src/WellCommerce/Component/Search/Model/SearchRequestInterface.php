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

namespace WellCommerce\Component\Search\Model;

use Doctrine\Common\Collections\Collection;

/**
 * Interface SearchRequestInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface SearchRequestInterface
{
    public function getType() : TypeInterface;

    public function getFields() : Collection;

    public function getPhrase() : string;

    public function getLocale() : string;
}
