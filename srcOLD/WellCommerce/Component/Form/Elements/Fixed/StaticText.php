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

namespace WellCommerce\Component\Form\Elements\Fixed;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\Form\Elements\Attribute;
use WellCommerce\Component\Form\Elements\AttributeCollection;
use WellCommerce\Component\Form\Elements\ElementInterface;

/**
 * Class StaticText
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class StaticText extends AbstractFixedField implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'text',
        ]);

        $resolver->setDefaults([
            'name'  => '',
            'label' => '',
            'text'  => '',
            'class' => '',
        ]);

        $resolver->setAllowedTypes('text', 'string');
        $resolver->setAllowedTypes('class', 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesCollection(AttributeCollection $collection)
    {
        parent::prepareAttributesCollection($collection);
        $collection->add(new Attribute('sText', $this->getOption('text')));
    }
}
