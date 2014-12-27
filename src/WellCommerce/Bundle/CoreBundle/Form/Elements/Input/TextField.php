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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements\Input;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;

/**
 * Class TextField
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TextField extends AbstractInputField implements ElementInterface
{
    const SIZE_SHORT  = 'short';
    const SIZE_MEDIUM = 'medium';
    const SIZE_LONG   = 'long';

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefined([
            'suffix',
            'prefix',
            'size',
            'selector',
            'wrap',
            'class',
            'css_attribute',
            'max_length',
        ]);

        $resolver->setAllowedTypes([
            'size'          => 'string',
            'suffix'        => 'string',
            'prefix'        => 'string',
            'selector'      => 'string',
            'wrap'          => 'string',
            'class'         => 'string',
            'css_attribute' => 'string',
            'max_length'    => 'integer',
        ]);
    }
}
