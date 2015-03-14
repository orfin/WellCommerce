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

namespace WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Generator;

use Wingu\OctopusCore\CodeGenerator\PHP\Annotation\Tags\BaseTag;
use Wingu\OctopusCore\CodeGenerator\PHP\DocCommentGenerator;
use Wingu\OctopusCore\CodeGenerator\PHP\OOP\Modifiers;
use Wingu\OctopusCore\CodeGenerator\PHP\OOP\PropertyGenerator;
use Wingu\OctopusCore\CodeGenerator\PHP\OOP\TraitGenerator;

/**
 * Class EntityTraitGenerator
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class EntityTraitGenerator
{

    public function generate()
    {

        $generator          = new TraitGenerator('CategoryExtraTrait',
            'WellCommerce\Bundle\CategoryBundle\Entity\Extra');
        $traitDocAnnotation = new BaseTag('baseAnnotation', 'testing');
        $traitDoc           = new DocCommentGenerator('Short trait description.',
            "Long description.\nOn multiple lines.", [$traitDocAnnotation]);
        $generator->setDocumentation($traitDoc);

        $properties         = [];
        $discount           = new PropertyGenerator('discount', 'private', Modifiers::MODIFIER_PRIVATE);
        $discountAnnotation = new BaseTag('ORM\Column(name="discount", type="integer")');
        $discountDoc        = new DocCommentGenerator('Discount', "", [$discountAnnotation]);
        $discount->setDocumentation($discountDoc);

        $properties[] = $discount;

        $generator->setProperties($properties);

        $generator->generate();
    }
}
