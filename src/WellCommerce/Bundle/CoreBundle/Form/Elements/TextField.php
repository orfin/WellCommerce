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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TextField
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TextField extends AbstractField implements ElementInterface
{
    const SIZE_SHORT  = 'short';
    const SIZE_MEDIUM = 'medium';
    const SIZE_LONG   = 'long';

    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolverInterface $resolver)
    {
        parent::configureAttributes($resolver);

        $resolver->setOptional([
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

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesJs()
    {
        return [
            $this->formatAttributeJs('name', 'sName'),
            $this->formatAttributeJs('label', 'sLabel'),
            $this->formatAttributeJs('comment', 'sComment'),
            $this->formatAttributeJs('suffix', 'sSuffix'),
            $this->formatAttributeJs('prefix', 'sPrefix'),
            $this->formatAttributeJs('selector', 'sSelector'),
            $this->formatAttributeJs('wrap', 'sWrapClass'),
            $this->formatAttributeJs('class', 'sClass'),
            $this->formatAttributeJs('css_attribute', 'sCssAttribute'),
            $this->formatAttributeJs('max_length', 'iMaxLength'),
            $this->formatAttributeJs('error', 'sError'),
            $this->formatRepeatableJs(),
            $this->formatRulesJs(),
            $this->formatDependencyJs(),
            $this->formatDefaultsJs()
        ];
    }
}
