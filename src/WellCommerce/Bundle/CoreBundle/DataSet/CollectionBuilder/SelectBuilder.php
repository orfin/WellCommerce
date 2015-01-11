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

namespace WellCommerce\Bundle\CoreBundle\DataSet\CollectionBuilder;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SelectBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class SelectBuilder extends AbstractDataSetCollectionBuilder implements DataSetCollectionBuilder
{
    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'value_key',
            'label_key',
        ]);

        $resolver->setDefaults([
            'value_key' => 'id',
            'label_key' => 'name',
            'limit'     => 100,
            'order_by'  => 'name',
            'order_dir' => 'asc',
        ]);

        $resolver->setAllowedTypes([
            'value_key' => ['string'],
            'label_key' => ['string'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getItems()
    {
        $rows = $this->getDataSetRows();

        return $this->makeOptions($rows);
    }

    /**
     * Processes dataset rows as select options
     *
     * @param array $rows
     *
     * @return array
     */
    private function makeOptions(array $rows)
    {
        $options = [];

        foreach ($rows as $row) {
            $this->makeOption($row, $options);
        }

        return $options;
    }

    /**
     * Processes single row
     *
     * @param $row
     * @param $options
     */
    private function makeOption($row, &$options)
    {
        $value           = $this->propertyAccessor->getValue($row, "[{$this->options['value_key']}]");
        $label           = $this->propertyAccessor->getValue($row, "[{$this->options['label_key']}]");
        $options[$value] = $label;
    }
}
