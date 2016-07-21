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

namespace WellCommerce\Bundle\CoreBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Container;

/**
 * Class ServiceIdGenerator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ServiceIdGenerator
{
    public function getServiceId(string $baseName, string $type)
    {
        $prefix = $this->getServicePrefix($baseName);
        
        return sprintf('%s.%s', Container::underscore($prefix), $type);
    }
    
    private function getServicePrefix(string $baseName) : string
    {
        $replacements = ['Repository', 'DataSet', 'DataGrid', 'FormBuilder', 'Factory', 'Manager', 'Controller'];
        
        return str_replace($replacements, '', $baseName);
    }
}
