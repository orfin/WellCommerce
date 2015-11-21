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

namespace WellCommerce\CoreBundle\Component\Form\Elements\Input;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\CoreBundle\Component\Form\Elements\ElementInterface;
use WellCommerce\CoreBundle\Component\Form\Elements\AttributeCollection;
use WellCommerce\CoreBundle\Component\Form\Elements\Attribute;

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

        $resolver->setDefaults([
            'suffix'        => '',
            'prefix'        => '',
            'size'          => '',
            'selector'      => '',
            'wrap'          => '',
            'css_attribute' => '',
            'max_length'    => 255,
        ]);

        $resolver->setAllowedTypes([
            'size'          => 'string',
            'suffix'        => 'string',
            'prefix'        => 'string',
            'selector'      => 'string',
            'wrap'          => 'string',
            'css_attribute' => 'string',
            'max_length'    => 'integer',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesCollection(AttributeCollection $collection)
    {
        parent::prepareAttributesCollection($collection);
        $collection->add(new Attribute('size', $this->getOption('size')));
    }
}
