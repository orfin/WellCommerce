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

        $total = function (Options $options) {
            return count($options['items']);
        };

        $resolver->setDefaults([
            'items'                            => [],
            'addLabel'                         => '',
            'add_item_prompt'                  => '',
            'total'                            => $total,
            'addable'                          => false,
            'choosable'                        => false,
            'clickable'                        => false,
            'deletable'                        => false,
            'sortable'                         => false,
            'selectable'                       => false,
            'retractable'                      => false,
            'restrict'                         => 0,
            'onClick'                          => '',
            'onDuplicate'                      => '',
            'onAdd'                            => '',
            'onAfterAdd'                       => '',
            'onDelete'                         => '',
            'onAfterDelete'                    => '',
            'onSaveOrder'                      => '',
            'onAfterDeleteId'                  => 0,
            'prevent_duplicates'               => false,
            'prevent_duplicates_on_all_levels' => false,
            'active'                           => 0,
        ]);

        $resolver->setAllowedTypes([
            'addLabel'                         => 'string',
            'selectable'                       => 'bool',
            'choosable'                        => 'bool',
            'clickable'                        => 'bool',
            'deletable'                        => 'bool',
            'sortable'                         => 'bool',
            'retractable'                      => 'bool',
            'addable'                          => 'bool',
            'total'                            => 'int',
            'items'                            => 'array',
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
            'prevent_duplicates'               => 'bool',
            'prevent_duplicates_on_all_levels' => 'bool',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributes()
    {
        return parent::prepareAttributes() + [
            'sAddLabel'                     => $this->getOption('addLabel'),
            'bSelectable'                   => $this->getOption('selectable'),
            'bChoosable'                    => $this->getOption('choosable'),
            'bClickable'                    => $this->getOption('clickable'),
            'bDeletable'                    => $this->getOption('deletable'),
            'bAddable'                      => $this->getOption('addable'),
            'iTotal'                        => $this->getOption('total'),
            'iRestrict'                     => $this->getOption('restrict'),
            'oItems'                        => $this->getOption('items'),
            'fOnClick'                      => $this->getOption('onClick'),
            'fOnDuplicate'                  => $this->getOption('onDuplicate'),
            'fOnAdd'                        => $this->getOption('onAdd'),
            'fOnAfterAdd'                   => $this->getOption('onAfterAdd'),
            'fOnDelete'                     => $this->getOption('onDelete'),
            'fOnAfterDelete'                => $this->getOption('onAfterDelete'),
            'fOnSaveOrder'                  => $this->getOption('onSaveOrder'),
            'sActive'                       => $this->getOption('active'),
            'sOnAfterDeleteId'              => $this->getOption('onAfterDeleteId'),
            'sAddItemPrompt'                => $this->getOption('add_item_prompt'),
            'bPreventDuplicates'            => $this->getOption('prevent_duplicates'),
            'bPreventDuplicatesOnAllLevels' => $this->getOption('prevent_duplicates_on_all_levels'),
        ];
    }
}
