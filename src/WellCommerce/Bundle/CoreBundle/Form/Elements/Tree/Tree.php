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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements\Tree;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\CoreBundle\Form\Elements\AbstractField;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;

/**
 * Class Tree
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Tree extends AbstractTree implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefined([
            'addLabel',
            'selectable',
            'selector',
            'choosable',
            'clickable',
            'deletable',
            'sortable',
            'retractable',
            'addable',
            'total',
            'restrict',
            'items',
            'onClick',
            'onDuplicate',
            'onAdd',
            'onAfterAdd',
            'onDelete',
            'onAfterDelete',
            'onSaveOrder',
            'active',
            'onAfterDeleteId',
            'add_item_prompt',
            'getchildren',
            'prevent_duplicates',
            'prevent_duplicates_on_all_levels',
            'set',
            'clickable_root',
        ]);

        $total = function (Options $options) {
            return count($options['items']);
        };

        $resolver->setDefaults([
            'total' => $total,
        ]);

        $resolver->setAllowedTypes([
            'addLabel'                         => 'string',
            'selectable'                       => 'bool',
            'selector'                         => 'string',
            'choosable'                        => 'bool',
            'clickable'                        => 'bool',
            'deletable'                        => 'bool',
            'sortable'                         => 'bool',
            'retractable'                      => 'bool',
            'addable'                          => 'bool',
            'total'                            => 'int',
            'items'                            => ['array', 'null'],
            'onClick'                          => 'string',
            'onDuplicate'                      => 'string',
            'onAdd'                            => 'string',
            'onAfterAdd'                       => 'string',
            'onDelete'                         => 'string',
            'onAfterDelete'                    => 'string',
            'onSaveOrder'                      => 'string',
            'active'                           => ['string', 'array', 'int'],
            'onAfterDeleteId'                  => 'int',
            'add_item_prompt'                  => 'string',
            'getchildren'                      => 'object',
            'prevent_duplicates'               => 'bool',
            'prevent_duplicates_on_all_levels' => 'bool',
            'clickable_root'                   => 'bool',
            'set'                              => 'string',
        ]);
    }
}
