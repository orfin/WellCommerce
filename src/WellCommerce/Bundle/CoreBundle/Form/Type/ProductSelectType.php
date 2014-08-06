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

namespace WellCommerce\Bundle\CoreBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WellCommerce\Bundle\CoreBundle\Form\AbstractType;

/**
 * Class ProductSelectType
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Type
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductSelectType extends AbstractType
{

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => [],
        ));
    }

    public function getName()
    {
        return 'product_select';
    }
}