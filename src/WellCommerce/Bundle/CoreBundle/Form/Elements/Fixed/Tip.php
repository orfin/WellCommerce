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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements\Fixed;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;

/**
 * Class Tip
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Tip extends AbstractFixedField implements ElementInterface
{
    const UP        = 'up';
    const DOWN      = 'down';
    const EXPANDED  = 'expanded';
    const RETRACTED = 'retracted';

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'tip',
            'direction',
            'short_tip',
        ]);

        $resolver->setDefaults([
            'name'      => '',
            'label'     => '',
            'short_tip' => ''
        ]);

        $resolver->setDefined([
            'retractable',
            'default_state',
        ]);

        $resolver->setDefaults([
            'direction'   => self::DOWN,
            'retractable' => function (Options $options) {
                return (strlen($options['short_tip']) > 0);
            }
        ]);

        $resolver->setAllowedValues([
            'direction'     => [self::UP, self::DOWN],
            'default_state' => [self::EXPANDED, self::RETRACTED]
        ]);

        $resolver->setAllowedTypes([
            'tip'           => 'string',
            'direction'     => 'string',
            'short_tip'     => 'string',
            'retractable'   => 'bool',
            'default_state' => 'string',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesJs()
    {
        return [
            $this->formatAttributeJs('tip', 'sTip'),
            $this->formatAttributeJs('direction', 'sDirection'),
            $this->formatAttributeJs('short_tip', 'sShortTip'),
            $this->formatAttributeJs('retractable', 'bRetractable', ElementInterface::TYPE_BOOLEAN),
            $this->formatAttributeJs('default_state', 'sDefaultState'),
            $this->formatDependencyJs()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function renderStatic()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function populate($value)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function setPropertyPath()
    {
        $this->attributes['property_path'] = null;
    }
}
