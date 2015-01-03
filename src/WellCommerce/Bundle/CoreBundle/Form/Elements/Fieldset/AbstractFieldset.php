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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements\Fieldset;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\CoreBundle\Form\Elements\AbstractContainer;

/**
 * Class AbstractFieldset
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractFieldset extends AbstractContainer
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefined([
            'dependencies',
            'filters',
            'rules',
            'transformer'
        ]);

        $resolver->setAllowedTypes([
            'dependencies' => 'array',
            'filters'      => 'array',
            'rules'        => 'array',
            'transformer'  => ['null', 'WellCommerce\Bundle\CoreBundle\Form\DataTransformer\DataTransformerInterface'],
        ]);
    }
}