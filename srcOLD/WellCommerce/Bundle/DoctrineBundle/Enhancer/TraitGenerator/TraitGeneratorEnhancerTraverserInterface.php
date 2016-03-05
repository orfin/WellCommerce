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

namespace WellCommerce\Bundle\DoctrineBundle\Enhancer\TraitGenerator;

use Wingu\OctopusCore\CodeGenerator\PHP\OOP\TraitGenerator;

/**
 * Interface TraitGeneratorEnhancerTraverserInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface TraitGeneratorEnhancerTraverserInterface
{
    /**
     * @param TraitGenerator $generator
     */
    public function traverse(TraitGenerator $generator);
}
