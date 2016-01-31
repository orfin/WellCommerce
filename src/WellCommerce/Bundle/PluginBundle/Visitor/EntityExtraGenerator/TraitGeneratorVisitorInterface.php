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

namespace WellCommerce\Bundle\PluginBundle\Visitor\EntityExtraGenerator;

use Zend\Code\Generator\TraitGenerator;

/**
 * Interface EntityExtraGeneratorVisitorInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface TraitGeneratorVisitorInterface
{
    /**
     * @param TraitGenerator $generator
     */
    public function visit(TraitGenerator $generator);

    /**
     * @return string
     */
    public function getSupportedClass();
}
