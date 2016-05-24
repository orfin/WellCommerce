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

namespace WellCommerce\Bundle\SearchBundle\Document;

use WellCommerce\Bundle\SearchBundle\Document\Field\DocumentFieldCollection;

/**
 * Interface DocumentInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DocumentInterface
{
    public function getIdentifier() : int;
    
    public function getFields() : DocumentFieldCollection;
    
    public function getType();
}
