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
use WellCommerce\Bundle\CoreBundle\Form\Elements\Attribute;
use WellCommerce\Bundle\CoreBundle\Form\Elements\AttributeCollection;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementAttribute;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementAttributeCollection;
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
            'onClick'                          => false,
            'onDuplicate'                      => false,
            'onAdd'                            => false,
            'onAfterAdd'                       => false,
            'onDelete'                         => false,
            'onAfterDelete'                    => false,
            'onSaveOrder'                      => false,
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
            'onClick'                          => ['string', 'bool'],
            'onDuplicate'                      => ['string', 'bool'],
            'onAdd'                            => ['string', 'bool'],
            'onAfterAdd'                       => ['string', 'bool'],
            'onDelete'                         => ['string', 'bool'],
            'onAfterDelete'                    => ['string', 'bool'],
            'onSaveOrder'                      => ['string', 'bool'],
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
    public function prepareAttributesCollection(AttributeCollection $collection)
    {
        parent::prepareAttributesCollection($collection);
        $collection->add(new Attribute('sAddLabel', $this->getOption('addLabel')));
        $collection->add(new Attribute('bSelectable', $this->getOption('selectable')));
        $collection->add(new Attribute('bChoosable', $this->getOption('choosable')));
        $collection->add(new Attribute('bClickable', $this->getOption('clickable')));
        $collection->add(new Attribute('bDeletable', $this->getOption('deletable')));
        $collection->add(new Attribute('bAddable', $this->getOption('addable')));
        $collection->add(new Attribute('iTotal', $this->getOption('total')));
        $collection->add(new Attribute('iRestrict', $this->getOption('restrict')));
        $collection->add(new Attribute('oItems', $this->getOption('items')));
        $collection->add(new Attribute('fOnClick', $this->getOption('onClick')));
        $collection->add(new Attribute('fOnDuplicate', $this->getOption('onDuplicate')));
        $collection->add(new Attribute('fOnAdd', $this->getOption('onAdd')));
        $collection->add(new Attribute('fOnAfterAdd', $this->getOption('onAfterAdd')));
        $collection->add(new Attribute('fOnDelete', $this->getOption('onDelete')));
        $collection->add(new Attribute('fOnAfterDelete', $this->getOption('onAfterDelete')));
        $collection->add(new Attribute('fOnSaveOrder', $this->getOption('onSaveOrder')));
        $collection->add(new Attribute('sActive', $this->getOption('active')));
        $collection->add(new Attribute('sOnAfterDeleteId', $this->getOption('onAfterDeleteId')));
        $collection->add(new Attribute('sAddItemPrompt', $this->getOption('add_item_prompt')));
        $collection->add(new Attribute('bPreventDuplicates', $this->getOption('prevent_duplicates')));
        $collection->add(new Attribute('bPreventDuplicatesOnAllLevels', $this->getOption('prevent_duplicates_on_all_levels')));
    }
}
