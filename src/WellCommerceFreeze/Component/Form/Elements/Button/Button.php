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

namespace WellCommerce\Component\Form\Elements\Button;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\Form\Elements\Attribute;
use WellCommerce\Component\Form\Elements\AttributeCollection;

/**
 * Class Button
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class Button extends AbstractButton implements ButtonInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'icon'      => '',
            'css_class' => '',
            'url'       => '',
        ]);

        $resolver->setAllowedTypes('icon', 'string');
        $resolver->setAllowedTypes('url', 'string');
        $resolver->setAllowedTypes('css_class', 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesCollection(AttributeCollection $collection)
    {
        parent::prepareAttributesCollection($collection);
        $collection->add(new Attribute('sUrl', $this->getOption('url')));
        $collection->add(new Attribute('sCssClass', $this->getOption('css_class')));
    }

    public function getValue()
    {
        return '';
    }
}
