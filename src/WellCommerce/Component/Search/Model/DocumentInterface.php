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
 * Interface DocumentInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DocumentInterface
{
    public function getIdentifier() : int;

    public function getLocale() : string;

    public function getType() : TypeInterface;

    public function getFields() : Collection;
}
