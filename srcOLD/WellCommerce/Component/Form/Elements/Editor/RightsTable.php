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

namespace WellCommerce\Component\Form\Elements\Editor;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\Form\Elements\AbstractField;
use WellCommerce\Component\Form\Elements\Attribute;
use WellCommerce\Component\Form\Elements\AttributeCollection;
use WellCommerce\Component\Form\Elements\ElementInterface;

/**
 * Class RangeEditor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RightsTable extends AbstractField implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'actions',
            'controllers',
        ]);

        $resolver->setDefaults([
            'actions'     => $this->prepareActions(),
            'controllers' => []
        ]);

        $resolver->setAllowedTypes('actions', 'array');
        $resolver->setAllowedTypes('controllers', 'array');
    }

    /**
     * @return array
     */
    protected function getActions()
    {
        return [
            'index',
            'add',
            'edit',
            'delete',
            'view',
            'duplicate',
            'confirm',
            'grid',
        ];
    }

    /**
     * @return array
     */
    protected function prepareActions()
    {
        $actions = [];
        foreach ($this->getActions() as $action) {
            $actions[] = [
                'name' => $action,
                'id'   => $action
            ];
        }

        return $actions;
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesCollection(AttributeCollection $collection)
    {
        parent::prepareAttributesCollection($collection);
        $collection->add(new Attribute('asControllers', $this->getOption('controllers'), Attribute::TYPE_ARRAY));
        $collection->add(new Attribute('asActions', $this->getOption('actions'), Attribute::TYPE_ARRAY));
    }
}
