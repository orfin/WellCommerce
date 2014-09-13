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

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Price extends AbstractField implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolverInterface $resolver)
    {
        parent::configureAttributes($resolver);

        $resolver->setRequired([
            'prefixes',
            'vat_field',
            'vat_field_name',
        ]);

        $resolver->setOptional([
            'suffix',
        ]);

        $vatFieldName = function (Options $options) {
            if (isset($options['vat_field']) && $options['vat_field'] instanceof ElementInterface) {
                return $options['vat_field']->getName();
            }

            return null;
        };

        $resolver->setDefaults([
            'prefixes'       => ['net', 'gross'],
            'vat_field'      => null,
            'vat_field_name' => $vatFieldName,
        ]);

        $resolver->setAllowedTypes([
            'suffix'         => 'string',
            'prefixes'       => 'array',
            'vat_field'      => ['null', 'WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface'],
            'vat_field_name' => 'string',
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
            $this->formatAttributeJs('prefixes', 'asPrefixes'),
            $this->formatAttributeJs('error', 'sError'),
            $this->formatAttributeJs('vat_field_name', 'sVatField'),
            $this->formatRulesJs(),
            $this->formatDependencyJs(),
            $this->formatDefaultsJs()
        ];
    }

}
