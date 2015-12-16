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

namespace WellCommerce\Component\Form\Elements\Tree;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\Form\Elements\Attribute;
use WellCommerce\Component\Form\Elements\AttributeCollection;
use WellCommerce\Component\Form\Elements\ElementInterface;

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

        $resolver->setAllowedTypes('addLabel', 'string');
        $resolver->setAllowedTypes('selectable', 'bool');
        $resolver->setAllowedTypes('choosable', 'bool');
        $resolver->setAllowedTypes('clickable', 'bool');
        $resolver->setAllowedTypes('deletable', 'bool');
        $resolver->setAllowedTypes('sortable', 'bool');
        $resolver->setAllowedTypes('retractable', 'bool');
        $resolver->setAllowedTypes('addable', 'bool');
        $resolver->setAllowedTypes('total', 'int');
        $resolver->setAllowedTypes('items', 'array');
        $resolver->setAllowedTypes('onClick', ['string', 'bool']);
        $resolver->setAllowedTypes('onDuplicate', ['string', 'bool']);
        $resolver->setAllowedTypes('onAdd', ['string', 'bool']);
        $resolver->setAllowedTypes('onAfterAdd', ['string', 'bool']);
        $resolver->setAllowedTypes('onDelete', ['string', 'bool']);
        $resolver->setAllowedTypes('onAfterDelete', ['string', 'bool']);
        $resolver->setAllowedTypes('onSaveOrder', ['string', 'bool']);
        $resolver->setAllowedTypes('active', ['string', 'array', 'int']);
        $resolver->setAllowedTypes('onAfterDeleteId', 'int');
        $resolver->setAllowedTypes('add_item_prompt', 'string');
        $resolver->setAllowedTypes('prevent_duplicates', 'bool');
        $resolver->setAllowedTypes('prevent_duplicates_on_all_levels', 'bool');
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesCollection(AttributeCollection $collection)
    {
        parent::prepareAttributesCollection($collection);
        $collection->add(new Attribute('sAddLabel', $this->getOption('addLabel')));
        $collection->add(new Attribute('bSelectable', $this->getOption('selectable'), Attribute::TYPE_BOOLEAN));
        $collection->add(new Attribute('bChoosable', $this->getOption('choosable'), Attribute::TYPE_BOOLEAN));
        $collection->add(new Attribute('bClickable', $this->getOption('clickable'), Attribute::TYPE_BOOLEAN));
        $collection->add(new Attribute('bDeletable', $this->getOption('deletable'), Attribute::TYPE_BOOLEAN));
        $collection->add(new Attribute('bAddable', $this->getOption('addable'), Attribute::TYPE_BOOLEAN));
        $collection->add(new Attribute('iTotal', $this->getOption('total'), Attribute::TYPE_INTEGER));
        $collection->add(new Attribute('iRestrict', $this->getOption('restrict'), Attribute::TYPE_INTEGER));
        $collection->add(new Attribute('oItems', $this->getOption('items'), Attribute::TYPE_ARRAY));
        $collection->add(new Attribute('fOnClick', $this->getOption('onClick'), Attribute::TYPE_FUNCTION));
        $collection->add(new Attribute('fOnDuplicate', $this->getOption('onDuplicate'), Attribute::TYPE_FUNCTION));
        $collection->add(new Attribute('fOnAdd', $this->getOption('onAdd'), Attribute::TYPE_FUNCTION));
        $collection->add(new Attribute('fOnAfterAdd', $this->getOption('onAfterAdd'), Attribute::TYPE_FUNCTION));
        $collection->add(new Attribute('fOnDelete', $this->getOption('onDelete'), Attribute::TYPE_FUNCTION));
        $collection->add(new Attribute('fOnAfterDelete', $this->getOption('onAfterDelete'), Attribute::TYPE_FUNCTION));
        $collection->add(new Attribute('fOnSaveOrder', $this->getOption('onSaveOrder'), Attribute::TYPE_FUNCTION));
        $collection->add(new Attribute('sActive', $this->getOption('active')));
        $collection->add(new Attribute('sOnAfterDeleteId', $this->getOption('onAfterDeleteId')));
        $collection->add(new Attribute('sAddItemPrompt', $this->getOption('add_item_prompt')));
        $collection->add(new Attribute('bPreventDuplicates', $this->getOption('prevent_duplicates'), Attribute::TYPE_BOOLEAN));
        $collection->add(new Attribute('bPreventDuplicatesOnAllLevels',
            $this->getOption('prevent_duplicates_on_all_levels')));
    }
}
