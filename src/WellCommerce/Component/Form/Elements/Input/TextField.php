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

namespace WellCommerce\Component\Form\Elements\Input;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\Form\Elements\Attribute;
use WellCommerce\Component\Form\Elements\AttributeCollection;
use WellCommerce\Component\Form\Elements\ElementInterface;

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

        $resolver->setAllowedTypes('size', 'string');
        $resolver->setAllowedTypes('suffix', 'string');
        $resolver->setAllowedTypes('prefix', 'string');
        $resolver->setAllowedTypes('selector', 'string');
        $resolver->setAllowedTypes('wrap', 'string');
        $resolver->setAllowedTypes('css_attribute', 'string');
        $resolver->setAllowedTypes('max_length', 'integer');
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesCollection(AttributeCollection $collection)
    {
        parent::prepareAttributesCollection($collection);
        $collection->add(new Attribute('sSize', $this->getOption('size')));
        $collection->add(new Attribute('sSuffix', $this->getOption('suffix')));
    }
}
