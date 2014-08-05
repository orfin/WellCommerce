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
use WellCommerce\Bundle\CoreBundle\Form\Node;

/**
 * Class Tip
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Tip extends Field implements ElementInterface
{

    const UP   = 'up';
    const DOWN = 'down';

    const EXPANDED  = 'expanded';
    const RETRACTED = 'retracted';

    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'tip',
            'direction'
        ]);

        $resolver->setDefaults([
            'direction' => self::DOWN
        ]);

        $resolver->setOptional([
            'name',
            'short_tip',
            'retractable',
            'default_state'
        ]);

        $resolver->setDefaults([
            'name'        => '',
            'retractable' => function (Options $options) {
                    return (isset($options['short_tip']) && strlen($options['short_tip']));
                },
        ]);

        $resolver->setAllowedValues(array(
            'direction'     => [self::UP, self::DOWN],
            'default_state' => [self::EXPANDED, self::RETRACTED]
        ));

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
        $attributes = Array(
            $this->formatAttributeJs('tip', 'sTip'),
            $this->formatAttributeJs('direction', 'sDirection'),
            $this->formatAttributeJs('short_tip', 'sShortTip'),
            $this->formatAttributeJs('retractable', 'bRetractable', ElementInterface::TYPE_BOOLEAN),
            $this->formatAttributeJs('default_state', 'sDefaultState'),
            $this->formatDependencyJs()
        );

        return $attributes;
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

}
